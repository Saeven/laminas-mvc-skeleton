<?php

declare(strict_types=1);

namespace Application\Factory\View\Helper;

use Circlical\AsseticBundle\View\Helper\Asset;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class AssetHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new Asset($container);
    }
}
