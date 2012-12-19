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
    'trim', 'count', 'round', 'ceil', 'floor',
    'str_pad' => 'pad',
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

  /**
   * Get the native function corresponding to a method
   *
   * @param string $method The method to look for
   * @return string The native function
   */
  public static function getNative($method)
  {
    // If a defered method exist
    if (in_array($method, static::$defer)) {
      $native = array_search($method, static::$defer);

      return is_int($native) ? $method : $native;
    }

    return false;
  }
}