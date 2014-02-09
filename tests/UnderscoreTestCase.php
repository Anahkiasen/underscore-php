<?php
namespace Underscore;

use PHPUnit_Framework_TestCase;

abstract class UnderscoreTestCase extends PHPUnit_Framework_TestCase
{
  public $array = array('foo' => 'bar', 'bis' => 'ter');
  public $arrayNumbers = array(1, 2, 3);
  public $arrayMulti = array(
    array('foo' => 'bar', 'bis' => 'ter'),
    array('foo' => 'bar', 'bis' => 'ter'),
    array('bar' => 'foo', 'bis' => 'ter'),
  );
  public $object;

  /**
   * Restore data just in case
   */
  public function setUp()
  {
    $this->object = (object) $this->array;
    $this->objectMulti = (object) array(
      (object) $this->arrayMulti[0],
      (object) $this->arrayMulti[1],
      (object) $this->arrayMulti[2],
    );
  }
}
