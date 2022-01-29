<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\ScalarInterface;
use Esse\ScalarTrait;
use PHPUnit\Framework\TestCase;
use stdClass;
use ValueError;

final class ScalarTraitTest extends TestCase
{
    // Mock classes used by tests are defined after this test class.

    public function test_validate()
    {
        $valids = [ true, 0, 3090, 0.00234, M_PI, '', 'String', ];

        foreach ($valids as $valid) {
            $this->assertTrue(ScalarTraitTestMock::validate($valid));
        }

        $invalids = [ null, [1, 5, 'a'], new stdClass, (fn() => 'fn'), ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(ScalarTraitTestMock::validate($invalid));
        }
    }

    public function test_value()
    {
        $value = \rand();
        $instance = new ScalarTraitTestMock($value);
        $this->assertEquals($value, $instance->value());
    }

    public function test_is_equal_and_is_identical()
    {
        $value = \rand();
        $instance = new ScalarTraitTestMock($value);

        // Same instance
        $this->assertTrue($instance->isEqual($instance));
        $this->assertTrue($instance->isIdentical($instance));

        // The original scalar value (*)
        $this->assertTrue($instance->isEqual($value));
        $this->assertFalse($instance->isIdentical($value));

        // The original scalar value but different type
        $strval = (string) $value;
        $this->assertFalse($instance->isEqual($strval));
        $this->assertFalse($instance->isIdentical($strval));

        // Another value
        $anotherValue = $value * 2;
        $this->assertFalse($instance->isEqual($anotherValue));
        $this->assertFalse($instance->isIdentical($anotherValue));

        // Another instance and another value
        $anotherValueInstance = new ScalarTraitTestMock($anotherValue);
        $this->assertFalse($instance->isEqual($anotherValueInstance));
        $this->assertFalse($instance->isIdentical($anotherValueInstance));

        // Another instance but same value
        $sameValueInstance = new ScalarTraitTestMock($value);
        $this->assertTrue($instance->isEqual($sameValueInstance));
        $this->assertTrue($instance->isIdentical($sameValueInstance));

        // Inherited class instance (*)
        $inheritedInstance = new ScalarTraitTestInheritedMock($value);
        $this->assertTrue($instance->isEqual($inheritedInstance));
        $this->assertFalse($instance->isIdentical($inheritedInstance));

        // Execute from inherited class instance (*)
        $this->assertTrue($inheritedInstance->isEqual($instance));
        $this->assertFalse($inheritedInstance->isIdentical($instance));
    }

    public function test_try_from()
    {
        $valid = ScalarTraitTestMock::tryFrom('foo');
        $this->assertInstanceOf(ScalarTraitTestMock::class, $valid);
        $this->assertEquals('foo', $valid->value());

        $invalid = ScalarTraitTestMock::tryFrom(['array', 'is', 'invalid']);
        $this->assertNull($invalid);
    }

    public function test_from()
    {
        $valid = ScalarTraitTestMock::from('bar');
        $this->assertInstanceOf(ScalarTraitTestMock::class, $valid);
        $this->assertEquals('bar', $valid->value());

        $this->expectException(ValueError::class);

        $invalid = ScalarTraitTestMock::from(['array', 'is', 'invalid']);
    }
}

/**
 * Mock class with `ScalarTrait`
 */
class ScalarTraitTestMock implements ScalarInterface { use ScalarTrait; }
class ScalarTraitTestInheritedMock extends ScalarTraitTestMock {}
