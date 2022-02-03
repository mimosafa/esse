<?php declare(strict_types=1);

namespace Esse\Tests\String;

use Esse\String\StringRule;
use PHPUnit\Framework\TestCase;

final class StringRuleTest extends TestCase
{
    public function test_do_not_accept_multibyte()
    {
        $noRules = new StringRule();
        $singlebyte = new StringRule(multibyte: false);

        $valids = [ '1234abcd', '___??><aa', ' ', ];

        foreach ($valids as $valid) {
            $this->assertTrue($noRules->validate($valid));
            $this->assertTrue($singlebyte->validate($valid));
        }

        $invalids = [ 'あいう', 'aｂｃd', '　', '❤' ];

        foreach ($invalids as $invalid) {
            $this->assertTrue($noRules->validate($invalid));
            $this->assertFalse($singlebyte->validate($invalid));
        }
    }

    public function test_defined_regex_pattern()
    {
        $noRules = new StringRule();
        $definedRegexPattern = new StringRule(regexPattern: '/^a[b-y]+z$/');

        $valids = [ 'abcz', 'absckmknscknz', ];

        foreach ($valids as $valid) {
            $this->assertTrue($noRules->validate($valid));
            $this->assertTrue($definedRegexPattern->validate($valid));
        }

        $invalids = [ 'abcde', 'xyz', 'aabsdz', 'a965z', ];

        foreach ($invalids as $invalid) {
            $this->assertTrue($noRules->validate($invalid));
            $this->assertFalse($definedRegexPattern->validate($invalid));
        }
    }
}
