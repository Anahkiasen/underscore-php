<?php
/**
 * Underscore
 *
 * The base class and wrapper around all other classes
 */
namespace Underscore;

use Underscore\Traits\Repository;
use Underscore\Methods\ArraysMethods;

class Underscore extends Repository
{

  /**
   * The current config
   * @var array
   */
  private static $options;

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// HELPERS //////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get an option from the config file
   *
   * @param string $option The key of the option
   * @return mixed Its value
   */
  public static function option($option)
  {
    // Get config file
    if (!static::$options) {
      static::$options = include __DIR__.'/../../config/config.php';
    }

    return ArraysMethods::get(static::$options, $option);
  }

}
