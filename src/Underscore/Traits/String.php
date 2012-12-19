<?php
/**
 * String
 *
 * Provides access to Laravel's Str methods
 */
namespace Underscore\Traits;

use \Laravel\Str;
use \Underscore\Dispatch;
use \Underscore\Underscore;
use \Underscore\Traits\Type;

abstract class String extends Str
{

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
    Type::$macros[$method] = $closure;
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

    return Type::__callStatic($method, $parameters);
  }
}
