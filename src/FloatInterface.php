<?php

namespace Esse;

interface FloatInterface extends ScalarInterface
{
    # /**
    #  * Whether or not to allow NaN.
    #  *
    #  * @var true
    #  */
    # const ACCEPT_NAN = true;

    # /**
    #  * Whether or not to allow INF.
    #  *
    #  * @var true
    #  */
    # const ACCEPT_INF = true;

    /**
     * Gets a float value.
     *
     * @return float
     */
    public function value(): float;
}
