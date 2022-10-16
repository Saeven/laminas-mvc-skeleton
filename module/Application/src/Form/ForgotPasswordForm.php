<?php

declare(strict_types=1);

namespace Application\Form;

use Circlical\TailwindForms\Form\Form;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Text;

use function _;

class ForgotPasswordForm extends Form
{
    public function __construct(?string $name = null, ?array $options = [])
    {
        $this->setGenerateAlpineMarkup(true);
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'email',
            'type' => Text::class,
            'options' => [
                'label' => _('Email'),
            ],
            'attributes' => [
                'maxlength' => 254,
                'required' => true,
                'autofocus' => true,
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Button::class,
            'options' => [
                'label' => 'Submit',
                Form::BUTTON_TYPE => 'primary',
                Form::ADD_CLASSES => 'g-recaptcha w-full disabled:bg-indigo-300',
            ],
            'attributes' => [
                'type' => 'submit',
                'x-text' => "isSubmitting ? 'Submitting...' : 'Reset Password'",
                'x-bind:disabled' => 'isSubmitting',
                'x-bind:class' => "{'bg-green-500': success}",
            ],
        ]);
    }
}
