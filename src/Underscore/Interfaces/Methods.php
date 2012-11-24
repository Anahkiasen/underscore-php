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
    'trim' => 'trim',
  );

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
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////


  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // Defered methods
    $defered = static::getDefered(get_called_class(), $method);
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
   * Get the correct name of a defered method
   *
   * @param string $method The original method
   * @return string The defered method, or false if none found
   */
  public static function getDefered($class, $method)
  {
    // Aliased native function
    if (isset(static::$defer[$method])) return static::$defer[$method];

    // Transform class to php function prefix
    switch($class) {
      case 'Underscore\Arrays':
        $prefix = 'array_';
        break;
      case 'Underscore\String':
        $prefix = 'str_';
        break;
    }

    // If no function prefix found, return false
    if (!isset($prefix)) return false;

    // Native function
    $function = $prefix.$method;
    if (function_exists($function)) return $function;

    return false;
  }
}
