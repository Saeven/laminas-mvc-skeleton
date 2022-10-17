<?php

declare(strict_types=1);

namespace Application\Listener;

use Application\Controller\VerificationController;
use Application\Entity\User;
use Application\Model\System;
use Application\Provider\Mail\MailProviderInterface;
use Application\Service\UserService;
use CirclicalUser\Entity\UserResetToken;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Module;
use hisorange\BrowserDetect\Parser;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;
use Laminas\View\Helper\ServerUrl;
use Laminas\View\Model\ViewModel;
use RuntimeException;

use function call_user_func;
use function in_array;
use function mail;
use function sprintf;

class RegistrationListener implements ListenerAggregateInterface
{
    private array $listeners;

    public function __construct(
        private ?User $authenticatedUser,
        private UserMapper $userMapper,
        private MailProviderInterface $mailProvider,
        private ServerUrl $urlHelper,
        private string $senderName,
        private string $senderEmail
    ) {
        $this->listeners = [];
    }

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        if (!Module::isConsole()) {
            $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'enforceUserValidation']);
            $this->listeners[] = $events->attach(User::EVENT_REGISTERED, [$this, 'sendVerificationToken']);
            $this->listeners[] = $events->attach(UserService::EVENT_RESET_EMAIL_REQUEST, [$this, 'sendForgotPasswordEmail']);
        }
    }

    /**
     * @inheritDoc
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function enforceUserValidation(MvcEvent $event): void
    {
        if (!($this->authenticatedUser && $routeMatch = $event->getRouteMatch())) {
            return;
        }

        if (in_array($routeMatch->getMatchedRouteName(), ['verification-resend', 'verification-check'])) {
            return;
        }

        if (!$this->authenticatedUser->getVerificationData()->isVerified()) {
            $routeMatch = new RouteMatch([
                'controller' => VerificationController::class,
                'action' => 'index',
            ]);
            $routeMatch->setMatchedRouteName('verification');
            $event->setRouteMatch($routeMatch);
        }
    }

    public function sendVerificationToken(EventInterface $event): void
    {
        /** @var User $user */
        $user = $event->getTarget();
        $verificationData = $user->getVerificationData();
        $this->userMapper->update($user);
        $siteURL = $this->getSiteUrl();

        $viewModel = (new ViewModel())
            ->setTerminal(true)
            ->setTemplate('emails/verify-email')
            ->setVariables([
                'company_url' => $siteURL,
                'company_name' => $this->senderName,
                'company_email' => $this->senderEmail,
                'logo_url' => $siteURL . '/assets/images/logo.svg',
                'ip_address' => System::getIP() ?? 'unknown ip',
                'reset_link' => sprintf(
                    "%s/register/verify/%s",
                    $siteURL,
                    $verificationData->getToken()
                ),
            ]);

        $this->mailProvider->send(
            $user,
            'Please Verify Your Account',
            $viewModel
        );
    }

    public function sendForgotPasswordEmail(EventInterface $event): void
    {
        $user = $event->getTarget();
        if (!$user instanceof User) {
            throw new RuntimeException("A User object was expected, but not received.");
        }

        $token = $event->getParam('token');
        if (!$token instanceof UserResetToken) {
            throw new RuntimeException("A UserResetToken should have been received as parameter, but such was not the case.");
        }

        $result = (new Parser(cache: null, request: null, config: []))->detect();

        $siteURL = $this->getSiteUrl();
        $viewModel = (new ViewModel())
            ->setTerminal(true)
            ->setTemplate('emails/forgot-password')
            ->setVariables([
                'company_url' => $siteURL,
                'company_name' => $this->senderName,
                'company_email' => $this->senderEmail,
                'logo_url' => $siteURL . '/assets/images/logo.svg',
                'operating_system' => $result->platformName(),
                'browser_name' => $result->browserName(),
                'ip_address' => System::getIP() ?? 'unknown ip',
                'reset_link' => sprintf(
                    "%s/reset/%s/%d",
                    $siteURL,
                    $token->getToken(),
                    $token->getId()
                ),
            ]);

        $this->mailProvider->send(
            $user,
            "Reset Your Password",
            $viewModel
        );
    }

    private function getSiteUrl(): string
    {
        return Module::isConsole() ? 'http://0.0.0.0:8080' : call_user_func($this->urlHelper);
    }
}
