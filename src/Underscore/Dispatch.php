<?php
namespace Underscore;

use \Underscore\Interfaces\Methods;

class Dispatch
{
  /**
   * Compute the right class to call according to something's type
   *
   * @param mixed   $subjet The subject of a class
   * @return string Its fully qualified corresponding class
   */
  public static function toClass($subject)
  {
    switch (gettype($subject)) {
      case 'string':
        $class = 'String';
        break;

      case 'array':
        $class = 'Arrays';
        break;

      case 'object':
      case 'resource':
        $class = 'Object';
        break;
    }

    return '\\'.__NAMESPACE__.'\\'.$class;
  }

  /**
   * Defer a method to native PHP
   *
   * @param string $class  The class
   * @param string $method The method
   *
   * @return string The correct function to call
   */
  public static function toNative($class, $method)
  {
    // Aliased native function
    if (isset(Methods::$defer[$method])) return Methods::$defer[$method];

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
