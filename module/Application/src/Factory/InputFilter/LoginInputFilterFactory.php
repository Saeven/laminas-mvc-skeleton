<?php

namespace Application\Factory\InputFilter;

use Interop\Container\ContainerInterface;
use Application\InputFilter\LoginInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoginInputFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LoginInputFilter();
    }
}
