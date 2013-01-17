<?php
/**
 * Dispatch
 *
 * Dispatches methods and classes to various places
 */
namespace Underscore;

use \InvalidArgumentException;
use \Underscore\Interfaces\Methods;

class Dispatch
{
  const TYPES = 'Underscore\Types\\';

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

      case 'integer':
      case 'float':
      case 'double':
      case 'real':
        $class = 'Number';
        break;

      case 'object':
      case 'resource':
        $class = 'Object';
        break;

      case 'NULL':
        $subject = '';
        $class = 'String';
        break;
    }

    // Return false for unsupported types
    if (!isset($class)) {
      throw new InvalidArgumentException('The type ' .gettype($subject). ' is not supported');
    }

    return '\\'.static::TYPES.$class;
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
    $native = Method::getNative($method);
    if ($native) return $native;

    // Transform class to php function prefix
    switch ($class) {
      case static::TYPES.'Arrays':
        $prefix = 'array_';
        break;

      case static::TYPES.'String':
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
