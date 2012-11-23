<?php
abstract class UnderscoreWrapper extends PHPUnit_Framework_TestCase
{
  public $array = array('foo' => 'bar', 'bis' => 'ter');
  public $arrayNumbers = array(1, 2, 3);

  /**
   * Starts the bundle
   */
  public static function setUpBeforeClass()
  {
    Bundle::start('underscore');
  }
}
