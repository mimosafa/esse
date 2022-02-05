<?php declare(strict_types=1);

namespace Esse\Tests\Enum {

    use Esse\Tests\Enum\EnumTest\Suit;
    use Esse\Tests\Enum\EnumTest\SuitDefinedConstants;
    use PHPUnit\Framework\TestCase;
    use ValueError;

final class EnumTest extends TestCase
    {
        public function test_value_and_name_and_equivalance()
        {
            $hearts = new Suit('H');

            $this->assertEquals('H', $hearts->value());
            $this->assertEquals('Hearts', $hearts->name());

            $this->assertTrue($hearts->isEqual('H'));
            $this->assertTrue($hearts->isEqual(new Suit('H')));
            $this->assertTrue($hearts == new Suit('H'));

            $this->assertFalse($hearts->isIdentical('H'));
            $this->assertTrue($hearts->isIdentical(new Suit('H')));
            $this->assertFalse($hearts === new Suit('H'));
        }

        public function test_all()
        {
            $all = Suit::all();
            $array = Suit::toArray();

            foreach ($all as $name => $case) {
                $this->assertEquals($array[$name], $case->value());
            }
        }

        public function test_from_and_for()
        {
            $clubs = Suit::from('C');

            $this->assertInstanceOf(Suit::class, $clubs);
            $this->assertEquals('C', $clubs->value());
            $this->assertTrue($clubs->isIdentical(Suit::tryFrom('C')));

            $spades = Suit::for('Spades');

            $this->assertInstanceOf(Suit::class, $spades);
            $this->assertEquals('Spades', $spades->name());
            $this->assertTrue($spades->isIdentical(Suit::tryFor('Spades')));
        }

        public function test_fail_from()
        {
            $this->assertNull(Suit::tryFrom('J'));
            $this->expectException(ValueError::class);
            Suit::from(('J'));
        }

        public function test_fail_for()
        {
            $this->assertNull(Suit::tryFor('Joker'));
            $this->expectException(ValueError::class);
            Suit::for('Joker');
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
