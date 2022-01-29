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
     * Check the equivalence of this instance and a given one, only with their values.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isEqual($value): bool;

    /**
     * Check the equivalence of this instance and a given one, not only with their values but also their classes.
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
