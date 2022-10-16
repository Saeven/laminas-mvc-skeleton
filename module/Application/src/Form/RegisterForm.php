<?php

declare(strict_types=1);

namespace Application\Form;

use Circlical\TailwindForms\Form\Form;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;

use function _;

class RegisterForm extends Form
{
    public function __construct(
        ?string $name = null,
        ?array $options = [],
    ) {
        $this->setGenerateAlpineMarkup(true);
        parent::__construct($name, $options ?? []);
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
            'name' => 'email_confirm',
            'type' => Text::class,
            'options' => [
                'label' => _('Confirm Your Email'),
            ],
            'attributes' => [
                'maxlength' => 254,
                'required' => true,
                'autofocus' => true,
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => _("Password"),
            ],
            'attributes' => [
                'maxlength' => 254,
                'autocomplete' => 'off',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => Text::class,
            'options' => [
                'label' => _("First Name"),
            ],
            'attributes' => [
                'maxlength' => 254,
                'autocomplete' => 'off',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'last_name',
            'type' => Text::class,
            'options' => [
                'label' => _("Last Name"),
            ],
            'attributes' => [
                'maxlength' => 254,
                'autocomplete' => 'off',
                'required' => true,
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
                'x-text' => "isSubmitting ? 'Submitting...' : 'Create Account'",
                'x-bind:disabled' => 'isSubmitting',
                'x-bind:class' => "{'bg-green-500': success}",
            ],
        ]);
    }
}
