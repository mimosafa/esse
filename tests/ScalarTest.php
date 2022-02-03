<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\ScalarInterface;
use Esse\ScalarTrait;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ScalarTest extends TestCase
{
    // The mock class used in the tests are defined after this test class.

    public function test_validate()
    {
        $valids = [ true, 0, 3090, 0.00234, M_PI, '', 'String', ];

        foreach ($valids as $valid) {
            $this->assertTrue(ScalarTestMock::validate($valid));
        }

        $invalids = [ null, [1, 5, 'a'], new stdClass, (fn() => 'fn'), ];

        foreach ($invalids as $invalid) {
            $this->assertFalse(ScalarTestMock::validate($invalid));
        }
    }
}

class ScalarTestMock implements ScalarInterface { use ScalarTrait; }
