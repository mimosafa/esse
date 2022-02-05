<?php

namespace Esse\String;

use Esse\Scalar\ScalarInterface;

interface StringInterface extends ScalarInterface
{
    /**
     * Gets the string value.
     *
     * @return string
     */
    public function value(): string;
}
