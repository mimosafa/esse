<?php

namespace Esse\Float;

use Esse\Scalar\ScalarInterface;

interface FloatInterface extends ScalarInterface
{
    /**
     * Gets a float value.
     *
     * @return float
     */
    public function value(): float;
}
