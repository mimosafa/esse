<?php

namespace Esse\Enum;

use Esse\Scalar\ScalarInterface;

/**
 * Enumration value object interface
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
