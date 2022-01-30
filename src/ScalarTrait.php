<?php declare(strict_types=1);

namespace Esse;

use ValueError;

trait ScalarTrait
{
    /**
     * Scalar value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        if (! static::validate($value)) {
            throw new ValueError();
        }
        $this->value = $value;
    }

    /**
     * Get a scalar value
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
     * Validates a given value as scalar.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool
    {
        return \is_scalar($value);
    }

    /**
     * Get instance from scalar value. If an invalid value is given, it will throw a ValueError.
     *
     * @param mixed $value
     * @return static
     * @throws ValueError
     */
    public static function from($value): static
    {
        if ($value instanceof static) {
            return new static($value->value());
        }
        return new static($value);
    }

    /**
     * Get instance from scalar value. If an invalid value is given, it will return null.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static
    {
        try {
            return static::from($value);
        } catch (ValueError $e) {
            return null;
        }
    }
}
