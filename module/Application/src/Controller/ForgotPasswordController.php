<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\ForgotPasswordForm;
use Application\Service\UserService;
use CirclicalUser\Exception\NoSuchUserException;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class ForgotPasswordController extends AbstractActionController
{
    public function __construct(
        private ForgotPasswordForm $forgotPasswordForm,
        private UserService $userService
    ) {
    }

    /**
     * Display the form
     */
    public function indexAction(): Response|ViewModel
    {
        if ($this->auth()->getIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        // this could be an auth redirect
        $this->layout()->setTemplate('layout/layout-auth');

        $response = $this->getResponse();
        if ($response instanceof Response) {
            $response->getHeaders()->addHeaderLine('Content-Encoding: identity');
        }

        return new ViewModel([
            'forgotForm' => $this->forgotPasswordForm,
        ]);
    }

    public function submitAction(): JsonModel
    {
        return $this->json()->wrapForm($this->forgotPasswordForm, $this->params()->fromPost(), function (array $sanitizedData) {
            try {
                $this->userService->initiatePasswordRecovery(
                    emailAddress: $sanitizedData['email'],
                );
            } catch (NoSuchUserException) {
            }

            return "Thank you. If your email address was in our database, we'll have sent instructions on how to reset your password.";
        });
    }
}
