<?php declare(strict_types=1);

namespace Esse;

use Stringable;

trait StringTrait
{
    use ScalarTrait {
        __construct as constructScalar;
        isEqual as isEqualScalar;
    }

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
     * Get a string value.
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
     * Validates a given value as string.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool
    {
        return \is_string($value) || $value instanceof Stringable;
    }

    /**
     * Return the string representation of the current element.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
