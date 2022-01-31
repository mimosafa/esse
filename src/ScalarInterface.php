<?php

namespace Esse;

use ValueError;

/**
 * Pseudo scalar value interface
 *
 * @method mixed value()
 * @method bool isEqual(mixed $value)
 * @method bool isIdentical(mixed $value)
 * @method static bool validate(mixed $value)
 * @method static static from(mixed $value)
 * @method static static|null tryFrom(mixed $value)
 */
interface ScalarInterface
{
    /**
     * Gets the scalar value.
     *
     * @return mixed
     */
    public function value();

    /**
     * Checks for equivalence with a given, only with their values.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isEqual($value): bool;

    /**
     * Checks for equivalence with a given, not only with their values but also their classes are strictly.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isIdentical($value): bool;

    /**
     * Validates a given value on a scalar.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool;

    /**
     * Gets an instance from a scalar value. If an invalid value is given, a ValueError will be thrown.
     *
     * @param mixed $value
     * @return static
     * @throws ValueError
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
