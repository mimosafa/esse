<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\FloatInterface;
use Esse\FloatTrait;
use PHPUnit\Framework\TestCase;

final class FloatTest extends TestCase
{
    public function test_validate()
    {
        $valids = [ 1.234, 1.2e3, 7E-10, 1_234.567, M_PI, PHP_FLOAT_MAX, ];

        foreach ($valids as $valid) {
            $this->assertTrue(FloatTestMock::validate($valid));
        }

        $invalids = [ 0, null, true, '0.34', '1_234.567', NAN, INF, -INF ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(FloatTestMock::validate($invalid));
        }
    }
}

class FloatTestMock implements FloatInterface { use FloatTrait; }
