<?php

declare(strict_types=1);

namespace Application\Factory\Listener;

use Application\Listener\LayoutListener;
use CirclicalUser\Service\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LayoutListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LayoutListener(
            authenticationService: $container->get(AuthenticationService::class),
        );
    }
}
