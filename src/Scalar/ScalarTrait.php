<?php declare(strict_types=1);

namespace Esse\Scalar;

use Esse\RuleInterface;
use Esse\Value\ValueTrait;

trait ScalarTrait
{
    use ValueTrait;

    /**
     * Gets the scalar value.
     *
     * @return bool|int|float|string
     */
    public function value(): bool|int|float|string
    {
        return $this->value;
    }

    /**
     * Validates a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool
    {
        return static::validateType($value) && static::validateWithRule($value);
    }

    /**
     * Validates a type of a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    protected static function validateType($value): bool
    {
        return \is_scalar($value);
    }

    /**
     * Validates a given value with the specific rule.
     *
     * @param mixed $value
     * @return boolean
     */
    protected static function validateWithRule($value): bool
    {
        return ($rule = static::rule()) ? $rule->validate($value) : true;
    }

    /**
     * Returns a specific rule of type. Returns false if not defined.
     *
     * @return RuleInterface|false
     */
    protected static function rule(): RuleInterface|false
    {
        return false;
    }
}
