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

    public function test_validate_with_comparison()
    {
        $this->assertFalse(IntegerTestMockGte::validate(-1));
        $this->assertFalse(IntegerTestMockGte::validate(0));
        $this->assertTrue(IntegerTestMockGte::validate(1));
        $this->assertTrue(IntegerTestMockGte::validate(2));

        $this->assertFalse(IntegerTestMockGt::validate(0));
        $this->assertFalse(IntegerTestMockGt::validate(1));
        $this->assertTrue(IntegerTestMockGt::validate(2));
        $this->assertTrue(IntegerTestMockGt::validate(3));

        $this->assertTrue(IntegerTestMockLt::validate(253));
        $this->assertTrue(IntegerTestMockLt::validate(254));
        $this->assertFalse(IntegerTestMockLt::validate(255));
        $this->assertFalse(IntegerTestMockLt::validate(256));

        $this->assertTrue(IntegerTestMockLte::validate(254));
        $this->assertTrue(IntegerTestMockLte::validate(255));
        $this->assertFalse(IntegerTestMockLte::validate(256));
        $this->assertFalse(IntegerTestMockLte::validate(257));
    }
}

class IntegerTestMock implements IntegerInterface { use IntegerTrait; }
class IntegerTestMockGte extends IntegerTestMock { const GREATER_THAN_OR_EQUAL_TO = 1; }
class IntegerTestMockGt extends IntegerTestMock { const GREATER_THAN = 1; }
class IntegerTestMockLt extends IntegerTestMock { const LESS_THAN = 255; }
class IntegerTestMockLte extends IntegerTestMock { const LESS_THAN_OR_EQUAL_TO = 255; }
