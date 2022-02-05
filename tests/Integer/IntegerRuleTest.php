<?php declare(strict_types=1);

namespace Esse\Tests\Integer;

use Esse\Integer\IntegerRule;
use LogicException;
use PHPUnit\Framework\TestCase;

final class IntegerRuleTest extends TestCase
{
    public function test_fail_to_initialize()
    {
        new IntegerRule(min:0, max:0);

        $this->expectException(LogicException::class);
        new IntegerRule(min: 1, max: 0);
    }

    public function test_min()
    {
        $rule = new IntegerRule(min: 10);
        $this->assertFalse($rule->validate(9));
        $this->assertTrue($rule->validate(10));
        $this->assertTrue($rule->validate(11));
    }

    public function test_max()
    {
        $rule = new IntegerRule(max: 10);
        $this->assertTrue($rule->validate(9));
        $this->assertTrue($rule->validate(10));
        $this->assertFalse($rule->validate(11));
    }
}
