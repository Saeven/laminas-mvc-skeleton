<?php

declare(strict_types=1);

namespace Application\Factory\InputFilter;

use Application\InputFilter\LoginInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class LoginInputFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new LoginInputFilter();
    }
}
