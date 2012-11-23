<?php
use Underscore\Underscore;

class UnderscoreTest extends UnderscoreWrapper
{
  private $array = array('foo' => 'bar', 'bis' => 'ter');

  // Tests --------------------------------------------------------- /

  public function testCanWrapObject()
  {
    $under = new Underscore($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under);
  }

  public function testCanWrapWithShortcutFunction()
  {
    $under = underscore($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under);
  }
}
