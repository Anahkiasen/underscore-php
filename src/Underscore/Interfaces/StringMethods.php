<?php
/**
 * StringMethods
 *
 * Provides access to Laravel's Str methods
 */
namespace Underscore\Interfaces;

use \Str;

abstract class StringMethods extends Str
{
  /**
   * Alias for Underscore::chain
   */
  public static function from($subject)
  {
    return new Underscore($subject);
  }

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // Get alias from config
    $alias = Config::get('underscore::underscore.aliases.'.$method);
    if ($alias) {
      return call_user_func_array('static::'.$alias, $parameters);
    }

    throw new Exception('The method ' .get_called_class(). '::' .$method. ' does not exist');
  }
}
