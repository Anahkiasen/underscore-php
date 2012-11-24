<?php
use Underscore\String;
use Underscore\Underscore;

class StringTest extends UnderscoreWrapper
{
  public $remove = 'foo foo bar foo kal ter son';

  // Tests --------------------------------------------------------- /

  public function testHasAccessToStrMethods()
  {
    $string1 = String::limit('foo', 1);
    $string2 = Underscore::chain('foo')->limit(1)->obtain();

    $this->assertEquals('f...', $string1);
    $this->assertEquals('f...', $string2);
  }

  public function testCanRemoveTextFromString()
  {
    $return = String::remove($this->remove, 'bar');

    $this->assertEquals('foo foo  foo kal ter son', $return);
  }

  public function testCanRemoveMultipleTextsFromString()
  {
    $return = String::remove($this->remove, array('foo', 'son'));

    $this->assertEquals('bar  kal ter', $return);
  }

  public function testCanToggleBetweenTwoStrings()
  {
    $toggle = String::toggle('foo', 'foo', 'bar');
    $this->assertEquals('bar', $toggle);
  }

  public function testCannotLooselyToggleBetweenStrings()
  {
    $toggle = String::toggle('dei', 'foo', 'bar');
    $this->assertEquals('dei', $toggle);
  }

  public function testCanLooselyToggleBetweenStrings()
  {
    $toggle = String::toggle('dei', 'foo', 'bar', $loose = true);
    $this->assertEquals('foo', $toggle);
  }

  public function testCanRepeatString()
  {
    $string = String::from('foo')->repeat(3)->obtain();

    $this->assertEquals('foofoofoo', $string);
  }
}
