<?php declare(strict_types=1);

namespace Esse\Rule;

use Esse\IntegerInterface;
use LogicException;
use ReflectionClass;
use ValueError;

final class IntegerRule implements RuleInterface
{
    /**
     * Constructor
     *
     * @param int|null $min
     * @param int|null $max
     */
    public function __construct(
        private ?int $min = null,
        private ?int $max = null,
    )
    {
        if (isset($min) && isset($max) && $min > $max) {
            throw new LogicException();
        }
    }

    /**
     * Validates a given value with rules
     *
     * @param int $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (! \is_int($value)) {
            throw new ValueError();
        }

        if (isset($this->min) && $value < $this->min) {
            return false;
        }
        if (isset($this->max) && $value > $this->max) {
            return false;
        }

        return true;
    }

    /**
     * Initializes validation rules from constants of a given class.
     *
     * @param string $class
     * @return self|false
     */
    public static function init(string $class): self|false
    {
        if (! \class_exists($class) || ! \in_array(IntegerInterface::class, \class_implements($class), true)) {
            throw new ValueError();
        }
        if (! $constants = (new ReflectionClass($class))->getConstants()) {
            return false;
        }

        if (
            \is_null($min = $constants['MIN'] ?? null)
            && \is_null($max = $constants['MAX'] ?? null)
        ) {
            return false;
        }

        return new self(min: $min, max: $max);
    }
}
