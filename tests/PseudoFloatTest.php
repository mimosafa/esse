<?php declare(strict_types=1);

namespace Esse\Tests
{
    use Esse\Tests\PseoudoFloatTest\CalcurationResult;
    use Esse\Tests\PseoudoFloatTest\DefaultFloat;
    use Esse\Tests\PseoudoFloatTest\Distance;
    use Esse\Tests\PseoudoFloatTest\TemperatureAsLiquid;
    use PHPUnit\Framework\TestCase;

    final class PseudoFloatTest extends TestCase
    {
        public function test_accept_nan()
        {
            $nan = \acos(8);
            $this->assertTrue(\is_nan($nan));
            $this->assertFalse(DefaultFloat::validate($nan));
            $this->assertTrue(CalcurationResult::validate($nan));
        }

        public function test_accept_inf()
        {
            $inf = \log(0);
            $this->assertTrue(\is_infinite($inf));
            $this->assertFalse(DefaultFloat::validate($inf));
            $this->assertTrue(CalcurationResult::validate($inf));
        }

        public function test_defined_range()
        {
            $this->assertFalse(Distance::validate(-0.1));
            $this->assertTrue(Distance::validate(0.0));
            $this->assertTrue(Distance::validate(42.195));
            $this->assertFalse(Distance::validate(42.195001));

            $this->assertFalse(TemperatureAsLiquid::validate(0.0));
            $this->assertTrue(TemperatureAsLiquid::validate(0.01));
            $this->assertTrue(TemperatureAsLiquid::validate(99.998));
            $this->assertFalse(TemperatureAsLiquid::validate(100.0));
        }
    }
}

namespace Esse\Tests\PseoudoFloatTest
{
    use Esse\PseudoFloat;

    class DefaultFloat extends PseudoFloat
    {
    }

    class CalcurationResult extends PseudoFloat
    {
        const ACCEPT_NAN = true;
        const ACCEPT_INF = true;
    }

    class Distance extends PseudoFloat
    {
        const GREATER_THAN_OR_EQUAL_TO = 0;
        const LESS_THAN_OR_EQUAL_TO = 42.195;
    }

    class TemperatureAsLiquid extends PseudoFloat
    {
        const GREATER_THAN = 0;
        const LESS_THAN = 100;
    }
}
