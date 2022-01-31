<?php declare(strict_types=1);

namespace Esse\Rule;

use Esse\IntegerInterface;
use InvalidArgumentException;
use LogicException;
use ReflectionClass;
use ValueError;

final class IntegerRule implements RuleInterface
{
    public function __construct(
        private ?int $gte = null,
        private ?int $gt = null,
        private ?int $lt = null,
        private ?int $lte = null,
    )
    {
        // Refuses to define "__ than or equal to" and "__ than" in a same class.
        if (isset($gte) && isset($gt)) {
            throw new InvalidArgumentException();
        }
        if (isset($lt) && isset($lte)) {
            throw new InvalidArgumentException();
        }

        if (isset($gte)) {
            if (isset($lt) && $lt <= $gte) {
                throw new InvalidArgumentException();
            }
            if (isset($lte) && $lte < $gte) {
                throw new InvalidArgumentException();
            }
        }
        else if (isset($gt)) {
            if (isset($lt) && $lt <= ($gt + 1)) {
                throw new InvalidArgumentException();
            }
            if (isset($lte) && $lte < ($gt + 1)) {
                throw new InvalidArgumentException();
            }
        }
    }

    /**
     * Validates a given value with rules
     *
     * @param int $value
     * @return boolean
     */
    public function validate($value): bool
    {
        if (! \is_int($value)) {
            throw new ValueError();
        }

        if (isset($this->gte) && $value < $this->gte) {
            return false;
        }
        if (isset($this->gt) && $value <= $this->gt) {
            return false;
        }
        if (isset($this->lt) && $value >= $this->lt) {
            return false;
        }
        if (isset($this->lte) && $value > $this->lte) {
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

        $hasRule = false;

        $gte = $constants['GREATER_THAN_OR_EQUAL_TO'] ?? null;
        $gt = $constants['GREATER_THAN'] ?? null;
        $lt = $constants['LESS_THAN'] ?? null;
        $lte = $constants['LESS_THAN_OR_EQUAL_TO'] ?? null;

        if (isset($gte) && ! \is_int($gte)) {
            throw new LogicException();
        }
        if (isset($gt) && ! \is_int($gt)) {
            throw new LogicException();
        }
        if (isset($lt) && ! \is_int($lt)) {
            throw new LogicException();
        }
        if (isset($lte) && ! \is_int($lte)) {
            throw new LogicException();
        }
        if (isset($gte) || isset($gt) || isset($lt) || isset($lte)) {
            $hasRule = true;
        }

        return $hasRule ? new self($gte, $gt, $lt, $lte) : false;
    }
}
