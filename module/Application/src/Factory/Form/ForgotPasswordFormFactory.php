<?php

declare(strict_types=1);

namespace Application\Factory\Form;

use Application\Form\ForgotPasswordForm;
use Application\InputFilter\ForgotPasswordInputFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ForgotPasswordFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return (new ForgotPasswordForm('ForgotPassword'))
            ->setInputFilter($container->get('InputFilterManager')->get(ForgotPasswordInputFilter::class, $options));
    }
}
