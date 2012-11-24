<?php
/**
 * Arrays
 *
 * Helpers and functions for arrays
 */
namespace Underscore;

use \Closure;

class Arrays extends Interfaces\Methods
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
    $array = (array) static::each($array, $closure);

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
    $array = (array) static::each($array, $closure);

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

   /**
   * Returns the average value of an array
   *
   * @param  array   $array    The source array
   * @param  integer $decimals The number of decimals to return
   * @return integer           The average value
   */
  public static function average($array, $decimals = 0)
  {
    return round((array_sum($array) / sizeof($array)), $decimals);
  }

  /**
   * Get the sum of an array
   */
  public static function sum($array)
  {
    return array_sum($array);
  }

  /**
   * Get the size of an array
   */
  public static function size($array)
  {
    return sizeof($array);
  }

  /**
   * Get the max value from an array
   */
  public static function max($array, $closure = null)
  {
    // If we have a closure, apply it to the array
    if ($closure) $array = Arrays::each($array, $closure);

    // Sort from max to min
    arsort($array);

    return Arrays::first($array);
  }

  /**
   * Get the min value from an array
   */
  public static function min($array, $closure = null)
  {
    // If we have a closure, apply it to the array
    if ($closure) $array = Arrays::each($array, $closure);

    // Sort from max to min
    asort($array);

    return Arrays::first($array);
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
   * Fetches all columns $property from a multimensionnal array
   */
  public static function pluck($array, $property)
  {
    foreach ($array as $key => $value) {
      $array[$key] = Arrays::get($value, $property, $value);
    }

    return $array;
  }

  /**
   * Get the first value from an array
   */
  public static function first($array, $take = null)
  {
    if (!$take) return array_shift($array);
    return array_splice($array, 0, $take, true);
  }

  /**
   * Get the last value from an array
   */
  public static function last($array)
  {
    return array_pop($array);
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// ACT UPON /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Iterate over an array and execute a callback for each loop
   */
  public static function at($array, Closure $closure)
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
  public static function each($array, Closure $closure)
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
