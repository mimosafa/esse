<?php

namespace Esse;

/**
 * Value object interface
 *
 * @method mixed value()
 * @method bool isEqual(mixed $value)
 * @method bool isIdentical(mixed $value)
 * @method static bool validate(mixed $value)
 */
interface ValueInterface
{
    /**
     * Gets the original value.
     *
     * @return mixed
     */
    public function value();

    /**
     * Checks for equivalence with a given, only with their values.
     *
     * @param mixed $value
     * @return bool
     */
    public function isEqual($value): bool;

    /**
     * Checks for equivalence with a given, not only with their values but also their classes are strictly.
     *
     * @param mixed $value
     * @return bool
     */
    public function isIdentical($value): bool;

    /**
     * Validates a given value.
     *
     * @param mixed $value
     * @return bool
     */
    public static function validate($value): bool;
}
