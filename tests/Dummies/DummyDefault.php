<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore\Dummies;

use Underscore\Types\Strings;

class DummyDefault extends Strings
{
    /**
     * Get the default value.
     *
     * @return string
     */
    public function getDefault()
    {
        return 'foobar';
    }

    /**
     * How the repository is to be cast to array.
     *
     * @return array
     */
    public function toArray()
    {
        return ['foo', 'bar'];
    }
}
