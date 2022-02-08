<?php declare(strict_types=1);

namespace Esse\Tests\Float;

use Esse\Float\FloatRule;
use LogicException;
use PHPUnit\Framework\TestCase;

final class FloatRuleTest extends TestCase
{
    public function test_accept_nan()
    {
        $default = new FloatRule();
        $this->assertFalse($default->validate(NAN));

        $accept = new FloatRule(acceptNan: true);
        $this->assertTrue($accept->validate(NAN));
    }

    public function test_accept_inf()
    {
        $default = new FloatRule();
        $this->assertFalse($default->validate(INF));

        $accept = new FloatRule(acceptInf: true);
        $this->assertTrue($accept->validate(INF));
    }

    public function test_definded_value_range()
    {
        $definedRangeOne = new FloatRule(gte: 1.5, lt: 10);
        $this->assertFalse($definedRangeOne->validate(1.4));
        $this->assertTrue($definedRangeOne->validate(1.5));
        $this->assertTrue($definedRangeOne->validate(9.99999));
        $this->assertFalse($definedRangeOne->validate(10.0));

        $definedRangeTwo = new FloatRule(gt: 1.5, lte: 10);
        $this->assertFalse($definedRangeTwo->validate(1.5));
        $this->assertTrue($definedRangeTwo->validate(1.5001));
        $this->assertTrue($definedRangeTwo->validate(10.0));
        $this->assertFalse($definedRangeTwo->validate(10.0001));
    }

    public function test_fail_to_construct_one()
    {
        $this->expectException(LogicException::class);
        new FloatRule(gte: 1, gt: 1);
    }

    public function test_fail_to_construct_two()
    {
        $this->expectException(LogicException::class);
        new FloatRule(lt: 10, lte: 10);
    }

    public function test_fail_to_construct_three()
    {
        $this->expectException(LogicException::class);
        new FloatRule(gte: 1, lt: 1);
    }

    public function test_fail_to_construct_four()
    {
        $valid = new FloatRule(gte: 1, lte: 1);
        $this->assertInstanceOf(FloatRule::class, $valid);
        $this->expectException(LogicException::class);
        new FloatRule(gte: 1, lte: 0.99999999);
    }

    public function test_fail_to_construct_five()
    {
        $this->expectException(LogicException::class);
        new FloatRule(gt: 1, lt: 1);
    }

    public function test_fail_to_construct_six()
    {
        $this->expectException(LogicException::class);
        new FloatRule(gt: 1, lte: 1);
    }
}
