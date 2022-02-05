<?php declare(strict_types=1);

namespace Esse\Enum;

use Error;
use Esse\Value\ValueTrait;
use LogicException;
use ValueError;

trait UnitEnumTrait
{
    use ValueTrait {
        value as protected;
    }

    /**
     * Cache of pure enumeration cases.
     *
     * @var array<string, array<string, static>>
     */
    protected static $casesCache = [];

    /**
     * Provides names of pure enumeration cases.
     *
     * @abstract
     *
     * @access protected
     *
     * @return array<string>
     */
    abstract protected static function toArray(): array;

    /**
     * Constructor
     *
     * @final
     *
     * @access protected
     *
     * @param string $value
     */
    final protected function __construct(string $value)
    {
        if (static::validate($value)) {
            $this->value = $value;
        } else {
            throw new ValueError();
        }
    }

    /**
     * Validates a given value.
     *
     * @final
     *
     * @access protected
     *
     * @param string $value
     * @return bool
     */
    final protected static function validate($value): bool
    {
        return \in_array($value, static::toArray(), true);
    }

    /**
     * Generates a list of cases on an enum.
     *
     * @final
     *
     * @return array<static>
     */
    final public static function cases(): array
    {
        return \array_values(static::all());
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
            foreach (static::toArray() as $name) {
                if (! \is_string($name)) {
                    throw new LogicException();
                }
                if (isset($case[$name])) {
                    throw new LogicException();
                }
                if (! \preg_match($pattern, $name)) {
                    throw new LogicException();
                }
                $cases[$name] = new $class($name);
            }
            self::$casesCache[$class] = $cases;
        }
        return self::$casesCache[$class];
    }

    /**
     * Gets the read-only property.
     *
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        if ($name === 'name') {
            /**
             * Read-only property string $name
             *
             * @see https://www.php.net/manual/en/language.enumerations.basics.php
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
        if (static::validate($name)) {
            return static::all()[$name];
        }
        throw new Error(\sprintf('Call to undefined method %s::%s()', \get_called_class(), $name));
    }
}
