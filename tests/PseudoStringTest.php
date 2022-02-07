<?php declare(strict_types=1);

namespace Esse\Tests
{

    use Esse\Tests\PseudoStringTest\Password;
    use Esse\Tests\PseudoStringTest\UserName;
    use PHPUnit\Framework\TestCase;
    use ValueError;

    final class PseudoStringTest extends TestCase
    {
        public function test_disallow_multibyte()
        {
            $this->assertTrue(Password::validate('Password'));
            $this->assertFalse(Password::validate('Ｐａｓｓｗｏｒｄ'));
        }

        public function test_regex_pattern_and_length()
        {
            $this->assertTrue(UserName::validate('mimosafa'));
            $this->assertFalse(UserName::validate('mi-mo?sa!fa'));
            $this->assertTrue(UserName::validate('12345678'));
            $this->assertFalse(UserName::validate('1234567'));
            $this->assertTrue(UserName::validate('abcdefghijkemnop'));
            $this->assertFalse(UserName::validate('abcdefghijkemnopq'));
        }

        public function test_from()
        {
            $password = Password::from('Password');
            $this->assertInstanceOf(Password::class, $password);
            $this->assertEquals('Password', $password->value());
        }

        public function test_fail_from()
        {
            $this->expectException(ValueError::class);
            Password::from('Ｐａｓｓｗｏｒｄ');
        }

        public function test_try_from()
        {
            $userName = UserName::tryFrom('mimosafa');
            $this->assertInstanceOf(UserName::class, $userName);
            $this->assertNull(UserName::tryFrom('mi-mo?sa!fa'));
        }
    }
}

namespace Esse\Tests\PseudoStringTest
{

    use Esse\PseudoString;

    class Password extends PseudoString
    {
        const MULTIBYTE = false;
    }

    class UserName extends PseudoString
    {
        const REGEX_PATTERN = '/^[a-zA-Z0-9_-]+$/';
        const MIN_LENGTH = 8;
        const MAX_LENGTH = 16;
    }
}
