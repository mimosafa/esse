<?php

namespace Esse;

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

    /**
     * Gets an instance from a scalar value. If an invalid value is given, a ValueError will be thrown.
     *
     * @param mixed $value
     * @return static
     */
    public static function from($value): static;

    /**
     * Gets an instance from a scalar value. If an invalid value is given, null is returned.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static;
}
