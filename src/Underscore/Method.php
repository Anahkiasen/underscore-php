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

  /**
   * A cache for better findInClasses performances
   * @var array
   */
  private static $findCache = array();

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  public static function getMethodsFromType($array)
  {
    return str_replace('Types', 'Methods', $array.'Methods');
  }

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
   * Get a method name by its alias
   *
   * @param  string $method The method
   * @return string The real method name
   */
  public static function getAliasOf($method)
  {
    return Underscore::option('aliases.'.$method);
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

  /**
   * Find a method in the type classes
   *
   * @param string $method The method
   * @return string The class name
   */
  public static function findInClasses($originalClass, $method)
  {
    $classes = array('Arrays', 'Collection', 'Functions', 'Number', 'Object', 'String');
    foreach ($classes as $class) {
      if (method_exists('\Underscore\Methods\\'.$class.'Methods', $method)) {
        return '\Underscore\Types\\'.$class;
      }
    }

    return $originalClass;
  }
}
