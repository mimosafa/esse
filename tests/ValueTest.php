<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\ValueInterface;
use Esse\ValueTrait;
use PHPUnit\Framework\TestCase;

final class ValueTest extends TestCase
{
    // The mock classes used in the tests are defined after this test class.

    public function test_value()
    {
        $value = \rand();
        $instance = new ValueTestMock($value);
        $this->assertEquals($value, $instance->value());
    }

    public function test_equivalence_with_same_instance()
    {
        $instance = new ValueTestMock(\rand());
        $this->assertTrue($instance->isEqual($instance));
        $this->assertTrue($instance->isIdentical($instance));
    }

    public function test_equivalence_with_original_value()
    {
        $value = \rand();
        $instance = new ValueTestMock($value);
        $this->assertTrue($instance->isEqual($value));
        $this->assertFalse($instance->isIdentical($value));
    }

    public function test_equivalance_with_typecasted_original_value()
    {
        $value = \rand();
        $instance = new ValueTestMock(\strval($value));
        $this->assertFalse($instance->isEqual($value));
        $this->assertFalse($instance->isIdentical($value));
    }

    public function test_equivalance_with_different_value()
    {
        $value = \rand(1, 9999);
        $another = $value * 2;
        $instance = new ValueTestMock($value);
        $anotherInstance = new ValueTestMock($another);
        $this->assertFalse($instance->isEqual($another));
        $this->assertFalse($instance->isIdentical($another));
        $this->assertFalse($instance->isEqual($anotherInstance));
        $this->assertFalse($instance->isIdentical($anotherInstance));
    }

    public function test_equivalance_with_same_origin_value_but_another_instance()
    {
        $value = \rand();
        $instance = new ValueTestMock($value);
        $anotherInstance = new ValueTestMock($value);
        $this->assertTrue($instance->isEqual($anotherInstance));
        $this->assertTrue($instance->isIdentical($anotherInstance));
    }

    public function test_equivalance_with_inherited_class_instance()
    {
        $value = \rand();
        $instance = new ValueTestMock($value);
        $inherited = new ValueTestInheritedMock($value);
        $this->assertTrue($instance->isEqual($inherited));
        $this->assertFalse($instance->isIdentical($inherited));
    }

    public function test_equivalance_with_parent_class_instance()
    {
        $value = \rand();
        $instance = new ValueTestMock($value);
        $inherited = new ValueTestInheritedMock($value);
        $this->assertTrue($inherited->isEqual($instance));
        $this->assertFalse($inherited->isIdentical($instance));
    }
}

class ValueTestMock implements ValueInterface
{
    use ValueTrait;
    public static function validate($value): bool { return true; }
}

class ValueTestInheritedMock extends ValueTestMock {}
