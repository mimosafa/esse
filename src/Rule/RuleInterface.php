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
}
