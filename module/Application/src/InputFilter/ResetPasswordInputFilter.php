<?php

declare(strict_types=1);

namespace Application\InputFilter;

use Application\Form\Filter\ArrayBlock;
use CirclicalUser\Validator\PasswordValidator;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Soflomo\Purifier\PurifierFilter;

class ResetPasswordInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => ArrayBlock::class],
                ['name' => StringTrim::class],
                ['name' => StringToLower::class],
            ],
            'validators' => [
                [
                    'name' => EmailAddress::class,
                    'options' => [
                        'useMxCheck' => false,
                        'useDeepMxCheck' => false,
                        'useDomainCheck' => false,
                        'message' => "That email address has a typo in it, or its domain can't be checked",
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

        $this->add([
            'name' => 'confirm_password',
            'required' => true,
            'filters' => [
                ['name' => ArrayBlock::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => Identical::class,
                    'options' => [
                        'message' => "The passwords you have typed don't match.",
                        'token' => 'password',
                        'strict' => true,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
    }
}
