<?php
namespace Underscore\Dummies;

use Underscore\Types\String;

class DummyDefault extends String
{
	/**
	 * Get the default value
	 *
	 * @return string
	 */
  public function getDefault()
  {
    return 'foobar';
  }

  /**
   * How the repository is to be cast to array
   *
   * @return array
   */
  public function toArray()
  {
    return array('foo', 'bar');
  }
}
