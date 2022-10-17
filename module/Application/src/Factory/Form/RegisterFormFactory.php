<?php

declare(strict_types=1);

namespace Application\Factory\Form;

use Application\Entity\User;
use Application\Form\RegisterForm;
use Application\InputFilter\RegisterInputFilter;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RegisterFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return (new RegisterForm('RegisterForm', $options))
            ->setHydrator(new DoctrineHydrator($container->get('doctrine.entitymanager.orm_default'), false))
            ->setInputFilter($container->get('InputFilterManager')->get(RegisterInputFilter::class, $options))
            ->setObject(new User(email: ''));
    }
}
