<?php
use Underscore\Arrays;
use Underscore\Underscore;

class UnderscoreTest extends UnderscoreWrapper
{
  // Tests --------------------------------------------------------- /

  public function testCanWrapObject()
  {
    $under1 = new Underscore($this->array);
    $under2 = Underscore::chain($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under1);
    $this->assertInstanceOf('Underscore\Underscore', $under2);
  }

  public function testCanWrapWithSubclasses()
  {
    $under = Arrays::from($this->array);
    $chain = $under->get('foo');

    $this->assertInstanceOf('Underscore\Underscore', $under);
    $this->assertEquals('bar', $chain);
  }

  public function testCanWrapWithShortcutFunction()
  {
    // Skip if base function not present
    if (!function_exists('underscore')) return $this->assertTrue(true);

    $under = underscore($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under);
  }

  public function testCanHaveAliasesForMethods()
  {
    $under = Arrays::select($this->arrayNumbers, function($value) {
      return $value == 1;
    });

    $this->assertEquals(array(1), $under);
  }

  public function testUserCanExtendWithCustomFunctions()
  {
    Arrays::extend('fooify', function($string) {
      return 'bar';
    });
    $string = Arrays::fooify(array('foo'));

    $this->assertEquals('bar', $string);
  }

  public function testHasAccessToOriginalPhpFunctions()
  {
    $array = Arrays::from($this->array);
    $array = $array->intersect(array('foo' => 'bar', 'kal' => 'mon'));

    $this->assertEquals(array('foo' => 'bar'), $array->obtain());
  }
}
