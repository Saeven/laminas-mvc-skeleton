<?php

declare(strict_types=1);

namespace Application\Controller;

use CirclicalUser\Service\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Stdlib\ResponseInterface;

class LogoutController extends AbstractActionController
{
    public function __construct(
        private AuthenticationService $authenticationService
    ) {
    }

    public function logoutAction(): ResponseInterface
    {
        $this->authenticationService->clearIdentity();

        return $this->redirect()->toUrl('/');
    }
}
