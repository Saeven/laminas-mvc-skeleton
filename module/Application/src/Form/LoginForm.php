<?php

namespace Application\Form;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;
use Circlical\TailwindForms\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        $this->setGenerateAlpineMarkup(true);
        parent::__construct($name, $options);
        $this->setAttributes([
            'class' => 'space-y-5',
        ]);
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
            'name' => 'submit',
            'type' => Button::class,
            'options' => [
                'label' => 'Submit',
                Form::BUTTON_TYPE => 'primary',
                Form::ADD_CLASSES => 'g-recaptcha w-full disabled:bg-indigo-300',
            ],
            'attributes' => [
                'type' => 'submit',
                'x-text' => "isSubmitting ? 'Submitting...' : 'Log In'",
                'x-bind:disabled' => 'isSubmitting',
                'x-bind:class' => "{'bg-green-500': success}",
            ],
        ]);

        $this->add([
            'name' => 'remember_me',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Remember me',
                'use_hidden_element' => true,
            ],
            'attributes' => [
                'class' => 'h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded',
            ],
        ]);

        $this->add([
            'name' => 'axis',
            'type' => Hidden::class,
        ]);
    }
}
