<?php

declare(strict_types=1);

namespace Application\Factory\Listener;

use Application\Listener\RegistrationListener;
use Application\Provider\Mail\MailProviderInterface;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class RegistrationListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new RegistrationListener(
            $container->get(AuthenticationService::class)->getIdentity(),
            $container->get(UserMapper::class),
            $container->get(MailProviderInterface::class)
        );
    }
}
