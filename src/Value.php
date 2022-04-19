<?php declare(strict_types=1);

namespace Esse;

use Esse\Value\InstanceFromValueTrait;
use Esse\Value\ValueInterface;
use Esse\Value\ValueTrait;

/**
 * Abstract value object wrapper class.
 *
 * @method static static from(mixed $value)         Generates an instance with a value.
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFrom(mixed $value) Generates an instance with a value.
 *                                                  Returns null if an invalid value given.
 * @method static bool validate(mixed $value)       Validates a given value.
 * @method mixed value()                            Returns the original value.
 * @method bool isEqual(mixed $value)               Checks for equivalence with a given,
 *                                                  only with their values.
 * @method bool isIdentical(mixed $value)           Checks for equivalence with a given,
 *                                                  not only with their values but also their classes are strictly.
 */
abstract class Value implements ValueInterface
{
    use ValueTrait {
        __construct as protected;
    }
    use InstanceFromValueTrait;

    /**
     * Validates a given value.
     *
     * @abstract
     *
     * @param mixed $value
     * @return bool
     */
    abstract public static function validate($value): bool;
}
