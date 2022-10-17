<?php

declare(strict_types=1);

use Application\Factory\Form\ForgotPasswordFormFactory;
use Application\Factory\Form\LoginFormFactory;
use Application\Factory\Form\RegisterFormFactory;
use Application\Factory\Form\ResetPasswordFormFactory;
use Application\Form\ForgotPasswordForm;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Form\ResetPasswordForm;

return [
    'factories' => [
        RegisterForm::class => RegisterFormFactory::class,
        LoginForm::class => LoginFormFactory::class,
        ForgotPasswordForm::class => ForgotPasswordFormFactory::class,
        ResetPasswordForm::class => ResetPasswordFormFactory::class,
    ],
];
