<?php

declare(strict_types=1);

namespace Application\Factory\Form;

use Application\Form\LoginForm;
use Application\InputFilter\LoginInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LoginFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $form = new LoginForm('Login');
        $form->setInputFilter($container->get('InputFilterManager')->get(LoginInputFilter::class, $options));

        return $form;
    }
}
