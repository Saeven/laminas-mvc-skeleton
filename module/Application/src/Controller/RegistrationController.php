<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\User;
use Application\Exception\VerificationException;
use Application\Form\RegisterForm;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AccessService;
use CirclicalUser\Service\AuthenticationService;
use DateTime;
use Exception;
use Laminas\EventManager\EventManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class RegistrationController extends AbstractActionController
{
    public function __construct(
        private RegisterForm $registerForm,
        private UserMapper $userMapper,
        private AccessService $accessService,
        private AuthenticationService $authenticationService,
        private EventManager $eventManager
    ) {
    }

    public function indexAction(): ViewModel|Response
    {
        if ($this->auth()->getIdentity()) {
            return $this->redirect()->toUrl('/');
        }

        $this->layout()->setTemplate('layout/layout-auth');

        $response = $this->getResponse();
        if ($response instanceof Response) {
            $response->getHeaders()
                ->addHeaderLine('Content-Encoding: identity')
                ->addHeaderLine('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
                ->addHeaderLine('Pragma: no-cache')
                ->addHeaderLine('Expires: ' . (new DateTime())->modify('-1 day')->format('D, d M Y H:i:s T'));
        }

        return new ViewModel([
            'registerForm' => $this->registerForm,
        ]);
    }

    public function submitAction(): JsonModel
    {
        return $this->json()->wrapForm($this->registerForm, $this->params()->fromPost(), function (User $user) {
            //
            // 1. Set extra data
            //
            $this->userMapper->save($user);

            //
            // 2. Assert role and auth
            //
            $this->accessService->setUser($user);
            $this->accessService->addRoleByName('user');
            $this->authenticationService->create(
                $user,
                $user->getEmail(),
                $this->registerForm->getInputFilter()?->getValue('password')
            );

            $this->eventManager->trigger(User::EVENT_REGISTERED, $user);

            return [
                'success' => true,
                'message' => "<b>Success!</b> Thanks for registering! Please wait while we redirect you to the main page.",
            ];
        });
    }

    public function verifyAction(): ViewModel|ResponseInterface
    {
        $this->layout()->setTemplate('layout/layout-auth');
        $success = false;

        try {
            /** @var User $user */
            $user = $this->auth()->requireIdentity();
            if ($user->getVerificationData()->isVerified()) {
                return $this->redirect()->toUrl('/');
            }

            if (!$user->getVerificationData()->verify($this->params()->fromRoute('verificationCode'))) {
                throw new VerificationException("That verification code was not accurate, please try again.");
            }

            $this->userMapper->update($user);
            $message = "Verification successful!";
            $success = true;
        } catch (Exception $x) {
            $message = $x->getMessage();
        }

        return new ViewModel([
            'message' => $message,
            'success' => $success,
        ]);
    }
}
