<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\User;
use Application\Form\LoginForm;
use CirclicalUser\Exception\BadPasswordException;
use CirclicalUser\Exception\NoSuchUserException;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function __construct(
        private LoginForm $loginForm
    ) {
    }

    /**
     * Display the form
     */
    public function indexAction(): ResponseInterface | ViewModel
    {
        if ($this->auth()->getIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        // this could be an auth redirect
        $this->layout()->setTemplate('layout/layout-auth');

        return new ViewModel([
            'loginForm' => $this->loginForm,
        ]);
    }

    public function submitAction(): JsonModel
    {
        return $this->json()->wrapForm($this->loginForm, $this->params()->fromPost(), function (array $sanitizedData) {
            try {
                $authenticationResult = $this->auth()->authenticate(
                    $sanitizedData['email'],
                    $sanitizedData['password']
                );

                if ($authenticationResult instanceof User) {
                    return "<b>Success!</b> Redirecting you shortly...";
                }
            } catch (NoSuchUserException | BadPasswordException) {
                throw new Exception("Sorry! That email and password combination was incorrect.");
            }
        });
    }
}
