<?php declare(strict_types=1);

namespace Esse;

use Esse\Rule\FloatRule;
use Esse\Rule\RuleInterface;

/**
 * @psalm-require-implements FloatInterface
 */
trait FloatTrait
{
    use ScalarTrait;

    /**
     * Rules specific to float type cached on a class-by-class basis.
     *
     * @var array<string, FloatRule|false
     */
    protected static $floatRules = [];

    /**
     * Gets the float value.
     *
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * Validates a type of a given value.
     *
     * @param mixed $value
     * @return bool
     */
    protected static function validateType($value): bool
    {
        return \is_float($value);
    }

    /**
     * Validates a given value with the specific rule.
     *
     * @param float $value
     * @return bool
     */
    protected static function validateWithRule($value): bool
    {
        if ($rule = static::rule()) {
            return $rule->validate($value);
        }
        return \is_finite($value);
    }

    /**
     * Returns a specific rule of type. Returns false if not defined.
     *
     * @return RuleInterface|false
     */
    protected static function rule(): RuleInterface|false
    {
        $class = \get_called_class();
        return self::$floatRules[$class] ?? self::$floatRules[$class] = FloatRule::init($class);
    }
}
