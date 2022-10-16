<?php

declare(strict_types=1);

namespace Application\Factory\Service;

use Application\Service\UserService;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new UserService(
            authenticationService: $container->get(AuthenticationService::class),
            eventManager: $container->get('Application')->getEventManager(),
            userMapper: $container->get(UserMapper::class)
        );
    }
}
