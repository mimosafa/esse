<?php

namespace Esse\Enum;

use Esse\Value\ValueInterface;

/**
 * Enumeration value object interface
 */
interface EnumInterface extends ValueInterface
{
    /**
     * Gets the case-sensitive name of the case itself.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Generates a list of cases on an enum with the name as a key.
     *
     * @return array<string, static>
     */
    public static function all(): array;

    /**
     * Generates a list of scalar values with the name as a key.
     *
     * @return array<string, mixed>
     */
    public static function toArray(): array;
}
