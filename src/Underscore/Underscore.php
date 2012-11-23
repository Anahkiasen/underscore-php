<?php
namespace Underscore;

class Underscore extends Methods
{
  /**
   * The subject of methods
   * @var mixed
   */
  private $subject;

  /**
   * A list of methods that are allowed
   * to break the chaind
   * @var array
   */
  private static $breakers = array(
    'get',
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
   * Compute the right class to call according to something's type
   */
  public static function typeFrom($subjet)
  {
    if (is_array($subjet)) $class = 'Arrays';

    return $class;
  }
}
