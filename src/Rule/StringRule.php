<?php declare(strict_types=1);

namespace Esse\Rule;

use Esse\StringInterface;
use LogicException;
use ReflectionClass;
use ValueError;

class StringRule implements RuleInterface
{
    /**
     * Constructor
     *
     * @param bool|null $multibyte
     * @param string|null $regexPattern
     */
    public function __construct(
        private ?bool $multibyte = null,
        private ?string $regexPattern = null,
    )
    {
        if (isset($multibyte)) {
            if (! \is_bool($multibyte)) {
                throw new LogicException();
            }
        }
        if (isset($regexPattern)) {
            if (@\preg_match($regexPattern, '') === false) {
                throw new LogicException();
            }
        }
    }

    /**
     * Validates a given value with rules
     *
     * @param string $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (! \is_string($value)) {
            throw new ValueError();
        }

        if ($this->multibyte === false && \strlen($value) !== \mb_strlen($value)) {
            return false;
        }
        if ($this->regexPattern && ! \preg_match($this->regexPattern, $value)) {
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

        if (
            \is_null($multibyte = $constants['MULTIBYTE'] ?? null)
            && \is_null($regexPattern = $constants['REGEX_PATTERN'] ?? null)
        ) {
            return false;
        }

        return new self($multibyte, $regexPattern);
    }
}
