<?php declare(strict_types=1);

namespace Esse\Float;

use Esse\Scalar\RuleInterface;
use LogicException;
use ReflectionClass;
use ValueError;

class FloatRule implements RuleInterface
{
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

        $acceptNan = $constants['ACCEPT_NAN'] ?? null;
        $acceptInf = $constants['ACCEPT_INF'] ?? null;
        $gte = $constants['GREATER_THAN_OR_EQUAL_TO'] ?? null;
        $gt = $constants['GREATER_THAN'] ?? null;
        $lt = $constants['LESS_THAN'] ?? null;
        $lte = $constants['LESS_THAN_OR_EQUAL_TO'] ?? null;

        if (\is_null($acceptNan) && \is_null($acceptInf)
            && \is_null($gte) && \is_null($gt) && \is_null($lt) && \is_null($lte)) {
            return false;
        }

        return new self($acceptNan, $acceptInf, $gte, $gt, $lt, $lte);
    }

    /**
     * Constructor
     *
     * @param bool|null $acceptNan
     * @param bool|null $acceptInf
     */
    public function __construct(
        private ?bool $acceptNan = null,
        private ?bool $acceptInf = null,
        private null|int|float $gte = null,
        private null|int|float $gt = null,
        private null|int|float $lt = null,
        private null|int|float $lte = null,
    )
    {
        if (isset($gte) && isset($gt)) {
            throw new LogicException();
        }
        if (isset($lt) && isset($lte)) {
            throw new LogicException();
        }
        if (isset($gte)) {
            if (isset($lt) && $lt <= $gte) {
                throw new LogicException();
            }
            if (isset($lte) && $lte < $gte) {
                throw new LogicException();
            }
        }
        if (isset($gt)) {
            if (isset($lt) && $lt <= $gt) {
                throw new LogicException();
            }
            if (isset($lte) && $lte <= $gt) {
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
}
