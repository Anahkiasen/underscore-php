<?php
namespace Underscore;

class Object extends Interfaces\Methods
{
  /**
   * Get all keys from an object
   */
  public static function keys($object)
  {
    return array_keys((array) $object);
  }

  /**
   * Get all values from an object
   */
  public static function values($object)
  {
    return array_values((array) $object);
  }

  /**
   * Get all methods from an object
   */
  public static function methods($object)
  {
    return get_class_methods(get_class($object));
  }
}
