<?php declare(strict_types=1);

namespace Esse\Value;

use Throwable;
use TypeError;
use ValueError;

trait InstanceFromValueTrait
{
    abstract public static function validate($value): bool;

    /**
     * Generates an instance of a value object from the original value.
     * Throws error exception if an invalid value is given.
     *
     * @param mixed $value
     * @return static
     */
    public static function from($value): static
    {
        return new static($value);
    }

    /**
     * Generates an instance of a value object from the original value.
     * Returns null if an invalid value is given.
     *
     * @param mixed $value
     * @return static|null
     */
    public static function tryFrom($value): ?static
    {
        try {
            return static::from($value);
        } catch (Throwable $th) {
            if ($th instanceof TypeError || $th instanceof ValueError) {
                return null;
            }
            throw $th;
        }
    }
}
