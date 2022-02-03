<?php

namespace Esse\String;

use Esse\Scalar\ScalarInterface;

interface StringInterface extends ScalarInterface
{
    #
    # /**
    #  * Whether or not to allow multibyte character strings.
    #  *
    #  * @var false
    #  */
    # const MULTIBYTE = false;
    #

    /**
     * Gets the string value.
     *
     * @return string
     */
    public function value(): string;
}
