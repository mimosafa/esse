<?php

namespace Esse;

use ValueError;

interface ScalarInterface
{
    /**
     * Get a scalar value.
     *
     * @return mixed
     */
    public function value();

    /**
     * Check if a given value is the same as one of the invoked instance.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isEqual($value): bool;

    /**
     * Check if a given value and its class is the same as these of the invoked instance.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isIdentical($value): bool;

    /**
     * Validate a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool;

    /**
     * Get instance from scalar value. If an invalid value is given, it will throw a ValueError.
     *
     * @param mixed $value
     * @return static
     * @throws ValueError
     */
    public static function from($value): static;

    /**
     * Get instance from scalar value. If an invalid value is given, it will return null.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static;
}
