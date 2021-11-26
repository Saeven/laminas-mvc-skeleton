<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\ApplicationTokenScopeInterface;
use CirclicalUser\Entity\UserApiToken;
use CirclicalUser\Mapper\UserMapper;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class TokenController extends AbstractActionController
{
    public function __construct(
        private UserMapper $userMapper
    ) {
    }

    public function addAction(): JsonModel
    {
        return $this->json()->wrap(function () {
            $user = $this->auth()->requireIdentity();
            $token = new UserApiToken($user, ApplicationTokenScopeInterface::SCOPE_BASIC);

            $user->addApiToken($token);
            $this->userMapper->update($user);

            return ['updated_tokens' => $user->getApiTokenArray()];
        });
    }

    public function deleteAction(): JsonModel
    {
        return $this->json()->wrap(function () {
            $tokenId = $this->params()->fromPost('token');

            $user = $this->auth()->requireIdentity();
            if (!$apiToken = $user->findApiTokenWithId($tokenId)) {
                throw new \Exception("Sorry, no such token was found.");
            }

            $user->removeApiToken($apiToken);
            $this->userMapper->update($user);

            return ['updated_tokens' => $user->getApiTokenArray()];
        });
    }
}
