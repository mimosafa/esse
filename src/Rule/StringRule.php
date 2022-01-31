<?php declare(strict_types=1);

namespace Esse\Rule;

use Esse\StringInterface;
use LogicException;
use ReflectionClass;
use Stringable;
use ValueError;

final class StringRule implements RuleInterface
{
    public function __construct(
        private ?bool $acceptMultibyte = null,
    )
    {
    }

    /**
     * Validates a given value with rules
     *
     * @param string|Stringable $value
     * @return boolean
     */
    public function validate($value): bool
    {
        if (! \is_string($value) && ! $value instanceof Stringable) {
            throw new ValueError();
        }

        if ($value instanceof Stringable) {
            $value = $value->__toString();
        }

        if (! $this->acceptMultibyte() && \strlen($value) !== \mb_strlen($value)) {
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
        if (! \class_exists($class) || ! \in_array(StringInterface::class, \class_implements($class), true)) {
            throw new ValueError();
        }
        if (! $constants = (new ReflectionClass($class))->getConstants()) {
            return false;
        }

        $hasRule = false;

        $acceptMultibyte = $constants['MULTIBYTE'] ?? null;

        if (isset($acceptMultibyte)) {
            if (! \is_bool($acceptMultibyte)) {
                throw new LogicException();
            }
            if ($acceptMultibyte === false) {
                $hasRule = true;
            } else {
                $acceptMultibyte = null;
            }
        }

        return $hasRule ? new self($acceptMultibyte) : false;
    }

    public function acceptMultibyte(): bool
    {
        return $this->acceptMultibyte !== false;
    }
}
