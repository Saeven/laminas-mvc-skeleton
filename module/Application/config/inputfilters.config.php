<?php

declare(strict_types=1);

use Application\Factory\InputFilter\ForgotPasswordInputFilterFactory;
use Application\Factory\InputFilter\LoginInputFilterFactory;
use Application\Factory\InputFilter\RegisterInputFilterFactory;
use Application\InputFilter\ForgotPasswordInputFilter;
use Application\InputFilter\LoginInputFilter;
use Application\InputFilter\RegisterInputFilter;

return [
    'factories' => [
        RegisterInputFilter::class => RegisterInputFilterFactory::class,
        LoginInputFilter::class => LoginInputFilterFactory::class,
        ForgotPasswordInputFilter::class => ForgotPasswordInputFilterFactory::class,
    ],
];
