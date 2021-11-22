<?php

namespace Application\Factory\Listener;

use Application\Listener\LayoutListener;
use CirclicalUser\Service\AuthenticationService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LayoutListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LayoutListener(
            authenticationService: $container->get(AuthenticationService::class),
        );
    }
}
