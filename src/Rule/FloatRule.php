<?php declare(strict_types=1);

namespace Esse\Rule;

use Esse\FloatInterface;
use LogicException;
use ReflectionClass;
use ValueError;

class FloatRule implements RuleInterface
{
    public function __construct(
        private ?bool $acceptNan = null,
        private ?bool $acceptInf = null,
    )
    {
    }

    /**
     * Validates a given value with rules
     *
     * @param float $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (! \is_float($value)) {
            throw new ValueError();
        }

        if (! $this->acceptNan() && \is_nan($value)) {
            return false;
        }
        if (! $this->acceptInf() && \is_infinite($value)) {
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
        if (! \class_exists($class) || ! \in_array(FloatInterface::class, \class_implements($class), true)) {
            throw new ValueError();
        }
        if (! $constants = (new ReflectionClass($class))->getConstants()) {
            return false;
        }

        $hasRule = false;

        $acceptNan = $constants['ACCEPT_NAN'] ?? null;
        $acceptInf = $constants['ACCEPT_INF'] ?? null;

        if (isset($acceptNan)) {
            if (! \is_bool($acceptNan)) {
                throw new LogicException();
            }
            if ($acceptNan === true) {
                $hasRule = true;
            } else {
                $acceptNan = null;
            }
        }

        if (isset($acceptInf)) {
            if (! \is_bool($acceptInf)) {
                throw new LogicException();
            }
            if ($acceptInf === true) {
                $hasRule = true;
            } else {
                $acceptInf = null;
            }
        }

        return $hasRule ? new self($acceptNan, $acceptInf) : false;
    }

    public function acceptNan(): bool
    {
        return $this->acceptNan === true;
    }

    public function acceptInf(): bool
    {
        return $this->acceptInf === true;
    }
}
