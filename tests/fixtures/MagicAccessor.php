<?php
namespace fixtures;
class MagicAccessor
{
  private $values;

  public function __construct(array $values) {
    $this->values = $values;
  }

  public function __get($key) {
    return isset($this->values[$key]) ? $this->values[$key] : null;
  }
}
