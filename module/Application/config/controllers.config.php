<?php
return [
    'factories' => [
        \Application\Controller\TokenController::class => '\\Application\\Factory\\Controller\\TokenControllerFactory',
        \Application\Controller\LogoutController::class => '\\Application\\Factory\\Controller\\LogoutControllerFactory',
    ],
];
