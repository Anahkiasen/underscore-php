<?php
/**
 * CollectionMethods
 *
 * Common methods for arrays, objects and such
 */
namespace Underscore\Interfaces;

use \Closure;

abstract class CollectionMethods extends Methods
{

  ////////////////////////////////////////////////////////////////////
  //////////////////////////// FETCH FROM ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a value from an collection using dot-notation
   *
   * @param array  $collection The collection to get from
   * @param string $key        The key to look for
   * @param mixed  $default    Default value to fallback to
   *
   * @return mixed
   */
  public static function get($collection, $key, $default = null)
  {
    if (is_null($key)) return $collection;

    // Crawl through collection, get key according to object or not
    foreach (explode('.', $key) as $segment) {

      // If object
      if (is_object($collection)) {
        if (!isset($collection->$segment)) return is_callable($default) ? $default() : $default;
        else $collection = $collection->$segment;

      // If array
      } else {
        if (!isset($collection[$segment])) return is_callable($default) ? $default() : $default;
        else $collection = $collection[$segment];
      }
    }

    return $collection;
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// ANALYZE //////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get all keys from a collection
   */
  public static function keys($collection)
  {
    return array_keys((array) $collection);
  }

  /**
   * Get all values from a collection
   */
  public static function values($collection)
  {
    return array_values((array) $collection);
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// ALTER ///////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Convert a collection to JSON
   */
  public static function toJSON($collection)
  {
    return json_encode((array) $collection);
  }
}
