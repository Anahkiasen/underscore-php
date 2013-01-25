<?php
/**
 * Number
 *
 * Number repository
 */
namespace Underscore\Types;

use \Underscore\Traits\Repository;

class Number extends Repository
{
  /**
   * The method used to convert new subjects
   * @var string
   */
  protected $typecaster = 'toInteger';

  /**
   * Get a default value for a new repository
   *
   * @return mixed
   */
  protected function getDefault()
  {
    return array();
  }
}
