<?php

declare(strict_types=1);

namespace Application\Exception;

use Exception;
use Laminas\Form\FormInterface;
use Throwable;

use function array_values;

class FormProcessException extends Exception
{
    public function __construct(
        private FormInterface $form,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
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
