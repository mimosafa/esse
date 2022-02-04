<?php declare(strict_types=1);

namespace Esse\Tests\Enum {

    use Esse\Tests\Enum\EnumTest\Suit;
    use Esse\Tests\Enum\EnumTest\SuitDefinedConstants;
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

        public function test_enums_from_constants()
        {
            $all = SuitDefinedConstants::all();
            $array = SuitDefinedConstants::toArray();

            foreach ($all as $name => $case) {
                $this->assertEquals($array[$name], $case->value());
            }
        }
    }

}

namespace Esse\Tests\Enum\EnumTest {

    use Esse\Enum\EnumerateConstantsTrait;
    use Esse\Enum\EnumInterface;
    use Esse\Enum\EnumTrait;

    class Suit implements EnumInterface {
        use EnumTrait;
        public static function toArray(): array
        {
            return [
                'Hearts' => 'H',
                'Diamonds' => 'D',
                'Clubs' => 'C',
                'Spades' => 'S',
            ];
        }
    }

    class SuitDefinedConstants implements EnumInterface
    {
        use EnumTrait, EnumerateConstantsTrait;
        const Hearts = 'H';
        const Diamonds = 'D';
        const Clubs = 'C';
        const Spades = 'S';
    }

}
