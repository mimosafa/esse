<?php declare(strict_types=1);

namespace Esse\Tests
{
    use Esse\Tests\InstanceFromValueTest\StringValue;
    use PHPUnit\Framework\TestCase;

    final class InstanceFromValueTest extends TestCase
    {
        public function test_from()
        {
            $string = StringValue::from('string');
            $this->assertInstanceOf(StringValue::class, $string);
        }

        public function test_fail_from()
        {
            $this->expectError();
            StringValue::from(0);
        }

        public function test_try_from()
        {
            $abc = StringValue::tryFrom('abc');
            $this->assertInstanceOf(StringValue::class, $abc);
            $fail = StringValue::tryFrom(3.14);
            $this->assertNull($fail);
        }
    }
}

namespace Esse\Tests\InstanceFromValueTest
{
    use Esse\Value\InstanceFromValueTrait;

    class StringValue
    {
        use InstanceFromValueTrait;
        private function __construct(private string $value) {}
        public static function validate($value): bool { return \is_string($value); }
    }
}
