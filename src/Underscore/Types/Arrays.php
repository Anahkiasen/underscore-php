<?php
/**
 * Arrays
 *
 * Arrays repository
 */
namespace Underscore\Types;

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
