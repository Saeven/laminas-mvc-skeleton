<?php

declare(strict_types=1);

namespace Application\InputFilter;

use Application\Form\Filter\ArrayBlock;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;

use function _;

class LoginInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'remember_me',
            'required' => false,
        ]);

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
                        'message' => _("That email address has a typo in it, or its domain can't be checked"),
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
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'message' => _("Your password must be at least 8 characters long"),
                        'min' => 8,
                    ],
                ],
            ],
        ]);
    }
}
