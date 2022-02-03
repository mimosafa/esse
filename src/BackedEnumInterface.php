<?php

namespace Esse;

/**
 * BackedEnum-like interface
 *
 * @see https://www.php.net/manual/en/class.backedenum.php
 *
 * @property-read mixed $value  The value specified in the definition.
 * @method static static from(mixed $value)
 * @method static static|null tryFrom(mixed $value)
 */
interface BackedEnumInterface extends UnitEnumInterface
{
    /**
     * Maps a scalar to an enum instance
     *
     * @param mixed $value
     * @return static
     */
    public static function from($value): static;

    /**
     * Maps a scalar to an enum instance or null
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static;
}
