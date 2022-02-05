<?php

namespace Esse\Enum;

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
     * @param int|string $value
     * @return static
     */
    public static function from(int|string $value): static;

    /**
     * Maps a scalar to an enum instance or null
     *
     * @param int|string $value
     * @return static|null
     */
    public static function tryFrom(int|string $value): ?static;
}
