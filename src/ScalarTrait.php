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
    /**
     * Original scalar value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value
     * @return void
     * @throws ValueError
     */
    public function __construct($value)
    {
        $value = $value instanceof static ? $value->value() : $value;

        if (! static::validate($value)) {
            throw new ValueError();
        }
        $this->value = $value;
    }

    /**
     * Gets the scalar value
     *
     * @return mixed
     */
    public function value()
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
        if ($value instanceof self) {
            $value = $value->value();
        }
        return $this->value() === $value;
    }

    /**
     * Checks for equivalence with a given, not only with their values but also their classes are strictly.
     *
     * @param mixed $value
     * @return boolean
     */
    public function isIdentical($value): bool
    {
        return $value instanceof static
            && $this->value() === $value->value()
            && \get_called_class() === \get_class($value);
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
