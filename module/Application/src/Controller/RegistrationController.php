<?php

namespace Application\Controller;

use Application\Entity\User;
use Application\Form\RegisterForm;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AccessService;
use CirclicalUser\Service\AuthenticationService;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class RegistrationController extends AbstractActionController
{
    public function __construct(
        private RegisterForm $registerForm,
        private UserMapper $userMapper,
        private AccessService $accessService,
        private AuthenticationService $authenticationService
    ) {
    }

    public function indexAction(): ViewModel | Response
    {
        if ($this->auth()->getIdentity()) {
            return $this->redirect()->toUrl('/');
        }

        $this->layout()->setTemplate('layout/layout-auth');

        $viewModel = new ViewModel([
            'registerForm' => $this->registerForm,
        ]);

        return $viewModel;
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


            $this->getEventManager()->trigger(User::EVENT_REGISTERED, $user);

            return [
                'success' => true,
                'message' => "<b>Success!</b> Thanks for registering! Please wait while we redirect you to the main page.",
            ];
        });
    }
}
