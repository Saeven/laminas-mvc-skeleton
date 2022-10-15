<?php

namespace Application\Factory\View\Helper;

use Circlical\AsseticBundle\View\Helper\Asset;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

final class AssetHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new Asset($container);
    }
}

