<?php

namespace Esse\Enum;

/**
 * UnitEnum-like interface
 *
 * @see https://www.php.net/manual/en/class.unitenum.php
 *
 * @property-read string $name  The case-sensitive name of the case itself.
 * @method static array<static> cases()
 */
interface UnitEnumInterface
{
    /**
     * Generates a list of cases on an enum.
     *
     * @return array<static>
     */
    public static function cases(): array;
}
