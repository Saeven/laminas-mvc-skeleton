<?php

declare(strict_types=1);

namespace Application\Form\Filter;

use Laminas\Filter\FilterInterface;

use function array_shift;
use function array_values;
use function is_array;

class ArrayBlock implements FilterInterface
{
    public function filter(mixed $value): mixed
    {
        while (is_array($value)) {
            $arrayValues = array_values($value);
            $value = array_shift($arrayValues);
        }

        return $value;
    }
}
