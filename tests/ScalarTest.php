<?php declare(strict_types=1);

namespace Esse\Tests {

    use Esse\Tests\ScalarTest\Mock;
    use PHPUnit\Framework\TestCase;
    use stdClass;

    final class ScalarTest extends TestCase
    {
        public function test_validate()
        {
            $valids = [ true, 0, 3090, 0.00234, M_PI, '', 'String', ];

            foreach ($valids as $valid) {
                $this->assertTrue(Mock::validate($valid));
            }

            $invalids = [ null, [1, 5, 'a'], new stdClass, (fn() => 'fn'), ];

            foreach ($invalids as $invalid) {
                $this->assertFalse(Mock::validate($invalid));
            }
        }
    }

}

namespace Esse\Tests\ScalarTest {

    use Esse\ScalarInterface;
    use Esse\ScalarTrait;

    class Mock implements ScalarInterface { use ScalarTrait; }
}
