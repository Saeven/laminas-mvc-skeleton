<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\User;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class VerificationController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var User $user */
        if (($user = $this->auth()->getIdentity()) && $user->getVerificationData()->isVerified()) {
            return $this->redirect()->toRoute('main');
        }

        // this could be an auth redirect
        $this->layout()->setTemplate('layout/layout-auth');

        return new ViewModel();
    }
}
