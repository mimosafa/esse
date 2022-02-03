<?php declare(strict_types=1);

namespace Esse\Tests {

    use Esse\Tests\ValueTest\InheritedMock;
    use Esse\Tests\ValueTest\Mock;
    use PHPUnit\Framework\TestCase;

    final class ValueTest extends TestCase
    {
        public function test_value()
        {
            $value = \rand();
            $instance = new Mock($value);
            $this->assertEquals($value, $instance->value());
        }

        public function test_equivalence_with_same_instance()
        {
            $instance = new Mock(\rand());
            $this->assertTrue($instance->isEqual($instance));
            $this->assertTrue($instance->isIdentical($instance));
        }

        public function test_equivalence_with_original_value()
        {
            $value = \rand();
            $instance = new Mock($value);
            $this->assertTrue($instance->isEqual($value));
            $this->assertFalse($instance->isIdentical($value));
        }

        public function test_equivalance_with_typecasted_original_value()
        {
            $value = \rand();
            $instance = new Mock(\strval($value));
            $this->assertFalse($instance->isEqual($value));
            $this->assertFalse($instance->isIdentical($value));
        }

        public function test_equivalance_with_different_value()
        {
            $value = \rand(1, 9999);
            $another = $value * 2;
            $instance = new Mock($value);
            $anotherInstance = new Mock($another);
            $this->assertFalse($instance->isEqual($another));
            $this->assertFalse($instance->isIdentical($another));
            $this->assertFalse($instance->isEqual($anotherInstance));
            $this->assertFalse($instance->isIdentical($anotherInstance));
        }

        public function test_equivalance_with_same_origin_value_but_another_instance()
        {
            $value = \rand();
            $instance = new Mock($value);
            $anotherInstance = new Mock($value);
            $this->assertTrue($instance->isEqual($anotherInstance));
            $this->assertTrue($instance->isIdentical($anotherInstance));
        }

        public function test_equivalance_with_inherited_class_instance()
        {
            $value = \rand();
            $instance = new Mock($value);
            $inherited = new InheritedMock($value);
            $this->assertTrue($instance->isEqual($inherited));
            $this->assertFalse($instance->isIdentical($inherited));
        }

        public function test_equivalance_with_parent_class_instance()
        {
            $value = \rand();
            $instance = new Mock($value);
            $inherited = new InheritedMock($value);
            $this->assertTrue($inherited->isEqual($instance));
            $this->assertFalse($inherited->isIdentical($instance));
        }
    }

}

namespace Esse\Tests\ValueTest {

    use Esse\ValueInterface;
    use Esse\ValueTrait;

    class Mock implements ValueInterface
    {
        use ValueTrait;
        public static function validate($value): bool { return true; }
    }

    class InheritedMock extends Mock {}

}
