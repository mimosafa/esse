<?php declare(strict_types=1);

namespace Esse\Tests
{
    use Esse\Tests\PseoudoFloatTest\CalcurationResult;
    use Esse\Tests\PseoudoFloatTest\DefaultFloat;
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
}
