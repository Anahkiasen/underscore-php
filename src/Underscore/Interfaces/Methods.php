<?php
/**
 * Methods
 *
 * Base abstract class for helpers
 */
namespace Underscore\Interfaces;

use \Config;
use \BadMethodCallException;
use \Underscore\Arrays;
use \Underscore\Dispatch;
use \Underscore\Underscore;

abstract class Methods
{
  /**
   * A list of methods to automatically defer to PHP
   * @var array
   */
  public static $defer = array(
    'trim' => 'trim',
  );

  /**
   * Custom functions
   * @var array
   */
  public static $macros = array();

  /**
   * A list of methods that are allowed
   * to break the chain
   * @var array
   */
  private static $breakers = array(
    'get',
  );

  /**
   * Unchainable methods
   * @var array
   */
  private static $unchainable = array(
    '\Underscore\Arrays::range', '\Underscore\Arrays::repeat',
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
  //////////////////////////// CORE METHODS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
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
      return call_user_func_array('static::'.$alias, $parameters);
    }

    throw new BadMethodCallException('The method ' .get_called_class(). '::' .$method. ' does not exist');
  }

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
