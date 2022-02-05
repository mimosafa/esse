<?php

namespace Esse\Scalar;

use Esse\Value\ValueInterface;

/**
 * Scalar value object interface
 */
interface ScalarInterface extends ValueInterface
{
    /**
     * Gets the scalar value.
     *
     * @return bool|int|float|string
     */
    public function value(): bool|int|float|string;
}
