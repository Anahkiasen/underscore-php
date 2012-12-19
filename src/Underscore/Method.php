<?php
/**
 * Method
 *
 * Various helpers relatives to methods
 */
namespace Underscore;

class Method
{
  /**
   * A list of methods to automatically defer to PHP
   * @var array
   */
  public static $defer = array(
    'trim'  => 'trim',
    'count' => 'count',
  );

  /**
   * A list of methods that are allowed
   * to break the chain
   * @var array
   */
  private static $breakers = array(
    'get', 'sum', 'count',
    'fromJSON', 'toJSON',
    'fromXML',
    'fromCSV', 'toCSV',
  );

  /**
   * Unchainable methods
   * @var array
   */
  private static $unchainable = array(
    '\Underscore\Types\Arrays::range', '\Underscore\Types\Arrays::repeat',
  );

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Whether a method should not be chained
   *
   * @param string $class  The class
   * @param string $method The method
   *
   * @return boolean
   */
  public static function isUnchainable($class, $method)
  {
    return in_array($class.'::'.$method, static::$unchainable);
  }

  /**
   * Whether a method is a breaker
   *
   * @param string $method The method
   * @return boolean
   */
  public static function isBreaker($method)
  {
    return in_array($method, static::$breakers);
  }
}