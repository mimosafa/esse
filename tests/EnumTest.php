<?php declare(strict_types=1);

namespace Esse\Tests;

use Esse\EnumInterface;
use Esse\EnumTrait;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function test_name()
    {
        $hearts = EnumTestSuit::from('H');
        $this->assertEquals('Hearts', $hearts->name());
        $this->assertEquals($hearts->name(), $hearts->name);
    }

    public function test_cases()
    {
        $cases = EnumTestSuit::cases();
        $this->assertEquals(\array_values($cases), $cases);

        $array = \array_values(EnumTestSuit::toArray());
        foreach ($cases as $i => $case) {
            $this->assertEquals($array[$i], $case->value);
        }
    }

    public function test_all()
    {
        $all = EnumTestSuit::all();
        $array = EnumTestSuit::toArray();

        foreach ($all as $name => $case) {
            $this->assertEquals($array[$name], $case->value);
        }
    }
}

interface EnumTestSuitInterface extends EnumInterface {
    const Hearts   = 'H';
    const Diamonds = 'D';
    const Clubs    = 'C';
    const Spades   = 'S';
}
class EnumTestSuit implements EnumTestSuitInterface {
    use EnumTrait;
}
