<?php

namespace Esse;

interface IntegerInterface extends ScalarInterface
{
    /**
     * Gets the integer value.
     *
     * @return integer
     */
    public function value(): int;
}
