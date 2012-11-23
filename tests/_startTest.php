<?php
abstract class UnderscoreWrapper extends PHPUnit_Framework_TestCase
{
  /**
   * Starts the bundle
   */
  public static function setUpBeforeClass()
  {
    Bundle::start('underscore');
  }
}
