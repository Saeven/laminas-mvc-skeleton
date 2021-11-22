<?php

namespace Application\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Laminas\Mvc\I18n\Translator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\Controller\Plugin\JsonWrapper;

class JsonWrapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new JsonWrapper(
            $container->get(Translator::class)
        );
    }
}