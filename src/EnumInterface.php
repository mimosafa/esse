<?php

namespace Esse;

/**
 * Pseudo Enumerations interface
 *
 * @see https://www.php.net/manual/en/class.unitenum.php
 * @see https://www.php.net/manual/en/class.backedenum.php
 *
 * @property-read string $name  The case-sensitive name of the case itself.
 * @property-read mixed $value  The value specified in the definition.
 */
interface EnumInterface extends ScalarInterface
{
    /**
     * Get the case-sensitive name of the case itself.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Generates a list of cases on an enum.
     *
     * @return array<static>
     */
    public static function cases(): array;

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
