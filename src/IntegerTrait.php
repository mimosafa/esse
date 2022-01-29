<?php declare(strict_types=1);

namespace Esse;

trait IntegerTrait
{
    use ScalarTrait;

    /**
     * Get a integer value
     *
     * @return integer
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * Validate a given value.
     *
     * @param mixed $value
     * @return boolean
     */
    public static function validate($value): bool
    {
        return \is_int($value);
    }
}
