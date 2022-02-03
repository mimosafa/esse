<?php declare(strict_types=1);

namespace Esse\Integer;

use Esse\Scalar\ScalarTrait;

/**
 * @psalm-require-implements IntegerInterface
 */
trait IntegerTrait
{
    use ScalarTrait;

    /**
     * Rules specific to integer type cached on a class-by-class basis.
     *
     * @var array<string, IntegerRule|false
     */
    protected static $integerRules = [];

    /**
     * Gets the integer value.
     *
     * @return int
     */
    public function value(): int
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
        return \is_int($value);
    }

    /**
     * Returns a specific rule of type. Returns false if not defined.
     *
     * @return IntegerRule|false
     */
    protected static function rule(): IntegerRule|false
    {
        $class = \get_called_class();
        return self::$integerRules[$class] ?? self::$integerRules[$class] = IntegerRule::init($class);
    }
}
