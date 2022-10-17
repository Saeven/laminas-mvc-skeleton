<?php

declare(strict_types=1);

namespace Application\InputFilter;

use Application\Form\Filter\ArrayBlock;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;

use function _;

class ForgotPasswordInputFilter extends InputFilter
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
                        'message' => _("That email address has a typo in it, or its domain can't be checked"),
                    ],
                ],
            ],
        ]);
    }
}
