<?php
/**
 * String
 *
 * Helpers and functions for strings
 */
namespace Underscore;

class String extends Interfaces\StringMethods
{
  /**
   * Remove part of a string
   */
  public static function remove($string, $remove)
  {
    // If we only have one string to remove
    if(!is_array($remove)) $string = str_replace($remove, null, $string);

    // Else, use Regex
    else $string =  preg_replace('#(' .implode('|', $remove). ')#', null, $string);

    // Trim and return
    return trim($string);
  }

  /**
   * Toggles a string between two states
   *
   * @param  string  $string The string to toggle
   * @param  string  $first  First value
   * @param  string  $second Second value
   * @param  boolean $loose  Whether a string neither matching 1 or 2 should be changed
   * @return string          The toggled string
   */
  public static function toggle($string, $first, $second, $loose = false)
  {
    // If the string given match none of the other two, and we're in strict mode, return it
    if (!$loose and !in_array($string, array($first, $second))) {
      return $string;
    }

    return $string == $first ? $second : $first;
  }
}
