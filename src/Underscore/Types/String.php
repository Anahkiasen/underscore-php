<?php
/**
 * String
 *
 * String repository
 */
namespace Underscore\Types;

use \Underscore\Traits\Repository;

class String extends Repository
{
  /**
   * The method used to convert new subjects
   * @var string
   */
  protected $typecaster = 'toString';

}
