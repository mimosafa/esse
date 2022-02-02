<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\StringInterface;
use Esse\StringTrait;
use PHPUnit\Framework\TestCase;

final class StringTest extends TestCase
{
    // The mock classes used in the tests are defined after this test class.

    public function test_validate()
    {
        $valids = [ 'abcd', '', 'あいうえお', '1978', __CLASS__, ];

        foreach ($valids as $valid) {
            $this->assertTrue(StringTestMock::validate($valid));
        }

        $invalids = [ false, 0, 123.45, null, ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(StringTestMock::validate($invalid));
        }
    }
}

class StringTestMock implements StringInterface { use StringTrait; }
