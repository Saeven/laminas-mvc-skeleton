<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\User;
use Laminas\EventManager\EventManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class VerificationController extends AbstractActionController
{
    public function __construct(
        private EventManager $eventManager
    ) {
    }

    public function indexAction(): Response|ViewModel
    {
        if (($user = $this->auth()->getIdentity()) && $user->getVerificationData()->isVerified()) {
            return $this->redirect()->toRoute('home');
        }

        $this->eventManager->trigger(User::EVENT_REGISTERED, $user);

        // this could be an auth redirect
        $this->layout()->setTemplate('layout/layout-auth');

        return new ViewModel();
    }

    public function resendAction(): JsonModel
    {
        return $this->json()->wrap(function () {
            $user = $this->auth()->requireIdentity();

            $this->eventManager->trigger(User::EVENT_REGISTERED, $user);

            return "Verification email successfully resent.";
        });
    }
}
