<?php

declare(strict_types=1);

namespace Application\Factory\InputFilter;

use Application\InputFilter\RegisterInputFilter;
use Doctrine\ORM\EntityManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RegisterInputFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new RegisterInputFilter(
            $container->get(EntityManager::class)
        );
    }
}
