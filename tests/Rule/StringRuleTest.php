<?php declare(strict_types=1);

namespace Esse\Tests\Rule;

use Esse\Rule\StringRule;
use PHPUnit\Framework\TestCase;

final class StringRuleTest extends TestCase
{
    public function test_dont_accept_multibyte()
    {
        $default = new StringRule();
        $singlebyte = new StringRule(acceptMultibyte: false);

        $valids = [ '1234abcd', '___??><aa', ' ', ];

        foreach ($valids as $valid) {
            $this->assertTrue($default->validate($valid));
            $this->assertTrue($singlebyte->validate($valid));
        }

        $invalids = [ 'あいう', 'aｂｃd', '　', '❤' ];

        foreach ($invalids as $invalid) {
            $this->assertTrue($default->validate($invalid));
            $this->assertFalse($singlebyte->validate($invalid));
        }
    }
}
