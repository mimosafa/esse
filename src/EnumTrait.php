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
    use ScalarTrait {
        __construct as protected;
    }
    use EnumerateConstantsTrait;

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
     * @return boolean
     */
    protected static function validateType($value): bool
    {
        return static::validateBackedValueForEnums($value);
    }

    /**
     * Validates a given value with the specific rule.
     *
     * @param mixed $value
     * @return boolean
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
        return \array_map([\get_called_class(), 'from'], static::toArray());
    }

    /**
     * Generates a list of cases on an enum.
     *
     * @return array<static>
     */
    public static function cases(): array
    {
        return \array_values(static::all());
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

    /**
     * Gets the read-only property.
     *
     * @param string $name
     * @return string|int
     */
    public function __get($name)
    {
        if ($name === 'name') {
            /**
             * @see https://www.php.net/manual/en/language.enumerations.basics.php
             */
            return $this->name();
        }
        if ($name === 'value') {
            /**
             * @see https://www.php.net/manual/en/language.enumerations.backed.php
             */
            return $this->value();
        }
        \trigger_error("Undefined property: {$name}", E_USER_WARNING);
    }
}
