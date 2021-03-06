<?php

namespace Newsio\Boundary;

use Newsio\Exception\BoundaryException;

class StringBoundary
{
    private string $value;

    /**
     * NullableStringBoundary constructor.
     * @param $value
     * @param string $message
     * @throws BoundaryException
     */
    public function __construct($value, string $message = 'Value must be a string')
    {
        if (is_string($value) && $value !== '') {
            $this->value = $value;
        } else {
            throw new BoundaryException($message, []);
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}