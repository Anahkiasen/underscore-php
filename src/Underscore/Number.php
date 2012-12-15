<?php
namespace Underscore;

class Number extends Interfaces\CollectionMethods
{
  /**
   * Add 0 padding to an integer
   */
  public static function pad($number, $padding = 1, $direction = STR_PAD_BOTH)
  {
    return str_pad($number, $padding, 0, $direction);
  }

  /**
   * Add 0 padding on the left of an integer
   */
  public static function padLeft($number, $padding = 1)
  {
    return static::pad($number, $padding, STR_PAD_LEFT);
  }

  /**
   * Add 0 padding on the right of an integer
   */
  public static function padRight($number, $padding = 1)
  {
    return static::pad($number, $padding, STR_PAD_RIGHT);
  }
}