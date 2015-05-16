<?php
namespace Underscore\Types;

use Underscore\Methods\StringMethods;
use Underscore\Traits\Repository;

/**
 * Strings repository.
 *
 * @mixin StringMethods
 */
class Strings extends Repository
{
    /**
     * The method used to convert new subjects.
     *
     * @type string
     */
    protected $typecaster = 'toString';
}
