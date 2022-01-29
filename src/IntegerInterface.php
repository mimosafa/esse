<?php

namespace Esse;

interface IntegerInterface extends ScalarInterface
{
    /**
     * Get a integer value.
     *
     * @return integer
     */
    public function value(): int;
}
