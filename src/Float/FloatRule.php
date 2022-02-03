<?php declare(strict_types=1);

namespace Esse\Float;

use Esse\RuleInterface;
use LogicException;
use ReflectionClass;
use ValueError;

class FloatRule implements RuleInterface
{
    /**
     * Constructor
     *
     * @param bool|null $acceptNan
     * @param bool|null $acceptInf
     */
    public function __construct(
        private ?bool $acceptNan = null,
        private ?bool $acceptInf = null,
    )
    {
        if (isset($acceptNan)) {
            if (! \is_bool($acceptNan)) {
                throw new LogicException();
            }
        }

        if (isset($acceptInf)) {
            if (! \is_bool($acceptInf)) {
                throw new LogicException();
            }
        }
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

        if (\is_nan($value) && $this->acceptNan !== true) {
            return false;
        }
        if (\is_infinite($value) && $this->acceptInf !== true) {
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
        if (! \class_exists($class)) {
            throw new ValueError();
        }
        if (! $constants = (new ReflectionClass($class))->getConstants()) {
            return false;
        }

        if (
            \is_null($acceptNan = $constants['ACCEPT_NAN'] ?? null)
            && \is_null($acceptInf = $constants['ACCEPT_INF'] ?? null)
        ) {
            return false;
        }

        return new self($acceptNan, $acceptInf);
    }
}
