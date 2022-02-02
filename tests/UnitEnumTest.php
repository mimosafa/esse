<?php declare(strict_types=1);

namespace Esse\Tests {

    use Error;
    use Esse\Tests\UnitEnumTest\Suit;
    use PHPUnit\Framework\TestCase;

    final class UnitEnumTest extends TestCase
    {
        public function test_get_case()
        {
            $hearts = Suit::Hearts();
            $this->assertInstanceOf(Suit::class, $hearts);

            $this->expectException(Error::class);
            $jokers = Suit::Jokers();
        }

        public function test_name()
        {
            $clubs = Suit::Clubs();
            $this->assertEquals('Clubs', $clubs->name);
        }

        public function test_cases()
        {
            $cases = Suit::cases();
            $expects = [ Suit::Hearts(), Suit::Diamonds(), Suit::Clubs(), Suit::Spades() ];
            $this->assertEquals($expects, $cases);
        }
    }

}

namespace Esse\Tests\UnitEnumTest {

    use Esse\UnitEnumInterface;
    use Esse\UnitEnumTrait;

    /**
     * @method static self Hearts()
     * @method static self Diamonds()
     * @method static self Clubs()
     * @method static self Spades()
     */
    class Suit implements UnitEnumInterface
    {
        use UnitEnumTrait;
        protected static function toArray(): array
        {
            return [ 'Hearts', 'Diamonds', 'Clubs', 'Spades', ];
        }
    }

}
