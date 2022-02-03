<?php declare(strict_types=1);

namespace Esse\Util;

use LogicException;
use ReflectionClass;

trait EnumerateConstantsTrait
{
    /**
     * Cache of enumerated constants on a class-by-class basis.
     *
     * @var array<string, array<string, mixed>>
     */
    protected static $enumeratedConstantsCache = [];

    /**
     * Gets enums as an array.
     *
     * @final
     *
     * @return array<string, mixed>
     */
    final public static function toArray(): array
    {
        $class = \get_called_class();
        return self::$enumeratedConstantsCache[$class] ?? self::$enumeratedConstantsCache[$class] = static::expandConstantsToArray($class);
    }

    /**
     * The name list of constants defined as enums.
     *
     * You NEED to override this or `excludeConstantsFromEnums` method, if you defined constants that is not an enum.
     * This method has priority over `excludeConstantsFromEnums` method.
     *
     * @return array<string>
     */
    protected static function includedConstantsInEnums(): array
    {
        return [];
    }

    /**
     * The name list of constants NOT defined as enums.
     *
     * You NEED to override this or `includedConstantsInEnums` method, if you defined constants that is not an enum.
     * This method will be ignored, if `includedConstantsInEnums` method is overridden and returns a non-empty list.
     *
     * @return array<string>
     */
    protected static function excludedConstantsFromEnums(): array
    {
        return [];
    }

    /**
     * Validates a value of constant defined as an enum.
     *
     * You CAN override this method.
     *
     * @param mixed $value
     * @return bool
     */
    protected static function validateBackedValueForEnums($value): bool
    {
        return \is_scalar($value);
    }

    /**
     * Expands and initializes constants to enums.
     *
     * @final
     *
     * @param string $class
     * @return array<string, mixed>
     */
    final protected static function expandConstantsToArray(string $class): array
    {
        $constants = (new ReflectionClass($class))->getConstants();

        if ($includeds = static::includedConstantsInEnums()) {
            $constants = \array_filter(
                $constants,
                function (string $name) use ($includeds) {
                    return \in_array($name, $includeds, true);
                },
                ARRAY_FILTER_USE_KEY
            );
        }
        else if ($excludeds = static::excludedConstantsFromEnums()) {
            $constants = \array_filter(
                $constants,
                function (string $name) use ($excludeds) {
                    return ! \in_array($name, $excludeds, true);
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        $enums = [];
        foreach ($constants as $name => $value) {
            if (! static::validateBackedValueForEnums($value)) {
                throw new LogicException();
            }
            if (\in_array($value, $enums, true)) {
                throw new LogicException();
            }
            $enums[$name] = $value;
        }

        return $enums;
    }
}
