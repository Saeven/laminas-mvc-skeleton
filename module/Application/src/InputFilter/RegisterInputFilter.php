<?php

declare(strict_types=1);

namespace Application\InputFilter;

use Application\Entity\User;
use Application\Form\Filter\ArrayBlock;
use CirclicalUser\Validator\PasswordValidator;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Soflomo\Purifier\PurifierFilter;

use function _;

class RegisterInputFilter extends InputFilter
{
    public function __construct(
        private EntityManager $entityManager
    ) {
    }

    public function init()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => ArrayBlock::class],
                ['name' => StringTrim::class],
                ['name' => PurifierFilter::class],
                ['name' => StringToLower::class],
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'useMxCheck' => true,
                        'useDeepMxCheck' => true,
                        'useDomainCheck' => true,
                        'message' => _("That email address has a typo in it, or its domain can't be checked"),
                    ],
                ],
                [
                    'name' => NoObjectExists::class,
                    'options' => [
                        'fields' => ['email'],
                        'messages' => [
                            NoObjectExists::ERROR_OBJECT_FOUND => _("That email is already taken, please log in instead"),
                        ],
                        'object_repository' => $this->entityManager,
                        'target_class' => User::class,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'email_confirm',
            'required' => true,
            'filters' => [
                ['name' => ArrayBlock::class],
                ['name' => StringTrim::class],
                ['name' => PurifierFilter::class],
                ['name' => StringToLower::class],
            ],
            'validators' => [
                [
                    'name' => Identical::class,
                    'options' => [
                        'message' => _('Your email and confirmation email are different'),
                        'token' => 'email',
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => ArrayBlock::class],
                ['name' => StringTrim::class],
                ['name' => PurifierFilter::class],
            ],
            'validators' => [
                [
                    'name' => PasswordValidator::class,
                    'options' => [
                        'user_data' => [
                            'email',
                            'first_name',
                            'last_name',
                        ],
                    ],
                ],
            ],
        ]);

        foreach (['first_name', 'last_name'] as $f) {
            $this->add([
                'name' => $f,
                'required' => true,
                'filters' => [
                    ['name' => ArrayBlock::class],
                    ['name' => StringTrim::class],
                    ['name' => PurifierFilter::class],
                ],
            ]);
        }
    }
}
