<?php declare(strict_types=1);

namespace Esse;

use ValueError;

trait ValueTrait
{
    /**
     * The original value
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
        $value = $value instanceof self ? $value->value() : $value;

        if (static::validate($value)) {
            $this->value = $value;
        } else {
            throw new ValueError();
        }
    }

    /**
     * Gets the original value.
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
     * @return bool
     */
    public function isEqual($value): bool
    {
        return $this->isEqualOriginalValue($value instanceof self ? $value->value() : $value);
    }

    /**
     * Checks for equivalence with a given, not only with their values but also their classes are strictly.
     *
     * @param mixed $value
     * @return bool
     */
    public function isIdentical($value): bool
    {
        return $value instanceof static
            && \get_called_class() === \get_class($value)
            && $this->isIdenticalOriginalValue($value->value());
    }

    /**
     * Validates a given value.
     *
     * @abstract
     *
     * @param mixed $value
     * @return bool
     */
    abstract public static function validate($value): bool;

    /**
     * Checks for original values equivalence with a given.
     *
     * @param mixed $value
     * @return bool
     */
    protected function isEqualOriginalValue($value): bool
    {
        return $this->isIdenticalOriginalValue($value);
    }

    /**
     * Checks for original values equivalence strictly with a given.
     *
     * @param mixed $value
     * @return bool
     */
    protected function isIdenticalOriginalValue($value): bool
    {
        return $this->value === $value;
    }
}
