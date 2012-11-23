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
}