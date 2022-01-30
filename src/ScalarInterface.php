<?php

namespace Esse;

use ValueError;

/**
 * Pseudo scalar interface
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
     * Get a scalar value.
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
