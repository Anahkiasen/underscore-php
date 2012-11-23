<?php
namespace Underscore;

use \Closure;

class Collection
{

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// FETCH FROM //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a value from a collection using dot-notation
   *
   * @param collection $collection The collection to get from
   * @param string     $key        The key to look for
   * @param mixed      $default    Default value to fallback to
   *
   * @return mixed
   */
  public static function get($collection, $key, $default = null)
  {
    if (is_null($key)) return $collection;

    foreach (explode('.', $key) as $segment) {
      if (
        !is_array($collection) or
        !array_key_exists($segment, $collection)) {
          return is_callable($default) ? $default() : $default;
      }

      $collection = $collection[$segment];
    }

    return $collection;
  }

  /**
   * Find the first item in a collection that passes the truth test provided
   */
  public static function find($collection, Closure $closure)
  {
    foreach ($collection as $value) {
      if ($closure($value)) return $value;
    }

    return $collection;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// ACT UPON ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Iterate over a collection and execute a callback for each loop
   */
  public static function each($collection, Closure $closure)
  {
    foreach ($collection as $key => $value) {
      $closure($value, $key);
    }

    return $collection;
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////////// ALTER ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Iterate over a collection and modify the collection's value
   */
  public static function map($collection, Closure $closure)
  {
    foreach ($collection as $key => $value) {
      $collection[$key] = $closure($value, $key);
    }

    return $collection;
  }
}
