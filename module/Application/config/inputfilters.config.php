<?php
return [
    'factories' => [
        \Application\InputFilter\RegisterInputFilter::class => \Application\Factory\InputFilter\RegisterInputFilterFactory::class,
        \Application\InputFilter\LoginInputFilter::class => \Application\Factory\InputFilter\LoginInputFilterFactory::class,
    ],
];
