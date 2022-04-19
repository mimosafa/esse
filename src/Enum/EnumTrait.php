<?php declare(strict_types=1);

namespace Esse\Enum;

use Esse\Value\ValueTrait;
use Throwable;
use ValueError;

/**
 * Enumeration value object trait
 */
trait EnumTrait
{
    use ValueTrait;

    /**
     * Cache of singleton enumeration values on a class-by-class basis.
     *
     * @var array<string, array<string, static>>
     */
    protected static $enumerationsCache = [];

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
     * Checks existence of the enum case by its name.
     *
     * @param string $name
     * @return bool
     */
    public static function exists(string $name): bool
    {
        return \array_key_exists($name, static::toArray());
    }

    /**
     * Generates a list of cases on an enum with the name as a key.
     *
     * @return array<string, static>
     */
    public static function all(): array
    {
        if (static::isSingleton()) {
            $class = \get_called_class();
            return self::$enumerationsCache[$class]
                ?? self::$enumerationsCache[$class] = \array_map(fn ($value) => new static($value), static::toArray());
        }
        return \array_map(fn ($value) => new static($value), static::toArray());
    }

    /**
     * Generates a list of scalar values with the name as a key.
     *
     * @return array<string, mixed>
     */
    abstract public static function toArray(): array;

    /**
     * Whether the enumerations is singleton value or not in static class.
     *
     * @return bool
     */
    protected static function isSingleton(): bool
    {
        return false;
    }

    /**
     * Searches the name-value array for a given value and returns the name if successful.
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
     * Maps a scalar to an enum instance
     *
     * @param mixed $value
     * @return static
     */
    public static function from($value): static
    {
        if (static::isSingleton()) {
            if ($name = static::search($value)) {
                return static::all()[$name];
            }
            throw new ValueError();
        }
        return new static($value);
    }

    /**
     * Maps a scalar to an enum instance or null
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static
    {
        try {
            return static::from($value);
        } catch (Throwable $th) {
            if ($th instanceof ValueError) {
                return null;
            }
            throw $th;
        }
    }

    /**
     * Maps a name string to an enum instance
     *
     * @param string $name
     * @return static
     */
    public static function for(string $name): static
    {
        if ($instance = static::tryFor($name)) {
            return $instance;
        }
        throw new ValueError();
    }

    /**
     * Maps a name string to an enum instance or null
     *
     * @param string $name
     * @return static|null
     */
    public static function tryFor(string $name): ?static
    {
        return static::exists($name) ? static::from(static::toArray()[$name]) : null;
    }
}
