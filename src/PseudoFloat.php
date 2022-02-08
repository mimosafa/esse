<?php declare(strict_types=1);

namespace Esse;

use Esse\Float\FloatInterface;
use Esse\Float\FloatTrait;
use Esse\Value\InstanceFromValueTrait;

/**
 * Abstract pseudo-float type value object class.
 *
 * Multiple constants can be defined and rules can be applied or relaxed to a value.
 *
 * ```
 * <?php
 * use Esse\PseudoFloat;
 * class CalculationResult extends PseudoFloat
 * {
 *     // Accepts NAN as a value.
 *     // @var true
 *     const ACCEPT_NAN = true;
 *     // Accepts INF as a value.
 *     // @var true
 *     const ACCEPT_INF = true;
 * }
 *
 * class Distance extends PseudoFloat
 * {
 *     // @var int|float
 *     const GREATER_THAN_OR_EQUAL_TO = 0;
 *     const LESS_THAN_OR_EQUAL_TO = 42.195;
 * }
 *
 * class TemperatureAsLiquid extends PseudoFloat
 * {
 *     // @var int|float
 *     const GREATER_THAN = 0;
 *     const LESS_THAN = 100;
 * }
 * ```
 *
 * @method static static from(mixed $value)         Generates an instance with a value.
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFrom(mixed $value) Generates an instance with a value.
 *                                                  Returns null if an invalid value given.
 * @method static bool validate(mixed $value)       Validates a given value.
 * @method int value()                              Returns the original float value.
 * @method bool isEqual(mixed $value)               Checks for equivalence with a given,
 *                                                  only with their values.
 * @method bool isIdentical(mixed $value)           Checks for equivalence with a given,
 *                                                  not only with their values but also their classes are strictly.
 */
abstract class PseudoFloat implements FloatInterface
{
    use FloatTrait {
        __construct as protected;
    }
    use InstanceFromValueTrait;
}
