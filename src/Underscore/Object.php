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
   * Unpack an object's properties
   */
  public static function unpack($object, $attribute = null)
  {
    $object = (array) $object;
    $object = $attribute
      ? Arrays::get($object, $attribute)
      : Arrays::first($object);

    return (object) $object;
  }

  /**
   * Converts an object to an array
   */
  public static function toArray($object)
  {
    return (array) $object;
  }
}
