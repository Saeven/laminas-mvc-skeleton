<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\ResetPasswordForm;
use CirclicalUser\Exception\InvalidResetTokenException;
use CirclicalUser\Exception\MismatchedResetTokenException;
use CirclicalUser\Exception\NoSuchUserException;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AuthenticationService;
use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class ResetPasswordController extends AbstractActionController
{
    public function __construct(
        private ResetPasswordForm $resetPasswordForm,
        private AuthenticationService $authenticationService,
        private UserMapper $userMapper
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

        $this->layout()->setTemplate('layout/layout-auth');

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Encoding: identity');

        $params = $this->params();

        $this->resetPasswordForm->setData([
            'code' => $params->fromRoute('code'),
            'id' => (int) $params->fromRoute('id'),
        ]);

        return new ViewModel([
            'resetForm' => $this->resetPasswordForm,
        ]);
    }

    public function submitAction(): JsonModel
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Encoding: identity');

        return $this->json()->wrapForm($this->resetPasswordForm, $this->params()->fromPost(), function (array $sanitizedData) {
            if (!$user = $this->userMapper->findByEmail(email: $sanitizedData['email'])) {
                throw new NoSuchUserException('Sorry! There was an error in your request. Contact support for help. [code:FP01]');
            }

            try {
                $this->authenticationService->setValidateIp(true);
                $this->authenticationService->changePasswordWithRecoveryToken(
                    user: $user,
                    tokenId: $sanitizedData['id'],
                    token: $sanitizedData['code'],
                    newPassword: $sanitizedData['password']
                );
                $this->authenticationService->authenticate($user->getEmail(), $sanitizedData['password']);
            } catch (InvalidResetTokenException) {
                throw new Exception("Sorry!  The request could not be verified. Please <a href='/forgot'>try anew</a>.");
            } catch (MismatchedResetTokenException) {
                throw new Exception("Sorry!  The email you've typed doesn't seem to be the right one?");
            }

            return "Welcome back! Your password has been reset. <a href='/'>Click here</a> to return to the main page.";
        });
    }
}
