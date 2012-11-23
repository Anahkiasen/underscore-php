<?php
namespace Underscore;

class Underscore
{
  /**
   * The current array being worked on
   * @var array
   */
  private $array;

  /**
   * Wrap an array in an Underscore object
   *
   * @param array $array An array to work on
   * @return Underscore
   */
  public function __construct($array)
  {
    $this->array = $array;
  }

  /**
   * Allow the static calling of methods
   */
  public static function __callStatic($method, $arguments)
  {
    $array   = array_get($arguments, 0);
    $closure = array_get($arguments, 1);

    return Collection::$method($array, $closure);
  }

  /**
   * Allow the chained calling of methods
   */
  public function __call($method, $arguments)
  {
    $closure = array_get($arguments, 0);

    $this->array = Collection::$method($this->array, $closure);

    return $this;
  }

  /**
   * Get the array from the object
   *
   * @return array
   */
  public function obtain()
  {
    return $this->array;
  }
}
