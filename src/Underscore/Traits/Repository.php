<?php
/**
 * Repository
 *
 * Base abstract class for repositories
 */
namespace Underscore\Traits;

use \Underscore\Methods\ArraysMethods;
use \Underscore\Methods\StringMethods;
use \BadMethodCallException;
use \Underscore\Types\Arrays;
use \Underscore\Dispatch;
use \Underscore\Underscore;
use \Underscore\Method;

abstract class Repository
{
  /**
   * The subject of the repository
   * @var mixed
   */
  protected $subject;

  /**
   * Custom functions
   * @var array
   */
  public static $macros = array();

  ////////////////////////////////////////////////////////////////////
  /////////////////////////// PUBLIC METHODS /////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Create a new instance of the repository
   *
   * @param mixed $subject The repository subject
   */
  public function __construct($subject = null)
  {
    $this->subject  = $subject ?: $this->getDefault();

    return $this;
  }

  /**
   * Create a new Arrays instance
   */
  public static function create()
  {
    return new static();
  }

  /**
   * Alias for Underscore::chain
   */
  public static function from($subject)
  {
    return new static($subject);
  }

  /**
   * Get a key from the subject
   */
  public function __get($key)
  {
    return ArraysMethods::get($this->subject, $key);
  }

  /**
   * Set a value on the subject
   */
  public function __set($key, $value)
  {
    $this->subject = ArraysMethods::set($this->subject, $key, $value);
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

  /**
   * Extend the class with a custom function
   */
  public static function extend($method, $closure)
  {
    static::$macros[$method] = $closure;
  }

  ////////////////////////////////////////////////////////////////////
  //////////////////////// METHODS DISPATCHING ///////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Catch aliases and reroute them to the right methods
   */
  public static function __callStatic($method, $parameters)
  {
    // Get base class and methods class
    $callingClass = get_called_class();
    if (!StringMethods::find($callingClass, 'Underscore\Types')) {
      $callingClass = Method::findInClasses($method);
    }
    $methodsClass = Method::getMethodsFromType($callingClass);

    // Get alias from config
    $alias = Method::getAliasOf($method);
    if ($alias) $method = $alias;

    // Defer to Methods class
    if (method_exists($methodsClass, $method)) {
      return Repository::callMethod($methodsClass, $method, $parameters);
    }

    // Check for parsers
    if (method_exists('\Underscore\Parse', $method)) {
      return Repository::callMethod('\Underscore\Parse', $method, $parameters);
    }

    // Defered methods
    $defered = Dispatch::toNative($callingClass, $method);
    if ($defered) {
      return call_user_func_array($defered, $parameters);
    }

    // Look in the macros
    $macro = ArraysMethods::get(static::$macros, $method);
    if ($macro) {
      return call_user_func_array($macro, $parameters);
    }

    throw new BadMethodCallException('The method ' .$callingClass. '::' .$method. ' does not exist');
  }

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
    $result = static::__callStatic($method, $arguments);

    // If the method is a breaker, return just the result
    if (Method::isBreaker($method)) return $result;
    else $this->subject = $result;

    return $this;
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// HELPERS //////////////////////////////
  ////////////////////////////////////////////////////////////////////

  private static function callMethod($class, $method, $parameters)
  {
    switch (sizeof($parameters)) {
      case 0;
        return $class::$method();
      case 1:
        return $class::$method($parameters[0]);
      case 2:
        return $class::$method($parameters[0], $parameters[1]);
      case 3:
        return $class::$method($parameters[0], $parameters[1], $parameters[2]);
      case 4:
        return $class::$method($parameters[0], $parameters[1], $parameters[2], $parameters[3]);
      case 5:
        return $class::$method($parameters[0], $parameters[1], $parameters[2], $parameters[3], $parameters[4]);
    }
  }

  /**
   * Get a default value for a new repository
   *
   * @return mixed
   */
  protected function getDefault()
  {
    return '';
  }
}
