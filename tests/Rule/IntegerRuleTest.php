<?php declare(strict_types=1);

namespace Esse\Tests\Rule;

use Esse\Rule\IntegerRule;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class IntegerRuleTest extends TestCase
{
    public function test_fail_to_initialize_1()
    {
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(gte: 1, gt: 0);
    }

    public function test_fail_to_initialize_2()
    {
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(lte: 99, lt: 100);
    }

    public function test_fail_to_initialize_3()
    {
        $rule = new IntegerRule(gte: 9, lt: 10);
        $this->assertInstanceOf(IntegerRule::class, $rule);
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(gte: 10, lt: 10);
    }

    public function test_fail_to_initialize_4()
    {
        $rule = new IntegerRule(gte: 10, lte: 10);
        $this->assertInstanceOf(IntegerRule::class, $rule);
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(gte: 10, lte: 9);
    }

    public function test_fail_to_initialize_5()
    {
        $rule = new IntegerRule(gt: 9, lt: 11);
        $this->assertInstanceOf(IntegerRule::class, $rule);
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(gt: 10, lt: 11);
    }

    public function test_fail_to_initialize_6()
    {
        $rule = new IntegerRule(gt: 10, lte: 11);
        $this->assertInstanceOf(IntegerRule::class, $rule);
        $this->expectException(InvalidArgumentException::class);
        new IntegerRule(gt: 11, lte: 11);
    }

    public function test_greater_than_or_equal_to()
    {
        $rule = new IntegerRule(gte: 10);
        $this->assertFalse($rule->validate(9));
        $this->assertTrue($rule->validate(10));
        $this->assertTrue($rule->validate(11));
    }

    public function test_greater_than()
    {
        $rule = new IntegerRule(gt: 10);
        $this->assertFalse($rule->validate(9));
        $this->assertFalse($rule->validate(10));
        $this->assertTrue($rule->validate(11));
    }

    public function test_less_than()
    {
        $rule = new IntegerRule(lt: 10);
        $this->assertTrue($rule->validate(9));
        $this->assertFalse($rule->validate(10));
        $this->assertFalse($rule->validate(11));
    }

    public function test_less_than_or_equal_to()
    {
        $rule = new IntegerRule(lte: 10);
        $this->assertTrue($rule->validate(9));
        $this->assertTrue($rule->validate(10));
        $this->assertFalse($rule->validate(11));
    }
}
