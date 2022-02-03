<?php declare(strict_types=1);

namespace Esse\Tests {

    use Esse\Tests\EnumTest\Suit;
    use PHPUnit\Framework\TestCase;

    final class EnumTest extends TestCase
    {
        public function test_name()
        {
            $hearts = new Suit('H');
            $this->assertEquals('Hearts', $hearts->name());
        }

        public function test_all()
        {
            $all = Suit::all();
            $array = Suit::toArray();

            foreach ($all as $name => $case) {
                $this->assertEquals($array[$name], $case->value());
            }
        }
    }

}

namespace Esse\Tests\EnumTest {

    use Esse\EnumInterface;
    use Esse\EnumTrait;

    interface SuitInterface extends EnumInterface
    {
        const Hearts   = 'H';
        const Diamonds = 'D';
        const Clubs    = 'C';
        const Spades   = 'S';
    }

    class Suit implements SuitInterface {
        use EnumTrait;
    }

}
