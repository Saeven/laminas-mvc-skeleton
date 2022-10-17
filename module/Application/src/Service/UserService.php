<?php

declare(strict_types=1);

namespace Application\Service;

use CirclicalUser\Exception\NoSuchUserException;
use CirclicalUser\Exception\PasswordResetProhibitedException;
use CirclicalUser\Exception\TooManyRecoveryAttemptsException;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AuthenticationService;
use Laminas\EventManager\EventManagerInterface;

final class UserService
{
    public const EVENT_RESET_EMAIL_REQUEST = 'user.forgot.request';

    public function __construct(
        private AuthenticationService $authenticationService,
        private EventManagerInterface $eventManager,
        private UserMapper $userMapper
    ) {
    }

    /**
     * @throws NoSuchUserException
     * @throws PasswordResetProhibitedException
     * @throws TooManyRecoveryAttemptsException
     */
    public function initiatePasswordRecovery(string $emailAddress): void
    {
        if (!$user = $this->userMapper->findByEmail($emailAddress)) {
            throw new NoSuchUserException();
        }

        $this->eventManager->trigger(
            self::EVENT_RESET_EMAIL_REQUEST,
            $user,
            [
                'token' => $this->authenticationService->createRecoveryToken($user),
            ]
        );
    }
}
