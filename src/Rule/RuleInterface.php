<?php

namespace Esse\Rule;

interface RuleInterface
{
    /**
     * Validates a given value with rules
     *
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool;

    /**
     * Initializes validation rules from constants of a given class.
     *
     * @param string $class
     * @return self|false
     */
    public static function init(string $class): self|false;
}
