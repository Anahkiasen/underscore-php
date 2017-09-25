<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore;

use Underscore\Types\Arrays;
use Underscore\Types\Strings;

/**
 * @coversNothing
 */
class MethodTest extends UnderscoreTestCase
{
    public function testThrowsErrorIfIncorrectMethod()
    {
        $this->setExpectedException('BadMethodCallException');

        Underscore::invalid('foo');
    }

    public function testHasAccessToOriginalPhpFunctions()
    {
        $array = Arrays::from($this->array);
        $array = $array->intersect(['foo' => 'bar', 'kal' => 'mon']);

        $this->assertSame(['foo' => 'bar'], $array->obtain());

        $string = Strings::repeat('foo', 2);
        $this->assertSame('foofoo', $string);

        $string = Strings::from('   foo  ')->trim();
        $this->assertSame('foo', $string->obtain());
    }

    public function testCantChainCertainMethods()
    {
        $method = Method::isUnchainable('Arrays', 'range');

        $this->assertTrue($method);
    }

    public function testCanGetMethodsFromType()
    {
        $method = Method::getMethodsFromType('\Underscore\Types\Arrays');

        $this->assertSame('\Underscore\Methods\ArraysMethods', $method);
    }

    public function testCanGetAliasesOfFunctions()
    {
        $method = Method::getAliasOf('select');

        $this->assertSame('filter', $method);
    }

    public function testCanFindMethodsInClasses()
    {
        $method = Method::findInClasses('\Underscore\Underscore', 'range');

        $this->assertSame('\Underscore\Types\\Arrays', $method);
    }

    public function testCanThrowExceptionAtUnknownMethods()
    {
        $this->setExpectedException(
            'BadMethodCallException',
            'The method Underscore\Types\Arrays::fuck does not exist'
        );

        $test = Arrays::fuck($this);
    }
}
