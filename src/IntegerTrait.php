<?php declare(strict_types=1);

namespace Esse;

trait IntegerTrait
{
    use ScalarTrait;

    /**
     * Gets the integer value.
     *
     * @return integer
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * Validates a type of a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    protected static function validateType($value): bool
    {
        return \is_int($value);
    }
}
