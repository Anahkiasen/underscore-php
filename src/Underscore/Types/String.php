<?php
namespace Underscore\Types;

use Underscore\Methods\StringMethods;
use Underscore\Traits\Repository;

/**
 * String repository
 * @mixin StringMethods
 */
class String extends Repository
{

  /**
   * The method used to convert new subjects
   * @var string
   */
  protected $typecaster = 'toString';

}
