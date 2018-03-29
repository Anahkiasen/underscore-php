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

use Underscore\Methods\StringsMethods;
use Underscore\Traits\Repository;

/**
 * Strings repository.

 *
 *@mixin StringsMethods
 */
class Strings extends Repository
{
    /**
     * The method used to convert new subjects.
     *
     * @var string
     */
    protected $typecaster = 'toString';
}
