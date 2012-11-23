<?php
use Underscore\Arrays;
use Underscore\Underscore;

class UnderscoreTest extends UnderscoreWrapper
{
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

  public function testCanHaveAliasesForMethods()
  {
    $under = Arrays::select($this->arrayNumbers, function($value) {
      return $value == 1;
    });

    $this->assertEquals(1, $under);
  }
}
