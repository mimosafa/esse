<?php declare(strict_types=1);

namespace Esse;

use Esse\Rule\RuleInterface;
use Throwable;
use ValueError;

/**
 * @psalm-require-implements ScalarInterface
 */
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

    /**
     * Gets an instance from a scalar value. If an invalid value is given, a ValueError will be thrown.
     *
     * @param mixed $value
     * @return static
     */
    public static function from($value): static
    {
        return new static($value);
    }

    /**
     * Gets an instance from a scalar value. If an invalid value is given, null is returned.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static
    {
        try {
            return static::from($value);
        } catch (Throwable $e) {
            if ($e instanceof ValueError) {
                return null;
            }
            throw $e;
        }
    }
}
