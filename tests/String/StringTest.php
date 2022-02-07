<?php declare(strict_types=1);

namespace Esse\Tests\String
{
    use Esse\Tests\String\StringTest\Mock;
    use PHPUnit\Framework\TestCase;

    final class StringTest extends TestCase
    {
        public function test_validate()
        {
            $valids = [ 'abcd', '', 'あいうえお', '1978', __CLASS__, ];

            foreach ($valids as $valid) {
                $this->assertTrue(Mock::validate($valid));
            }

            $invalids = [ false, 0, 123.45, null, ];

            foreach ($invalids as $invalid) {
                $this->assertFalse(Mock::validate($invalid));
            }
        }
    }
}

namespace Esse\Tests\String\StringTest
{
    use Esse\String\StringInterface;
    use Esse\String\StringTrait;

    class Mock implements StringInterface { use StringTrait; }
}
