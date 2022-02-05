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

    /**
     * Maps a name string to an enum instance
     *
     * @param string $name
     * @return static
     */
    public static function for(string $name): static;

    /**
     * Maps a name string to an enum instance or null
     *
     * @param string $name
     * @return static|null
     */
    public static function tryFor(string $name): ?static;
}
