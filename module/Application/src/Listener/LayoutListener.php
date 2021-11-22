<?php

namespace Application\Listener;

use Application\Mapper\ConfigurationMapper;
use Application\Service\Storage\StorageInterface;
use CirclicalUser\Service\AuthenticationService;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Mvc\Application;
use Laminas\Mvc\MvcEvent;
use SilverStar\Model\OptionsProvider;
use SilverStar\Service\CurrencyService;

class LayoutListener implements ListenerAggregateInterface
{
    private array $listeners;

    public function __construct(
        private AuthenticationService $authenticationService,
    ) {
        $this->listeners = [];
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        if (!\CirclicalUser\Module::isConsole()) {
            $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'attachLayoutData']);
            $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'prepareException']);
            $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'prepareException']);
        }
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function attachLayoutData(MvcEvent $event): void
    {
        $viewModel = $event->getViewModel();

        if (($routeMatch = $event->getRouteMatch()) && $routeMatch->getParam('clean') === true) {
            return;
        }

        //
        // 1. Always set locale
        //
        $viewModel->setVariables([
            'locale' => \Locale::getDefault(),
        ]);

        $request = $event->getRequest();
        if ($request instanceof Request && $request->isXmlHttpRequest()) {
            return;
        }


        //
        // 2. Set User data, if available
        //
        $variables['user'] = $this->authenticationService->getIdentity();

        $viewModel->setVariables($variables);
        foreach ($viewModel->getChildren() as $childView) {
            $childView->setVariables($variables);
        }
    }

    public function prepareException(MvcEvent $event)
    {
        $error = $event->getError();
        if (!empty($error) && !$event->getResult() instanceof Response) {
            switch ($error) {
                case Application::ERROR_CONTROLLER_NOT_FOUND:
                case Application::ERROR_CONTROLLER_INVALID:
                case Application::ERROR_ROUTER_NO_MATCH:
                    // Specifically not handling these
                    return;

                case Application::ERROR_EXCEPTION:
                default:
                    $response = $event->getResponse();
//                    if (!$response || $response->getStatusCode() === 200) {
//                        header('HTTP/1.0 500 Internal Server Error', true, 500);
//                    }
                    if ($response instanceof Response && $response->getStatusCode() !== Response::STATUS_CODE_200) {
                        $response->setStatusCode(Response::STATUS_CODE_200);
                    }

                    $isAjax = false;
                    if ($event->getRequest() instanceof Request && $event->getRequest()->isXmlHttpRequest()) {
                        $isAjax = true;
                    }

                    $exception = $event->getParam('exception');
                    $viewModel = $event->getViewModel();
                    $viewModel
                        ->setTerminal(true)
                        ->setTemplate($isAjax ? 'error/index-ajax' : 'error/index')
                        ->setVariables([
                            'errorClass' => get_class($exception),
                            'controller' => $event->getParam('controller-class'),
                            'exception' => $exception,
                            'exceptionTrace' => str_replace(getcwd(), '', $exception->getTraceAsString()),
                        ]);
                    break;
            }
        }
    }
}
