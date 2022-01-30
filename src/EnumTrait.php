<?php declare(strict_types=1);

namespace Esse;

use Esse\Util\EnumerateConstantsTrait;

/**
 * Pseudo Enumerations trait
 *
 * @see https://www.php.net/manual/en/class.unitenum.php
 * @see https://www.php.net/manual/en/class.backedenum.php
 *
 * @property-read string $name  The case-sensitive name of the case itself.
 * @property-read mixed $value  The value specified in the definition.
 */
trait EnumTrait
{
    use ScalarTrait {
        __construct as protected;
    }
    use EnumerateConstantsTrait;

    /**
     * Get the case-sensitive name of the case itself.
     *
     * @return string
     */
    public function name(): string
    {
        return static::search($this->value());
    }

    /**
     * Validates a given value as an enum.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool
    {
        return static::validateBackedValueForEnums($value) && \in_array($value, static::toArray(), true);
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
     * Get the read-only property.
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
