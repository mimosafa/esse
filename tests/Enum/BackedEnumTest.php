<?php declare(strict_types=1);

namespace Esse\Tests\Enum {

    use Esse\Tests\Enum\BackedEnumTest\Suit;
    use PHPUnit\Framework\TestCase;
    use ValueError;

    final class BackedEnumTest extends TestCase
    {
        public function test_get_case()
        {
            $diamonds = Suit::Diamonds();
            $this->assertInstanceOf(Suit::class, $diamonds);
            $this->assertTrue($diamonds === Suit::Diamonds());
            $this->assertEquals('Diamonds', $diamonds->name);
            $this->assertEquals('D', $diamonds->value);
        }

        public function test_from()
        {
            $spades = Suit::from('S');
            $this->assertInstanceOf(Suit::class, $spades);

            $this->expectException(ValueError::class);
            $jokers = Suit::from('J');
        }

        public function test_try_from()
        {
            $clubs = Suit::tryFrom('C');
            $this->assertInstanceOf(Suit::class, $clubs);

            $this->assertNull(Suit::tryFrom('J'));
        }
    }

}

namespace Esse\Tests\Enum\BackedEnumTest {

    use Esse\Enum\BackedEnumInterface;
    use Esse\Enum\BackedEnumTrait;

    /**
     * @method static self Hearts()
     * @method static self Diamonds()
     * @method static self Clubs()
     * @method static self Spades()
     */
    class Suit implements BackedEnumInterface
    {
        use BackedEnumTrait;
        protected static function toArray(): array
        {
            return [
                'Hearts' => 'H',
                'Diamonds' => 'D',
                'Clubs' => 'C',
                'Spades' => 'S',
            ];
        }
    }

}
