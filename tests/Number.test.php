<?php
use Underscore\Number;
use Underscore\Underscore;

class NumberTest extends UnderscoreWrapper
{
  public function testCanPadANumber()
  {
    $number = Number::pad(5, 3);

    $this->assertEquals('050', $number);
  }

  public function testCanPadANumberOnTheLeft()
  {
    $number = Number::padLeft(5, 3);

    $this->assertEquals('005', $number);
  }

  public function testCanPadANumberOnTheRight()
  {
    $number = Number::padRight(5, 3);

    $this->assertEquals('500', $number);
  }
}