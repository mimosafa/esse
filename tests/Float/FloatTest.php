<?php declare(strict_types=1);

namespace Esse\Tests\Float
{
    use Esse\Tests\Float\FloatTest\Mock;
    use PHPUnit\Framework\TestCase;

    final class FloatTest extends TestCase
    {
        public function test_validate()
        {
            $valids = [ 1.234, 1.2e3, 7E-10, 1_234.567, M_PI, PHP_FLOAT_MAX, ];

            foreach ($valids as $valid) {
                $this->assertTrue(Mock::validate($valid));
            }

            $invalids = [ 0, null, true, '0.34', '1_234.567', NAN, INF, -INF ];

            foreach ($invalids as $invalid) {
                $this->assertFalse(Mock::validate($invalid));
            }
        }
    }
}

namespace Esse\Tests\Float\FloatTest
{
    use Esse\Float\FloatInterface;
    use Esse\Float\FloatTrait;

    class Mock implements FloatInterface { use FloatTrait; }
}
