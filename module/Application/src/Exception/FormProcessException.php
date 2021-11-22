<?php

namespace Application\Exception;

use Laminas\Form\Form;
use Throwable;

class FormProcessException extends \Exception
{
    public function __construct(
        private Form $form,
        $message = "",
        $code = 0,
        Throwable $previous = null

    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * AlpineJS needs a full list of errors, and doesn't like an object as
     * message list, so we list all elements of the form, and only send array values for error types.
     * This method is essentially an adapter between Laminas and AlpineJS
     */
    public function getFieldErrors(): array
    {
        $messageList = [];
        foreach ($this->form->getElements() as $element) {
            $elementName = $element->getName();
            $messageList[$elementName] = array_values($this->form->getMessages($elementName));
        }

        return $messageList;
    }
}
