<?php
use Underscore\String;
use Underscore\Underscore;

class StringTest extends UnderscoreWrapper
{
  public $remove = 'foo foo bar foo kal ter son';

  public function provideFind()
  {
    return array(

      // Simple cases
      array(false, 'foo', 'bar'),
      array(true, 'foo', 'foo'),
      array(true, 'FOO', 'foo', false),
      array(false, 'FOO', 'foo', true),

      // Many needles, one haystack
      array(true, array('foo', 'bar'), $this->remove),
      array(false, array('vlu', 'bla'), $this->remove),
      array(true, array('foo', 'vlu'), $this->remove, false, false),
      array(false, array('foo', 'vlu'), $this->remove, false, true),

      // Many haystacks, one needle
      array(true, 'foo', array('foo', 'bar')),
      array(true, 'bar', array('foo', 'bar')),
      array(false, 'foo', array('bar', 'kal')),
      array(true, 'foo', array('foo', 'foo'), false, false),
      array(false, 'foo', array('foo', 'bar'), false, true),
    );
  }

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

  /**
   * @dataProvider provideFind
   */
  public function testCanFindStringsInStrings($expect, $needle, $haystack, $caseSensitive = false, $absoluteFinding = false)
  {
    $result = String::find($haystack, $needle, $caseSensitive, $absoluteFinding);

    $this->assertEquals($expect, $result);
  }

  public function testCanAssertAStringStartsWith()
  {
    $this->assertTrue(String::startsWith('foobar', 'foo'));
    $this->assertFalse(String::startsWith('barfoo', 'foo'));
  }

  public function testCanAssertAStringEndsWith()
  {
    $this->assertTrue(String::endsWith('foobar', 'bar'));
    $this->assertFalse(String::endsWith('barfoo', 'bar'));
  }
}
