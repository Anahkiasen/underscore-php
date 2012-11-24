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
}
