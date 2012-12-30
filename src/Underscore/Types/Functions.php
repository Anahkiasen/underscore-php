<?php
namespace Underscore\Types;

use \Underscore\Traits\Type;

class Functions extends Type
{
  /**
   * An array of functions to be called X times
   * @var array
   */
  public static $times = array();

  /**
   * An array of cached function results
   * @var array
   */
  public static $cache = array();

  /**
   * An array tracking the last time a function was called
   * @var array
   */
  public static $throttle = array();

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// LIMITERS ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Create a function that can only be called once
   */
  public static function once($function)
  {
    return static::only($function, 1);
  }

  /**
   * Create a function that can only be called $times times
   */
  public static function only($function, $times)
  {
    $unique = mt_rand();

    // Create a closure that check if the function was already called
    return function() use ($function, $times, $unique) {

      // Generate unique hash of the function
      $arguments = func_get_args();
      $unique = Functions::generateUnique($unique, $function, $arguments);

      // Get counter
      $called = Functions::hasBeenCalledTimes($unique);

      if ($called >= $times) return false;
      else Functions::$times[$unique] += 1;

      return call_user_func_array($function, $arguments);
    };
  }

  /**
   * Create a function that can only be called after $times times
   */
  public static function after($function, $times)
  {
    $unique = mt_rand();

    // Create a closure that check if the function was already called
    return function() use ($function, $times, $unique) {

      // Generate unique hash of the function
      $arguments = func_get_args();
      $unique = Functions::generateUnique($unique, $function, $arguments);

      // Get counter
      $called = Functions::hasBeenCalledTimes($unique);

      // Prevent calling before a certain number
      if ($called < $times) {
        Functions::$times[$unique] += 1;
        return false;
      }

      return call_user_func_array($function, $arguments);
    };
  }

  /**
   * Caches the result of a function and refer to it ever after
   */
  public static function cache($function)
  {
    $unique = mt_rand();

    return function() use ($function, $unique) {

      // Generate unique hash of the function
      $arguments = func_get_args();
      $unique = Functions::generateUnique($unique, $function, $arguments);

      if (isset(Functions::$cache[$unique])) return Functions::$cache[$unique];

      $result = call_user_func_array($function, $arguments);
      Functions::$cache[$unique] = $result;

      return $result;
    };
  }

  /**
   * Only allow a function to be called every X ms
   */
  public static function throttle($function, $ms)
  {
    $unique = mt_rand();

    return function() use ($function, $ms, $unique) {

      // Generate unique hash of the function
      $arguments = func_get_args();
      $unique = Functions::generateUnique($unique, $function, $arguments);

      // Check last called time and update it if necessary
      $last = Functions::getLastCalledTime($unique);
      $difference = time() - $last;

      // Execute the function if the conditions are here
      if ($last == time() or $difference > $ms) {
        Functions::$throttle[$unique] = time();

        return call_user_func_array($function, $arguments);
      }

      return false;
    };
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get the last time a function was called
   *
   * @param string $unique The function unique ID
   * @return integer
   */
  public static function getLastCalledTime($unique)
  {
    // If no entry, create one
    if (!isset(static::$times[$unique])) {
      static::$times[$unique] = time();
    }

    return static::$times[$unique];
  }

  /**
   * Get the number of times a function has been called
   *
   * @param string $unique The function unique ID
   * @return integer
   */
  public static function hasBeenCalledTimes($unique)
  {
    // If no entry, create one
    if (!isset(static::$times[$unique])) {
      static::$times[$unique] = 0;
    }

    return static::$times[$unique];
  }

  /**
   * Generate an unique id for a function
   *
   * @param  Closure $function The function
   * @param  array   $arguments Its arguments
   * @return string  The unique id
   */
  public static function generateUnique($unique, $function, $arguments)
  {
    $function  = var_export($function, true);
    $arguments = var_export($arguments, true);

    return md5($unique. '_' .$function.'_'.$arguments);
  }
}
