<?php
/**
 * CollectionMethods
 *
 * Common methods for arrays, objects and such
 */
namespace Underscore\Interfaces;

abstract class CollectionMethods extends Methods
{
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
}
