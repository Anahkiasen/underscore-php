<?php
namespace Underscore;

use \Exception;

abstract class Methods
{
  /**
   * Aliases for methods
   * @var array
   */
  public static $aliases = array();

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // If the method is an alias
    if (isset(static::$aliases[$method])) {
      return call_user_func_array('static::'.static::$aliases[$method], $parameters);
    }

    throw new Exception('The method ' .$method. ' does not exist');
  }
}
