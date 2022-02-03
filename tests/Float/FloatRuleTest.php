<?php declare(strict_types=1);

namespace Esse\Tests\Float;

use Esse\Float\FloatRule;
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
}
