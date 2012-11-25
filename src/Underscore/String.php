<?php
/**
 * String
 *
 * Helpers and functions for strings
 */
namespace Underscore;

class String extends Interfaces\StringMethods
{

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// ANALYZE /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Whether a string starts with another string
   */
  public static function startsWith($string, $with)
  {
    return strpos($string, $with) === 0;
  }

  /**
   * Whether a string ends with another string
   */
  public static function endsWith($string, $with)
  {
    return $with == substr($string, strlen($string) - strlen($with));
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// FETCH FROM ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Find one or more needles in one or more haystacks
   *
   * @param  mixed   $string        The haystack(s) to search in
   * @param  mixed   $needle        The needle(s) to search for
   * @param  boolean $caseSensitive Whether the function is case sensitive or not
   * @param  boolean $absolute      Whether all needle need to be found or whether one is enough
   * @return boolean Found or not
   */
  public static function find($string, $needle, $caseSensitive = false, $absolute = false)
  {
    // If several needles
    if (is_array($needle) or is_array($string)) {

      if (is_array($needle)) {
        $from = $needle;
        $to   = $string;
      } else {
        $from = $string;
        $to   = $needle;
      }

      $found = 0;
      foreach($from as $need) {
        if(static::find($to, $need, $absolute, $caseSensitive)) $found++;
      }

      return ($absolute) ? count($from) == $found : $found > 0;
    }

    // If not case sensitive
    if (!$caseSensitive) {
      $string = strtolower($string);
      $needle   = strtolower($needle);
    }

    // If string found
    $pos = strpos($string, $needle);

    return !($pos === false);
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// ALTER //////////////////////////////
  ////////////////////////////////////////////////////////////////////

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

  /**
   * Slugifies a string
   */
  public static function slugify($string, $separator = '-')
  {
    $string = preg_replace('/[\.&=_]/', ' ', $string);

    return static::slug($string, $separator);
  }
}
