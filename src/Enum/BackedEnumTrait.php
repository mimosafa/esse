<?php declare(strict_types=1);

namespace Esse\Enum;

use Error;
use LogicException;
use ValueError;

trait BackedEnumTrait
{
    use UnitEnumTrait;

    /**
     * Provides names and values of backed enumeration cases.
     *
     * @abstract
     *
     * @access protected
     *
     * @return array<string, bool|int|float|string>
     */
    abstract protected static function toArray(): array;

    /**
     * Constructor
     *
     * @final
     *
     * @access protected
     *
     * @param int|string $value
     */
    final protected function __construct(int|string $value)
    {
        if (static::validate($value)) {
            $this->value = $value;
        } else {
            throw new ValueError();
        }
    }

    /**
     * Gets the case-sensitive name of the case itself.
     *
     * @access protected
     *
     * @return string
     */
    protected function name(): string
    {
        return static::search($this->value());
    }

    /**
     * Generates a list of cases on an enum with the name as a key.
     *
     * @final
     *
     * @access protected
     *
     * @return array<string, static>
     */
    final protected static function all(): array
    {
        $class = \get_called_class();
        if (! isset(self::$casesCache[$class])) {

            /**
             * Regular expression for constant names.
             *
             * @see https://www.php.net/manual/en/language.constants.php
             *
             * @var string
             */
            $pattern = '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/';

            $cases = [];
            foreach (static::toArray() as $name => $value) {
                if (! \is_scalar($value)) {
                    throw new LogicException();
                }
                if (\in_array($value, $cases, true)) {
                    throw new LogicException();
                }
                if (! \preg_match($pattern, $name)) {
                    throw new LogicException();
                }
                $cases[$name] = $value;
            }
            self::$casesCache[$class] = \array_map(fn ($value) => new $class($value), $cases);
        }
        return self::$casesCache[$class];
    }

    /**
     * Maps a scalar to an enum instance
     *
     * @final
     *
     * @param int|string $value
     * @return static
     * @throws ValueError
     */
    final public static function from(int|string $value): static
    {
        if (! $instance = static::tryFrom($value)) {
            throw new ValueError();
        }
        return $instance;
    }

    /**
     * Maps a scalar to an enum instance or null
     *
     * @final
     *
     * @param int|string $value
     * @return static|null
     */
    final public static function tryFrom(int|string $value): ?static
    {
        return ($name = static::search($value)) ? static::all()[$name] : null;
    }

    /**
     * Searches the name-value array for a given value and returns the name if successful.
     *
     * @final
     *
     * @access protected
     *
     * @param mixed $value
     * @return string|false
     */
    final protected static function search($value): string|false
    {
        return \array_search($value, static::toArray(), true);
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
             * Read-only property string $name
             *
             * @see https://www.php.net/manual/en/language.enumerations.basics.php
             */
            return $this->name();
        }
        if ($name === 'value') {
            /**
             * Read-only property mixed $value
             *
             * @see https://www.php.net/manual/en/language.enumerations.backed.php
             */
            return $this->value();
        }
        \trigger_error("Undefined property: {$name}", E_USER_WARNING);
    }

    /**
     * Gets an instance by case name as a static method.
     */
    public static function __callStatic($name, $arguments)
    {
        if ($instance = static::all()[$name] ?? null) {
            return $instance;
        }
        throw new Error(\sprintf('Call to undefined method %s::%s()', \get_called_class(), $name));
    }
}
