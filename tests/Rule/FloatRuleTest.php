<?php declare(strict_types=1);

namespace Esse\Tests\Rule;

use Esse\Rule\FloatRule;
use PHPUnit\Framework\TestCase;

final class FloatRuleTest extends TestCase
{
    public function test_accept_nan()
    {
        $default = new FloatRule();
        $this->assertFalse($default->acceptNan());
        $this->assertFalse($default->validate(NAN));

        $accept = new FloatRule(acceptNan: true);
        $this->assertTrue($accept->acceptNan());
        $this->assertTrue($accept->validate(NAN));
    }

    public function test_accept_inf()
    {
        $default = new FloatRule();
        $this->assertFalse($default->acceptInf());
        $this->assertFalse($default->validate(INF));

        $accept = new FloatRule(acceptInf: true);
        $this->assertTrue($accept->acceptInf());
        $this->assertTrue($accept->validate(INF));
    }
}
