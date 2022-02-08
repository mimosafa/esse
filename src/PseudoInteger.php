<?php declare(strict_types=1);

namespace Esse;

use Esse\Integer\IntegerInterface;
use Esse\Integer\IntegerTrait;
use Esse\Value\InstanceFromValueTrait;

/**
 * Abstract pseudo-integer type value object class.
 *
 * Multiple constants can be defined and rules can be applied to a value.
 *
 * ```
 * <?php
 * use Esse\PseudoInteger;
 * class Rating extends PseudoInteger
 * {
 *     // Defines the minimum range of values.
 *     // @var int
 *     const MIN = 1;
 *     // Defines the maximum range of values.
 *     // @var int
 *     const MAX = 10;
 * }
 * Rating::validate(1); // true
 * Rating::from(10); // ok
 * Rating::validate(0); // false
 * Rating::tryFrom(11); // null
 * Rating::from(99); // Error
 * ```
 *
 * @method static static from(mixed $value)         Generates an instance with a value.
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFrom(mixed $value) Generates an instance with a value.
 *                                                  Returns null if an invalid value given.
 * @method static bool validate(mixed $value)       Validates a given value.
 * @method int value()                              Returns the original integer value.
 * @method bool isEqual(mixed $value)               Checks for equivalence with a given,
 *                                                  only with their values.
 * @method bool isIdentical(mixed $value)           Checks for equivalence with a given,
 *                                                  not only with their values but also their classes are strictly.
 */
abstract class PseudoInteger implements IntegerInterface
{
    use IntegerTrait {
        __construct as protected;
    }
    use InstanceFromValueTrait;
}
