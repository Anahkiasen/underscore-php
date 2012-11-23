<?php
namespace Underscore;

use \Config;
use \Exception;

abstract class Methods
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
