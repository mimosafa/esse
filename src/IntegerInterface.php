<?php

namespace Esse;

interface IntegerInterface extends ScalarInterface
{
    # /**
    #  * Accept values GREATER THAN OR EQUAL TO the value defined here.
    #  *
    #  * @var integer
    #  */
    # const GREATER_THAN_OR_EQUAL_TO = 1;

    # /**
    #  * Accept values GREATER THAN the value defined here.
    #  *
    #  * @var integer
    #  */
    # const GREATER_THAN = 0;

    # /**
    #  * Accept values LESS THAN the value defined here.
    #  *
    #  * @var integer
    #  */
    # const LESS_THAN = 255;

    # /**
    #  * Accept values LESS THAN OR EQUAL TO the value defined here.
    #  *
    #  * @var integer
    #  */
    # const LESS_THAN_OR_EQUAL_TO = 254;

    /**
     * Gets the integer value.
     *
     * @return integer
     */
    public function value(): int;
}
