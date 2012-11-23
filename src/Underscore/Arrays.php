<?php
namespace Underscore;

use \Closure;

class Arrays
{
  /**
   * Get a value from an array using dot-notation
   *
   * @param array  $array   The array to get from
   * @param string $key     The key to look for
   * @param mixed  $default Default value to fallback to
   *
   * @return mixed
   */
  public static function get($array, $key, $default = null)
  {
    if (is_null($key)) return $array;

    foreach (explode('.', $key) as $segment) {
      if (
        !is_array($array) or
        !array_key_exists($segment, $array)) {
          return is_callable($default) ? $default() : $default;
      }

      $array = $array[$segment];
    }

    return $array;
  }

  /**
   * Iterate over an array and execute a callback for each loop
   */
  public static function each($array, Closure $closure)
  {
    foreach ($array as $key => $value) {
      $closure($value, $key);
    }

    return $array;
  }

  /**
   * Iterate over an array and modify the array's value
   */
  public static function map($array, Closure $closure)
  {
    foreach ($array as $key => $value) {
      $array[$key] = $closure($value, $key);
    }

    return $array;
  }
}
