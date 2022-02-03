<?php declare(strict_types=1);

namespace Esse;

use Esse\Util\EnumerateConstantsTrait;

/**
 * Pseudo enumerations trait
 *
 * @psalm-require-implements EnumInterface
 */
trait EnumTrait
{
    use ScalarTrait, EnumerateConstantsTrait;

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
     * Validates a type of a given value.
     *
     * @uses \Esse\Util\EnumerateConstantsTrait::validateBackedValueForEnums()
     *
     * @param mixed $value
     * @return bool
     */
    protected static function validateType($value): bool
    {
        return static::validateBackedValueForEnums($value);
    }

    /**
     * Validates a given value with the specific rule.
     *
     * @param mixed $value
     * @return bool
     */
    protected static function validateWithRule($value): bool
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
