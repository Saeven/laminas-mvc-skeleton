<?php

return [
    'circlical' => [
        'user' => [

            /**
             * Configuration settings for the access service
             */
            'access' => [

                'superadmin' => [

                    /**
                     * Superadmin role name, will be sought in the DB when configured.  Please ensure that your
                     * Role entity with this name exists prior to configuration.
                     */
                    'role_name' => 'super admin',

                    /**
                     * If the role was named in config, yet the entity was missing, do we crash and burn?
                     */
                    'throw_exception_when_missing' => false,
                ],
            ],

            /*
             * If you are using Doctrine, you simply to specify the Entity you plan to use. It'll get substituted into
             * the CirclicalUser relationships during Bootstrap.  If you are using Doctrine and want to use
             * the default entities and relationships (recommended) -- this is the only config you need!
             */
            'doctrine' => [
                'entity' => \Application\Entity\User::class,
            ],

            'password_strength_checker' => [
                'implementation' => \CirclicalUser\Service\PasswordChecker\Zxcvbn::class,
                'config' => [
                    'required_strength' => 3,
                ],
            ],

            /*
             * These parameters are used whether you use Doctrine or no.  They tell the authentication service
             * how to behave.
             */
            'auth' => [

                'secure_cookies' => static function () {
                    return \Application\Model\System::isSSL();
                },

                // Lax is required, instead of Strict, or SSO breaks
                'samesite_policy' => 'Lax',

                /*
                 * A Base64-encoded key, as generated by Halite's key factory
                 * base64_encode( KeyFactory::generateEncryptionKey()->getRawKeyMaterial() );
                 */
                'crypto_key' => 'sfZGFm1rCc7TgPr9aly3WOtAfbEOb/VafB8L3velkd0=',

                /*
                 * Destroy auth cookies when the session ends? (cookie lifespan of 0)
                 */
                'transient' => false,

                /*
                 * Forgot password functionality
                 */
                'password_reset_tokens' => [

                    /*
                     * However you slice it, forgotten password functionality is a back-door; it's unfortunately often necessary. If you set this to 'true',
                     * you will need to configure a reset provider.
                     */
                    'enabled' => false,

                    /*
                     * Validate browser fingerprints during the token verification process
                     */
                    'validate_fingerprint' => true,

                    /*
                     * Make sure that the request IP matches the verification IP
                     */
                    'validate_ip' => false,

                ],
            ],


            /*
             * When a user tries to access a page gated by auth, or rights - what do we do with them?
             * This user module provides a simple 'Redirect' strategy, but you can also roll your own
             */

            'deny_strategy' => [

                /*
                 * The strategy provider, that implements CirclicalUser\Provider\DenyStrategyInterface
                 */
//                'class' => '',

                /*
                 * Options specifically required by RedirectStrategy.  You would probably comment this out if you were
                 * to roll your own.
                 */
//                'options' => [
//                    'controller' => \Lemonade\Controller\AuthController::class,
//                    'action' => 'login',
//                ],
            ],

        ],
    ],
];