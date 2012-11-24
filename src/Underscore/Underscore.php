<?php
/**
 * Underscore
 *
 * The base class and wrapper around all other classes
 */
namespace Underscore;

use \Exception;

class Underscore extends Interfaces\Methods
{
  /**
   * The subject of methods
   * @var mixed
   */
  private $subject;

  /**
   * A list of methods that are allowed
   * to break the chain
   * @var array
   */
  private static $breakers = array(
    'get',
  );

  /**
   * Unchainable methods
   * @var array
   */
  private static $unchainable = array(
    'Arraysrange', 'Arraysrepeat',
  );

  /**
   * Build a chainable object
   *
   * @param mixed $subject The methods subject
   */
  public function __construct($subject)
  {
    $this->subject = $subject;

    return $this;
  }

  /**
   * Alias for new Underscore
   */
  public static function chain($subject)
  {
    return new Underscore($subject);
  }

  /**
   * Allow the chained calling of methods
   */
  public function __call($method, $arguments)
  {
    // Get correct class
    $class = static::typeFrom($this->subject);

    // Check for unchainable methods
    if (in_array($class.$method, static::$unchainable)) {
      throw new Exception('The method '.$class.'::'.$method. ' can\'t be chained');
    }

    // Prepend subject to arguments and call the method
    array_unshift($arguments, $this->subject);
    $this->subject = call_user_func_array('\Underscore\\'.$class.'::'.$method, $arguments);

    return in_array($method, static::$breakers) ? $this->subject : $this;
  }

  /**
   * Allow the static calling of methods
   */
  public static function __callStatic($method, $parameters)
  {
    $subject = Arrays::get($parameters, 0);
    $class = static::typeFrom($subject);

    return call_user_func_array('\Underscore\\'.$class.'::'.$method, $parameters);
  }

  /**
   * Get the subject from the object
   *
   * @return mixed
   */
  public function obtain()
  {
    return $this->subject;
  }

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
    $config = include __DIR__.'/../../config/underscore.php';

    return Arrays::get($config, $option);
  }

  /**
   * Compute the right class to call according to something's type
   */
  public static function typeFrom($subject)
  {
    switch (gettype($subject)) {
      case 'string':
        return 'String';

      case 'array':
        return 'Arrays';

      case 'object':
      case 'resource':
        return 'Object';
    }
  }
}
