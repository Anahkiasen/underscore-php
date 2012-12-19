<?php
/**
 * Methods
 *
 * Base abstract class for helpers
 */
namespace Underscore\Traits;

use \Config;
use \BadMethodCallException;
use \Underscore\Types\Arrays;
use \Underscore\Dispatch;
use \Underscore\Underscore;
use \Underscore\Methods;

abstract class Type
{
  /**
   * Custom functions
   * @var array
   */
  public static $macros = array();

  ////////////////////////////////////////////////////////////////////
  /////////////////////////// PUBLIC METHODS /////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Alias for Underscore::chain
   */
  public static function from($subject)
  {
    return new Underscore($subject);
  }

  /**
   * Extend the class with a custom function
   */
  public static function extend($method, $closure)
  {
    static::$macros[$method] = $closure;
  }

  ////////////////////////////////////////////////////////////////////
  //////////////////////////// CORE METHODS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // Check for parsers
    if (method_exists('\Underscore\Parse', $method)) {
      return call_user_func_array('\Underscore\Parse::'.$method, $parameters);
    }

    // Defered methods
    $defered = Dispatch::toNative(get_called_class(), $method);
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
      return call_user_func_array('\Underscore\Underscore::'.$alias, $parameters);
    }

    throw new BadMethodCallException('The method ' .get_called_class(). '::' .$method. ' does not exist');
  }
}
