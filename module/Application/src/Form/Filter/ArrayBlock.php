<?php

namespace Application\Form\Filter;

use Laminas\Filter\FilterInterface;

class ArrayBlock implements FilterInterface
{
    public function filter($value)
    {
        while (is_array($value)) {
            $arrayValues = array_values($value);
            $value = array_shift($arrayValues);
        }

        return $value;
    }
}
