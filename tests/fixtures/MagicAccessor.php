<?php
namespace fixtures;
class MagicAccessor
{
  private $values;

  public function __construct(array $values) {
    $this->values = $values;
  }

  public function __get($key) {
    return $this->values[$key];
  }
}
