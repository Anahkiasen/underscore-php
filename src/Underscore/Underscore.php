<?php
/**
 * Underscore
 *
 * The base class and wrapper around all other classes
 */
namespace Underscore;

use \BadMethodCallException;
use \Underscore\Traits\Type;
use \Underscore\Types\Arrays;

class Underscore extends Type
{
  /**
   * The subject of methods
   * @var mixed
   */
  private $subject;

  /**
   * The current config
   * @var array
   */
  private static $options;

  ////////////////////////////////////////////////////////////////////
  /////////////////////////// PUBLIC METHODS /////////////////////////
  ////////////////////////////////////////////////////////////////////

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
   * Static alias for constructor
   */
  public static function chain($subject)
  {
    return new Underscore($subject);
  }

  /**
   * Get a key from the subject
   */
  public function __get($key)
  {
    return Arrays::get($this->subject, $key);
  }

  /**
   * Set a value on the subject
   */
  public function __set($key, $value)
  {
    $this->subject = Arrays::set($this->subject, $key, $value);
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
  //////////////////////////// CORE METHODS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Allow the chained calling of methods
   */
  public function __call($method, $arguments)
  {
    // Get correct class
    $class = Dispatch::toClass($this->subject);

    // Check for unchainable methods
    if (Method::isUnchainable($class, $method)) {
      throw new BadMethodCallException('The method '.$class.'::'.$method. ' can\'t be chained');
    }

    // Prepend subject to arguments and call the method
    array_unshift($arguments, $this->subject);
    $result = call_user_func_array($class.'::'.$method, $arguments);

    // If the method is a breaker, return just the result
    if (Method::isBreaker($method)) return $result;
    else $this->subject = $result;

    return $this;
  }

  /**
   * Allow the static calling of methods
   */
  public static function __callStatic($method, $parameters)
  {
    $subject = Arrays::get($parameters, 0);
    $class   = Dispatch::toClass($subject);

    return call_user_func_array($class.'::'.$method, $parameters);
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
    if (!static::$options) {
      static::$options = include __DIR__.'/../../config/underscore.php';
    }

    return Arrays::get(static::$options, $option);
  }
}
