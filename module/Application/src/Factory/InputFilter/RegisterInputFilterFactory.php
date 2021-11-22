<?php

namespace Application\Factory\InputFilter;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Application\InputFilter\RegisterInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RegisterInputFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RegisterInputFilter(
            $container->get(EntityManager::class)
        );
    }
}
