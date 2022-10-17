<?php

declare(strict_types=1);

namespace Application\Factory\Form;

use Application\Form\ResetPasswordForm;
use Application\InputFilter\ResetPasswordInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ResetPasswordFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return (new ResetPasswordForm('ResetPassword'))
            ->setInputFilter($container->get('InputFilterManager')->get(ResetPasswordInputFilter::class, $options));
    }
}
