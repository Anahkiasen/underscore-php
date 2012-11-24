<?php
namespace Underscore;

class Object extends Interfaces\CollectionMethods
{
  /**
   * Get all methods from an object
   */
  public static function methods($object)
  {
    return get_class_methods(get_class($object));
  }

  /**
   * Converts an object to an array
   */
  public static function toArray($object)
  {
    return (array) $object;
  }
}
