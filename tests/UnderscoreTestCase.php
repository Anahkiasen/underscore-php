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

use PHPUnit_Framework_TestCase;

abstract class UnderscoreTestCase extends PHPUnit_Framework_TestCase
{
    public $array = ['foo' => 'bar', 'bis' => 'ter'];
    public $arrayNumbers = [1, 2, 3];
    public $arrayMulti = [
        ['foo' => 'bar', 'bis' => 'ter'],
        ['foo' => 'bar', 'bis' => 'ter'],
        ['bar' => 'foo', 'bis' => 'ter'],
    ];
    public $object;
    public $arrayObjectNumbers;
    public $arrayObjectMulti;
    public $arrayObjectMulti2;

    /**
     * Restore data just in case.
     */
    public function setUp()
    {
        $this->object = (object) $this->array;
        $this->objectMulti = (object) [
            (object) $this->arrayMulti[0],
            (object) $this->arrayMulti[1],
            (object) $this->arrayMulti[2],
        ];

        $this->arrayObjectNumbers = new \ArrayObject();
        $this->arrayObjectNumbers[] = (object) ['value' => 1];
        $this->arrayObjectNumbers[] = (object) ['value' => 2];
        $this->arrayObjectNumbers[] = (object) ['value' => 3];

        $this->arrayObjectMulti = new \ArrayObject();
        $this->arrayObjectMulti['a'] = new \ArrayObject();
        $this->arrayObjectMulti['a']['b'] = 1;
        $this->arrayObjectMulti['a']['c'] = 2;

        $this->arrayObjectMulti2 = new \ArrayObject();
        $this->arrayObjectMulti2['a'] = [
            'b' => 1,
            'c' => 2,
        ];
    }
}
