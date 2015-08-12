<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore\Methods;

/**
 * Methods to manage numbers.
 */
class NumberMethods
{
    /**
     * Add 0 padding to an integer.
     */
    public static function padding($number, $padding = 1, $direction = STR_PAD_BOTH)
    {
        return str_pad($number, $padding, 0, $direction);
    }

    /**
     * Add 0 padding on the left of an integer.
     */
    public static function paddingLeft($number, $padding = 1)
    {
        return static::padding($number, $padding, STR_PAD_LEFT);
    }

    /**
     * Add 0 padding on the right of an integer.
     */
    public static function paddingRight($number, $padding = 1)
    {
        return static::padding($number, $padding, STR_PAD_RIGHT);
    }
}
