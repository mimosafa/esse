<?php declare(strict_types=1);

namespace Esse;

use Esse\String\StringInterface;
use Esse\String\StringTrait;
use Esse\Value\InstanceFromValueTrait;

/**
 * Abstract pseudo-string type value object class.
 *
 * Multiple constants can be defined and rules can be applied to a value.
 *
 * ```
 * <?php
 * use Esse\PseudoString;
 * class UserName extends PseudoString
 * {
 *     // Disallows multi-byte character strings.
 *     // @var false
 *     const MULTIBYTE = false;
 *     // Restricts a value with regular expressions.
 *     // @var string
 *     const REGEX_PATTERN = '/^[a-zA-Z0-9_-]+$/';
 *     // Defines the minimum length of a value.
 *     // @var int
 *     const MIN_LENGTH = 8;
 *     // Defines the maximum length of a value.
 *     // @var int
 *     const MAX_LENGTH = 16;
 * }
 * ```
 *
 * @method static static from(mixed $value)         Generates an instance with a value.
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFrom(mixed $value) Generates an instance with a value.
 *                                                  Returns null if an invalid value given.
 * @method static bool validate(mixed $value)       Validates a scalar as enumeration value.
 * @method bool|int|float|string value()            Returns the original scalar value.
 * @method bool isEqual(mixed $value)               Checks for equivalence with a given, only with their values.
 * @method bool isIdentical(mixed $value)           Checks for equivalence with a given, not only with their values but also their classes are strictly.
 */
abstract class PseudoString implements StringInterface
{
    use StringTrait {
        __construct as protected;
    }
    use InstanceFromValueTrait;
}
