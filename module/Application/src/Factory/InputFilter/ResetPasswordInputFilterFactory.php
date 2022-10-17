<?php

declare(strict_types=1);

namespace Application\Factory\InputFilter;

use Application\InputFilter\ResetPasswordInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ResetPasswordInputFilterFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ResetPasswordInputFilter();
    }
}
