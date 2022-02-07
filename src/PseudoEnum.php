<?php declare(strict_types=1);

namespace Esse;

use Esse\Enum\EnumerateConstantsTrait;
use Esse\Enum\EnumInterface;
use Esse\Enum\EnumTrait;

/**
 * Abstract pseudo-enumeration type value object class.
 *
 * To define a scalar equivalent for an Enumeration, the syntax is as follows:
 *
 * ```
 * <?php
 * use Esse\PseudoEnum;
 * class Suit extends PseudoEnum
 * {
 *     const Hearts = 'H';
 *     const Diamonds = 'D';
 *     const Clubs = 'C';
 *     const Spades = 'S';
 * }
 * ```
 *
 * If there are constants that are not included in the Enumeration, there are two ways:
 *
 * ```
 * <?php
 * use Esse\PseudoEnum;
 * class Suit extends PseudoEnum
 * {
 *     const Hearts = 'H';
 *     const Diamonds = 'D';
 *     const Clubs = 'C';
 *     const Spades = 'S';
 *
 *     const NOT_ENUMERATION = 'not_enumeration';
 *
 *     protected static $included = ['Hearts', 'Diamonds', 'Clubs', 'Diamonds'];
 *     // or
 *     // protected static $excluded = ['NOT_ENUMERATION'];
 * }
 * ```
 *
 * @method static static from(mixed $value)         Generates an instance with a value(e.g. 'H').
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFrom(mixed $value) Generates an instance with a value(e.g. 'H').
 *                                                  Returns null if an invalid value given.
 * @method static static for(mixed $value)          Generates an instance with a name(e.g. 'Hearts').
 *                                                  Throws ValueError if an invalid value given.
 * @method static static|null tryFor(mixed $value)  Generates an instance with a name(e.g. 'Hearts').
 *                                                  Returns null if an invalid value given.
 * @method static bool validate(mixed $value)       Validates a scalar as enumeration value.
 * @method bool|int|float|string value()            Returns the original scalar value.
 * @method string name()                            Returns the name of enumeration value.
 * @method bool isEqual(mixed $value)               Checks for equivalence with a given, only with their values.
 * @method bool isIdentical(mixed $value)           Checks for equivalence with a given, not only with their values but also their classes are strictly.
 */
abstract class PseudoEnum implements EnumInterface
{
    use EnumTrait {
        __construct as protected;
    }
    use EnumerateConstantsTrait;

    /**
     * The name list of constants defined as enums.
     *
     * @var array<string>
     */
    protected static $included = [];

    /**
     * The name list of constants NOT defined as enums.
     *
     * @var array<string>
     */
    protected static $excluded = [];

    protected static function includedConstantsInEnums(): array
    {
        return static::$included;
    }

    protected static function excludedConstantsFromEnums(): array
    {
        return static::$excluded;
    }
}
