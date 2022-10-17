<?php

declare(strict_types=1);

namespace Application\Factory\Controller\Plugin;

use Application\Controller\Plugin\JsonWrapper;
use Laminas\Mvc\I18n\Translator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class JsonWrapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new JsonWrapper(
            $container->get(Translator::class)
        );
    }
}
