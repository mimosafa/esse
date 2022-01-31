<?php declare(strict_types=1);

namespace Esse;

use Esse\Rule\RuleInterface;
use Esse\Rule\StringRule;
use Stringable;

/**
 * @psalm-require-implements StringInterface
 */
trait StringTrait
{
    use ScalarTrait {
        __construct as constructScalar;
        isEqual as isEqualScalar;
    }

    /**
     * Rules specific to string type cached on a class-by-class basis.
     *
     * @var array<string, StringRule|false
     */
    protected static $stringRules = [];

    /**
     * Constructor
     *
     * @param string|Stringable $value
     */
    public function __construct($value)
    {
        if ($value instanceof Stringable) {
            $value = $value->__toString();
        }
        $this->constructScalar($value);
    }

    /**
     * Gets the string value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Checks for equivalence with a given, only with their values.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isEqual($value): bool
    {
        if ($value instanceof Stringable) {
            $value = $value->__toString();
        }
        return $this->isEqualScalar($value);
    }

    /**
     * Validates a type of a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    protected static function validateType($value): bool
    {
        return \is_string($value) || $value instanceof Stringable;
    }

    /**
     * Returns a specific rule of type. Returns false if not defined.
     *
     * @return RuleInterface|false
     */
    protected static function rule(): RuleInterface|false
    {
        $class = \get_called_class();
        return self::$stringRules[$class] ?? self::$stringRules[$class] = StringRule::init($class);
    }

    /**
     * Returns the string representation of the current element.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
