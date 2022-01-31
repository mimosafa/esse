<?php

namespace Esse;

use Stringable;

interface StringInterface extends Stringable, ScalarInterface
{
    # /**
    #  * Whether or not to allow multibyte character strings.
    #  *
    #  * @var false
    #  */
    # const MULTIBYTE = false;

    /**
     * Gets the string value.
     *
     * @return string
     */
    public function value(): string;
}
