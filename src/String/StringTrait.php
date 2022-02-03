<?php declare(strict_types=1);

namespace Esse\String;

use Esse\Scalar\ScalarTrait;

/**
 * @psalm-require-implements StringInterface
 */
trait StringTrait
{
    use ScalarTrait;

    /**
     * Rules specific to string type cached on a class-by-class basis.
     *
     * @var array<string, StringRule|false
     */
    protected static $stringRules = [];

    /**
     * Gets the string value.
     *
     * @return string
     */
    public function value(): string
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
        return \is_string($value);
    }

    /**
     * Returns a specific rule of type. Returns false if not defined.
     *
     * @return StringRule|false
     */
    protected static function rule(): StringRule|false
    {
        $class = \get_called_class();
        return self::$stringRules[$class] ?? self::$stringRules[$class] = StringRule::init($class);
    }
}
