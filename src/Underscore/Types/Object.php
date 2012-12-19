<?php
namespace Underscore\Types;

use \stdClass;
use \Underscore\Traits\Collection;

class Object extends Collection
{
  /**
   * Create a new Object instance
   */
  public static function create()
  {
    return static::from(new stdClass);
  }

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
}
