<?php
/**
 * Object
 *
 * Object repository
 */
namespace Underscore\Types;

use \stdClass;
use \Underscore\Traits\Repository;

class Object extends Repository
{
  /**
   * Get a default value for a new repository
   *
   * @return mixed
   */
  protected function getDefault()
  {
    return new stdClass;
  }
}
