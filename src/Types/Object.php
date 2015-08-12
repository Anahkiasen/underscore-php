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

use stdClass;
use Underscore\Methods\ObjectMethods;
use Underscore\Traits\Repository;

/**
 * Object repository.
 *
 * @mixin ObjectMethods
 */
class Object extends Repository
{
    /**
     * The method used to convert new subjects.
     *
     * @var string
     */
    protected $typecaster = 'toObject';

    /**
     * Get a default value for a new repository.
     *
     * @return mixed
     */
    protected function getDefault()
    {
        return new stdClass();
    }
}
