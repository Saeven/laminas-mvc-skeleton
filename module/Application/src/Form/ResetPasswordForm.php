<?php

declare(strict_types=1);

namespace Application\Form;

use Circlical\TailwindForms\Form\Form;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;

class ResetPasswordForm extends Form
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
                'label' => 'Your Email Address',
                'help-block' => "Just to make sure it's you!",
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
                'label' => "Create a New Password",
            ],
            'attributes' => [
                'maxlength' => 254,
                'autocomplete' => 'off',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'confirm_password',
            'type' => Password::class,
            'options' => [
                'label' => "Confirm New Password",
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
                'x-text' => "isSubmitting ? 'Submitting...' : 'Reset Password'",
                'x-bind:disabled' => 'isSubmitting',
                'x-bind:class' => "{'bg-green-500': success}",
            ],
        ]);

        $this->add([
            'name' => 'code',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);
    }
}
