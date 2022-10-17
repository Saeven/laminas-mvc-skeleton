<?php

declare(strict_types=1);

use Application\Factory\InputFilter\ForgotPasswordInputFilterFactory;
use Application\Factory\InputFilter\LoginInputFilterFactory;
use Application\Factory\InputFilter\RegisterInputFilterFactory;
use Application\Factory\InputFilter\ResetPasswordInputFilterFactory;
use Application\InputFilter\ForgotPasswordInputFilter;
use Application\InputFilter\LoginInputFilter;
use Application\InputFilter\RegisterInputFilter;
use Application\InputFilter\ResetPasswordInputFilter;

return [
    'factories' => [
        RegisterInputFilter::class => RegisterInputFilterFactory::class,
        LoginInputFilter::class => LoginInputFilterFactory::class,
        ForgotPasswordInputFilter::class => ForgotPasswordInputFilterFactory::class,
        ResetPasswordInputFilter::class => ResetPasswordInputFilterFactory::class,
    ],
];
