<?php
abstract class UnderscoreWrapper extends PHPUnit_Framework_TestCase
{
  public $array = array('foo' => 'bar', 'bis' => 'ter');
  public $arrayNumbers = array(1, 2, 3);
  public $arrayMulti = array(
    array('foo' => 'bar', 'bis' => 'ter'),
    array('foo' => 'bar', 'bis' => 'ter'),
    array('bar' => 'foo', 'bis' => 'ter'),
  );

  /**
   * Starts the bundle
   */
  public static function setUpBeforeClass()
  {
    Bundle::start('underscore');
  }
}
