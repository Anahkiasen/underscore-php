<?php
/**
 * Methods
 *
 * Base abstract class for helpers
 */
namespace Underscore\Interfaces;

use \Config;
use \Exception;
use \Underscore\Arrays;
use \Underscore\Underscore;

abstract class Methods
{
  /**
   * Custom functions
   * @var array
   */
  public static $macros = array();

  /**
   * A list of methods to automatically defer to PHP
   * @var array
   */
  public static $defer = array(
  );

  /**
   * Alias for Underscore::chain
   */
  public static function from($subject)
  {
    return new Underscore($subject);
  }

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // Defered methods
    $defered = static::getDefered($method);
    if ($defered) {
      return call_user_func_array($defered, $parameters);
    }

    // Look in the macros
    $macro = Arrays::get(static::$macros, $method);
    if ($macro) {
      return call_user_func_array($macro, $parameters);
    }

    // Get alias from config
    $alias = Underscore::option('aliases.'.$method);
    if ($alias) {
      return call_user_func_array('static::'.$alias, $parameters);
    }

    throw new Exception('The method ' .get_called_class(). '::' .$method. ' does not exist');
  }

  /**
   * Extend the class with a custom function
   */
  public static function extend($method, $closure)
  {
    static::$macros[$method] = $closure;
  }

  // Helpers ------------------------------------------------------- /

  /**
   * Get the correct name of a defered method
   *
   * @param string $method The original method
   * @return string The defered method, or false if none found
   */
  private static function getDefered($method)
  {
    // Native function
    if (function_exists('array_'.$method)) return 'array_'.$method;

    // Aliased native function
    if (isset(static::$defer[$method])) return static::$defer[$method];

    return false;
  }
}
