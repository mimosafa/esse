<?php declare(strict_types=1);

namespace Esse\Tests
{
    use Esse\Tests\PseudoEnumTest\Description;
    use Esse\Tests\PseudoEnumTest\Progress;
    use Esse\Tests\PseudoEnumTest\Suit;
    use PHPUnit\Framework\TestCase;
    use ReflectionClass;

    final class PseudoEnumTest extends TestCase
    {
        public function test_pseudo_enum()
        {
            $constants = (new ReflectionClass(Suit::class))->getConstants();

            foreach ($constants as $name => $value) {
                $suitFromValue = Suit::from($value);

                $this->assertEquals($value, $suitFromValue->value());
                $this->assertEquals($name, $suitFromValue->name());

                $this->assertTrue($suitFromValue->isEqual(Suit::from($value)));
                $this->assertTrue($suitFromValue->isEqual($value));
                $this->assertTrue($suitFromValue->isIdentical(Suit::from($value)));
                $this->assertFalse($suitFromValue->isIdentical($value));

                $this->assertTrue($suitFromValue == Suit::from($value));
                $this->assertFalse($suitFromValue === Suit::from($value)); // Not singleton instance

                $this->assertTrue(Suit::validate($value));
                $this->assertFalse(Suit::validate($value . '_'));

                $this->assertTrue($suitFromValue->isIdentical(Suit::for($name)));
            }

            foreach ($constants as $name => $value) {
                $suitForName = Suit::for($name);

                $this->assertEquals($name, $suitForName->name());
                $this->assertEquals($value, $suitForName->value());
                $this->assertTrue($suitForName->isEqual(Suit::for($name)));
                $this->assertTrue($suitForName->isIdentical(Suit::for($name)));

                $this->assertTrue($suitForName->isIdentical(Suit::from($value)));
            }
        }

        public function test_includes_constants()
        {
            $progresses = Progress::all();
            $expected = [
                'forward' => Progress::for('forward'),
                'back' => Progress::for('back'),
                'stop' => Progress::for('stop'),
            ];
            $this->assertEquals($expected, $progresses);
        }

        public function test_excludes_constants()
        {
            $descriptions = Description::all();
            $expected = [
                'Name' => Description::for('Name'),
                'Country' => Description::for('Country'),
                'When' => Description::for('When'),
            ];
            $this->assertEquals($expected, $descriptions);
        }
    }
}

namespace Esse\Tests\PseudoEnumTest
{
    use Esse\PseudoEnum;

    class Suit extends PseudoEnum
    {
        const Hearts = 'H';
        const Diamonds = 'D';
        const Clubs = 'C';
        const Spades = 'S';
    }

    class Sugoroku extends PseudoEnum
    {
        const forward = 1;
        const back = -1;
        const stop = 0;
        const Name = 'Sugoroku';
        const Country = 'Japan';
        const When = 'New Year';
    }

    class Progress extends Sugoroku
    {
        protected static $included = ['forward', 'back', 'stop'];
    }

    class Description extends Sugoroku
    {
        protected static $excluded = ['forward', 'back', 'stop'];
    }
}
