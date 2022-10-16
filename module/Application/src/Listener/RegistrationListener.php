<?php

declare(strict_types=1);

namespace Application\Listener;

use Application\Controller\VerificationController;
use Application\Entity\User;
use Application\Provider\Mail\MailProviderInterface;
use Application\Service\UserService;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Module;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Mvc\I18n\Translator;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;

use Laminas\View\Model\ViewModel;
use ZfcTwig\View\TwigRenderer;

use function in_array;
use function mail;
use function sprintf;

class RegistrationListener implements ListenerAggregateInterface
{
    private array $listeners;

    public function __construct(
        private ?User $authenticatedUser,
        private UserMapper $userMapper,
        private MailProviderInterface $mailProvider
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

        // you'd probably want to make this defer to a mailing service (SES, Mailgun, etc.) in the real world
        // just here as is for example's sake
        mail(
            $user->getEmail(),
            'Please Verify Your Account',
            sprintf("Your validation link is http://0.0.0.0:8080/register/verify/%s", $verificationData->getToken())
        );
    }

    public function sendForgotPasswordEmail(EventInterface $event): void
    {
        $user = $event->getTarget();
        $token = $event->getParam('token');

        $viewModel = (new ViewModel())
            ->setTerminal(true)
            ->setTemplate('emails/forgot-password')
            ->setVariables([
                'token' => $token,
            ]);

        $this->mailProvider->send(
            $user,
            "Reset Your Password",
            $viewModel
        );
    }
}
