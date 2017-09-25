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
class FunctionsTest extends UnderscoreTestCase
{
    public function testCanCallFunctionOnlyOnce()
    {
        $number = 0;
        $function = Functions::once(function () use (&$number) {
            ++$number;
        });

        $function();
        $function();

        $this->assertSame(1, $number);
    }

    public function testCanCallFunctionOnlyXTimes()
    {
        $number = 0;
        $function = Functions::only(function () use (&$number) {
            ++$number;
        }, 3);

        $function();
        $function();
        $function();
        $function();
        $function();

        $this->assertSame(3, $number);
    }

    public function testCanCallFunctionAfterXTimes()
    {
        $number = 0;
        $function = Functions::after(function () use (&$number) {
            ++$number;
        }, 3);

        $function();
        $function();
        $function();
        $function();
        $function();

        $this->assertSame(2, $number);
    }

    public function testCanCacheFunctionResults()
    {
        $function = Functions::cache(function ($string) {
            return microtime();
        });

        $result = $function('foobar');

        $this->assertSame($result, $function('foobar'));
        $this->assertNotSame($result, $function('barfoo'));
    }

    public function testCanThrottleFunctions()
    {
        $number = 0;
        $function = Functions::throttle(function () use (&$number) {
            ++$number;
        }, 1);

        $function();
        $function();
        sleep(1);
        $function();

        $this->assertSame(2, $number);
    }

    public function testCanPartiallyApplyArguments()
    {
        $function = Functions::partial(function () {
            return implode('', func_get_args());
        }, 2, null, 6);

        $this->assertSame('246', $function(4));
        $this->assertSame('2468', $function(4, 8));
    }
}
