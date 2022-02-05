<?php declare(strict_types=1);

namespace Esse\String;

use Esse\RuleInterface;
use LogicException;
use ReflectionClass;
use ValueError;

class StringRule implements RuleInterface
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

        if (
            \is_null($multibyte = $constants['MULTIBYTE'] ?? null)
            && \is_null($regexPattern = $constants['REGEX_PATTERN'] ?? null)
            && \is_null($minLength = $constants['MIN_LENGTH'] ?? null)
            && \is_null($maxLength = $constants['MAX_LENGTH'] ?? null)
        ) {
            return false;
        }

        return new self($multibyte, $regexPattern, $minLength, $maxLength);
    }

    /**
     * Constructor
     *
     * @param bool|null $multibyte
     * @param string|null $regexPattern
     * @param int|null $minLength
     * @param int|null $maxLength
     */
    public function __construct(
        private ?bool $multibyte = null,
        private ?string $regexPattern = null,
        private ?int $minLength = null,
        private ?int $maxLength = null,
    )
    {
        if (isset($multibyte) && ! \is_bool($multibyte)) {
            throw new LogicException();
        }
        if (isset($regexPattern) && @\preg_match($regexPattern, '') === false) {
            throw new LogicException();
        }
        if (isset($minLength) && $minLength <= 0) {
            throw new LogicException();
        }
        if (isset($maxLength) && $maxLength <= 0) {
            throw new LogicException();
        }
        if (isset($minLength) && isset($maxLength) && $minLength > $maxLength) {
            throw new LogicException();
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
        if ($this->minLength && $this->strlen($value) < $this->minLength) {
            return false;
        }
        if ($this->maxLength && $this->strlen($value) > $this->maxLength) {
            return false;
        }

        return true;
    }

    /**
     * Get string length.
     *
     * @access protected
     *
     * @param string $value
     * @return int
     */
    protected function strlen(string $value): int
    {
        return $this->multibyte === false ? \strlen($value) : \mb_strlen($value);
    }
}
