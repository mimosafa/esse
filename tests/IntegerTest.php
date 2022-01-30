<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\IntegerInterface;
use Esse\IntegerTrait;
use PHPUnit\Framework\TestCase;

final class IntegerTest extends TestCase
{
    public function test_validate()
    {
        $valids = [ -3, 0, 1, 999999, 0x1A, 0b1101, \PHP_INT_MAX, ];

        foreach ($valids as $valid) {
            $this->assertTrue(IntegerTestMock::validate($valid));
        }

        $invalids = [ '1', 3.14, true, \M_PI, \INF, ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(IntegerTestMock::validate($invalid));
        }
    }
}

class IntegerTestMock implements IntegerInterface { use IntegerTrait; }
