<?php declare(strict_types=1);

namespace Esse\Tests\Util;

use Esse\Util\EnumerateConstantsTrait;
use LogicException;
use PHPUnit\Framework\TestCase;

final class EnumerateConstantsTraitTest extends TestCase
{
    // Mock class and interface used by tests are defined after this test class.

    public function test_to_array()
    {
        $instance = new class extends AbstractEnumerateConstants implements EnumerateConstantsA {};
        $expected = [ 'zero' => 0, 'one' => 1, 'two' => 2, 'three' => 3, ];
        $this->assertEquals($expected, $instance->toArray());
    }

    public function test_include_constants()
    {
        $instance = new class extends AbstractEnumerateConstants implements EnumerateConstantsA {
            protected static function includedConstantsInEnums(): array
            {
                return ['one', 'three',];
            }
        };
        $expected = [ 'one' => 1, 'three' => 3, ];
        $this->assertEquals($expected, $instance->toArray());
    }

    public function test_exclude_constants()
    {
        $instance = new class extends AbstractEnumerateConstants implements EnumerateConstantsA {
            protected static function excludedConstantsFromEnums(): array
            {
                return ['one', 'three',];
            }
        };
        $expected = [ 'zero' => 0, 'two' => 2, ];
        $this->assertEquals($expected, $instance->toArray());
    }

    public function test_including_has_priority_over_excluding()
    {
        $instance = new class extends AbstractEnumerateConstants implements EnumerateConstantsA {
            protected static function includedConstantsInEnums(): array
            {
                return ['two', 'three',];
            }
            protected static function excludedConstantsFromEnums(): array
            {
                return ['one', 'two',]; // This will be ignored.
            }
        };
        $expected = [ 'two' => 2, 'three' => 3, ];
        $this->assertEquals($expected, $instance->toArray());
    }

    public function test_fail_with_duplicated_values()
    {
        $instance = new class extends AbstractEnumerateConstants { const Foo = 'foo'; const Bar = 'foo'; };
        $this->expectException(LogicException::class);
        $instance->toArray();
    }
}

abstract class AbstractEnumerateConstants { use EnumerateConstantsTrait; }

interface EnumerateConstantsA {
    const zero  = 0;
    const one   = 1;
    const two   = 2;
    const three = 3;
}
