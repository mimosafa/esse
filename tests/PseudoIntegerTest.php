<?php declare(strict_types=1);

namespace Esse\Tests
{

    use Esse\Tests\PseudoIntegerTest\Rating;
    use PHPUnit\Framework\TestCase;

    final class PseudoIntegerTest extends TestCase
    {
        public function test_defined_range()
        {
            foreach (\range(-25, 25) as $int) {
                if ($int >= Rating::MIN && $int <= Rating::MAX) {
                    $this->assertTrue(Rating::validate($int));
                } else {
                    $this->assertFalse(Rating::validate($int));
                }
            }
        }
    }
}

namespace Esse\Tests\PseudoIntegerTest
{
    use Esse\PseudoInteger;

    class Rating extends PseudoInteger
    {
        const MIN = 1;
        const MAX = 10;
    }
}
