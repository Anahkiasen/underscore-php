<?php
namespace Underscore;

use \Closure;

class Arrays extends Methods
{

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// ANALYZE //////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Check if all items in an array match a truth test
   */
  public static function matches($array, Closure $closure)
  {
    // Reduce the array to only booleans
    $array = (array) static::map($array, $closure);

    // Check the results
    if (sizeof($array) === 0) return true;
    $array = array_search(false, $array, false);

    return is_bool($array);
  }

  /**
   * Check if any item in an array matches a truth test
   */
  public static function matchesAny($array, Closure $closure)
  {
    // Reduce the array to only booleans
    $array = (array) static::map($array, $closure);

    // Check the results
    if (sizeof($array) === 0) return true;
    $array = array_search(true, $array, false);

    return is_int($array);
  }

  /**
   * Check if an item is in an array
   */
  public static function contains($array, $value)
  {
    return in_array($value, $array);
  }

  ////////////////////////////////////////////////////////////////////
  //////////////////////////// FETCH FROM ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a value from an array using dot-notation
   *
   * @param array  $array The array to get from
   * @param string $key        The key to look for
   * @param mixed  $default    Default value to fallback to
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
   * Find the first item in an array that passes the truth test
   */
  public static function find($array, Closure $closure)
  {
    foreach ($array as $value) {
      if ($closure($value)) return $value;
    }

    return $array;
  }

  /**
   * Get the size of an array
   */
  public static function size($array)
  {
    return sizeof($array);
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// ACT UPON /////////////////////////////
  ////////////////////////////////////////////////////////////////////

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

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// ALTER ///////////////////////////////
  ////////////////////////////////////////////////////////////////////

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

  /**
   * Find all items in an array that pass the truth test
   */
  public static function filter($array, Closure $closure)
  {
    return array_filter($array, $closure);
  }

  /**
   * Invoke a function on all of an array's values
   */
  public static function invoke($array, $callable, $arguments = array())
  {
    // If the callable has arguments, pass them
    if ($arguments) return array_map($callable, $array, $callable);

    return array_map($callable, $array);
  }

  /**
   * Return all items that fail the truth test
   */
  public static function reject($array, Closure $closure)
  {
    foreach ($array as $key => $value) {
      if (!$closure($value)) $filtered[$key] = $value;
    }

    return $filtered;
  }
}
