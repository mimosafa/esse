<?php declare(strict_types=1);

namespace Esse\Enum;

use Esse\Value\ValueTrait;

/**
 * Enumeration value object trait
 */
trait EnumTrait
{
    use ValueTrait;

    /**
     * Gets the case-sensitive name of the case itself.
     *
     * @return string
     */
    public function name(): string
    {
        return static::search($this->value());
    }

    /**
     * Validates a given value.
     *
     * @param mixed $value
     * @return bool
     */
    public static function validate($value): bool
    {
        return \in_array($value, static::toArray(), true);
    }

    /**
     * Generates a list of cases on an enum with the name as a key.
     *
     * @return array<string, static>
     */
    public static function all(): array
    {
        return \array_map(fn ($value) => new static($value), static::toArray());
    }

    /**
     * Generates a list of scalar values with the name as a key.
     *
     * @return array<string, mixed>
     */
    abstract public static function toArray(): array;

    /**
     * Searches the enums for a given value and returns the name if successful.
     *
     * @access protected
     *
     * @param mixed $value
     * @return string|false
     */
    protected static function search($value): string|false
    {
        return static::validate($value) ? \array_search($value, static::toArray(), true) : false;
    }
}
