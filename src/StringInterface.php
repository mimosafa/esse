<?php

namespace Esse;

use Stringable;

interface StringInterface extends Stringable, ScalarInterface
{
    /**
     * Get a string value.
     *
     * @return string
     */
    public function value(): string;
}
