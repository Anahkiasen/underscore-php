<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore\Types;

use Underscore\UnderscoreTestCase;

/**
 * @coversNothing
 */
class NumberTest extends UnderscoreTestCase
{
    public function testCanCreateNewNumber()
    {
        $this->assertSame(0, Number::create()->obtain());
    }

    public function testCanAccessStrPad()
    {
        $number = Number::pad(5, 3, 1, STR_PAD_BOTH);

        $this->assertSame('151', $number);
    }

    public function testCanPadANumber()
    {
        $number = Number::padding(5, 3);

        $this->assertSame('050', $number);
    }

    public function testCanPadANumberOnTheLeft()
    {
        $number = Number::paddingLeft(5, 3);

        $this->assertSame('005', $number);
    }

    public function testCanPadANumberOnTheRight()
    {
        $number = Number::paddingRight(5, 3);

        $this->assertSame('500', $number);
    }

    public function testCanUsePhpRoundingMethods()
    {
        $number = Number::round(5.33);
        $this->assertSame(5, $number);

        $number = Number::ceil(5.33);
        $this->assertSame(6, $number);

        $number = Number::floor(5.33);
        $this->assertSame(5, $number);
    }
}
