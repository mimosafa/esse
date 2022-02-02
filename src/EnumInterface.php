<?php

namespace Esse;

/**
 * Pseudo enumerations interface
 *
 * @see https://www.php.net/manual/en/class.unitenum.php
 *
 * @property-read string $name  The case-sensitive name of the case itself.
 * @method static array<static> cases()
 *
 * @see https://www.php.net/manual/en/class.backedenum.php
 *
 * @property-read mixed $value  The value specified in the definition.
 * @method static static from(mixed $value)
 * @method static static|null tryFrom(mixed $value)
 *
 * @method static array<string, static> all()
 * @method static array<string, mixed> toArray()
 */
interface EnumInterface extends ScalarInterface
{
    #
    # To define a scalar equivalent for an Enumeration, the syntax is as follows:
    #
    # const Hearts = 'H';
    # const Diamonds = 'D';
    # const Clubs = 'C';
    # const Spades = 'S';
    #

    /**
     * Gets the case-sensitive name of the case itself.
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
