<?php
/**
 * StringMethods
 *
 * Provides access to Laravel's Str methods
 */
namespace Underscore\Interfaces;

use \Laravel\Str;
use \Underscore\Underscore;

abstract class StringMethods extends Str
{
  /**
   * Custom functions
   * @var array
   */
  public static $macros = array();

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
    $defered = Methods::getDefered(get_called_class(), $method);
    if ($defered) {
      return call_user_func_array($defered, $parameters);
    }

    return Methods::__callStatic($method, $parameters);
  }

  /**
   * Extend the class with a custom function
   */
  public static function extend($method, $closure)
  {
    static::$macros[$method] = $closure;
  }
}
