<?php
use Underscore\Types\Number;
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

  public function testCanUsePhpRoundingMethods()
  {
    $number = Number::round(5.33);
    $this->assertEquals(5, $number);

    $number = Number::ceil(5.33);
    $this->assertEquals(6, $number);

    $number = Number::floor(5.33);
    $this->assertEquals(5, $number);
  }
}