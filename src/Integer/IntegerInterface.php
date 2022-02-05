<?php

namespace Esse\Integer;

use Esse\Scalar\ScalarInterface;

interface IntegerInterface extends ScalarInterface
{
    /**
     * Gets the integer value.
     *
     * @return integer
     */
    public function value(): int;
}
