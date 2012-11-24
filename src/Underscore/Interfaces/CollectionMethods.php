<?php
/**
 * CollectionMethods
 *
 * Common methods for arrays, objects and such
 */
namespace Underscore\Interfaces;

use \Closure;
use \Underscore\Arrays;

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

  /**
   * Sort values from a collection according to the results of a closure
   * A property name to sort by can also be passed
   * Also the sorter can be null and the array will be sorted naturally
   */
  public static function sort($collection, $sorter = null, $direction = 'asc')
  {
    $collection = (array) $collection;

    // Get correct PHP constant for direction
    $direction = (strtolower($direction) == 'desc') ? SORT_DESC : SORT_ASC;

    // Transform all values into their results
    if ($sorter) {
      foreach ($collection as $key => $value) {
        $results[$key] = is_callable($sorter) ? $sorter($value) : Arrays::get($value, $sorter);
      }
    } else $results = $collection;

    // Sort by the results and replace by original values
    array_multisort($results, $direction, SORT_REGULAR, $collection);

    return $collection;
  }

  /**
   * Group values from a collection according to the results of a closure
   */
  public static function group($collection, $grouper)
  {
    $collection = (array) $collection;

    // Iterate over values, group by property/results from closure
    foreach($collection as $key => $value) {
      $key = is_callable($grouper) ? $grouper($value, $key) : Arrays::get($value, $grouper);
      if (!isset($result[$key])) $result[$key] = array();

      // Add to results
      $result[$key][] = $value;
    }

    return $result;
  }
}
