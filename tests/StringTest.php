<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\StringInterface;
use Esse\StringTrait;
use PHPUnit\Framework\TestCase;
use Stringable;

final class StringTest extends TestCase
{
    // Mock classes used by tests are defined after this test class.

    public function test_validate()
    {
        $valids = [ 'abcd', '', 'あいうえお', '1978', __CLASS__, new StringTraitStringableMock ];

        foreach ($valids as $valid) {
            $this->assertTrue(StringTestMock::validate($valid));
        }

        $invalids = [ false, 0, 123.45, null, ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(StringTestMock::validate($invalid));
        }
    }

    public function test_is_equal()
    {
        $instance = new StringTestMock(StringTraitStringableMock::VALUE);
        $stringable = new StringTraitStringableMock();

        $this->assertTrue($instance->isEqual($stringable));
    }

    public function test_stringable()
    {
        $value = __CLASS__;
        $instance = new StringTestMock($value);
        $string = (string) $instance;

        $this->assertEquals($value, $string);
    }
}

class StringTestMock implements StringInterface { use StringTrait; }

class StringTraitStringableMock implements Stringable
{
    public const VALUE = 'Stringable';

    public function __toString(): string
    {
        return self::VALUE;;
    }
}
