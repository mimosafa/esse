<?php declare(strict_types=1);

namespace Esse\Tests\String;

use Esse\String\StringRule;
use LogicException;
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

    public function test_min_length()
    {
        $noRules = new StringRule();
        $definedMinLength = new StringRule(minLength: 5);

        $valids = [ '12345', 'あいうえお', '_ _ ?', __METHOD__, ];

        foreach ($valids as $valid) {
            $this->assertTrue($noRules->validate($valid));
            $this->assertTrue($definedMinLength->validate($valid));
        }

        $invalids = [ '1234', 'かきくけ', '', ];

        foreach ($invalids as $invalid) {
            $this->assertTrue($noRules->validate($invalid));
            $this->assertFalse($definedMinLength->validate($invalid));
        }
    }

    public function test_max_length()
    {
        $noRules = new StringRule();
        $definedMaxLength = new StringRule(maxLength: 5);

        $valids = [ '12345', 'かきくけこ', '', ];

        foreach ($valids as $valid) {
            $this->assertTrue($noRules->validate($valid));
            $this->assertTrue($definedMaxLength->validate($valid));
        }

        $invalids = [ '123456', 'あいうえおk', '_ _ _?', __METHOD__, ];

        foreach ($invalids as $invalid) {
            $this->assertTrue($noRules->validate($invalid));
            $this->assertFalse($definedMaxLength->validate($invalid));
        }
    }

    public function test_fail_to_initialize_1()
    {
        $this->expectException(LogicException::class);
        new StringRule(minLength: 10, maxLength: 5);
    }
}
