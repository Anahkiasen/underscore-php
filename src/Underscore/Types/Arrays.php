<?php
/**
 * Arrays
 *
 * Helpers and functions for arrays
 */
namespace Underscore\Types;

use \Closure;
use \Underscore\Traits\Repository;

class Arrays extends Repository
{
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
