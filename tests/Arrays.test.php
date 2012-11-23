<?php
include '_startTest.php';

use Underscore\Underscore;
use Underscore\Arrays;

class ArraysTest extends UnderscoreWrapper
{
  // Tests --------------------------------------------------------- /

  public function testCanUseClassDirectly()
  {
    $under = Arrays::get($this->array, 'foo');

    $this->assertEquals('bar', $under);
  }

  public function testCanCreateChainableObject()
  {
    $under = Underscore::chain($this->arrayNumbers);
    $under = $under->get(1);

    $this->assertEquals(2, $under);
  }

  public function testCanGetValueFromArray()
  {
    $array = array('foo' => array('bar' => 'bis'));
    $under = Arrays::get($array, 'foo.bar');

    $this->assertEquals('bis', $under);
  }

  public function testCanEachOverAnArray()
  {
    $closure = function($value, $key) {
      echo $key.':'.$value.':';
    };

    Arrays::each($this->array, $closure);
    $result = 'foo:bar:bis:ter:';

    $this->expectOutputString($result);
  }

  public function testCanMapValuesToAnArray()
  {
    $closure = function($value, $key) {
      return $key.':'.$value;
    };

    $under = Arrays::map($this->array, $closure);
    $result = array('foo' => 'foo:bar', 'bis' => 'bis:ter');

    $this->assertEquals($result, $under);
  }

  public function testCanFindAValueInAnArray()
  {
    $under = Arrays::find($this->arrayNumbers, function($value) {
      return $value % 2 == 0;
    });

    $this->assertEquals(2, $under);
  }

  public function testCanFilterValuesFromAnArray()
  {
    $under = Arrays::filter($this->arrayNumbers, function($value) {
      return $value % 2 != 0;
    });

    $this->assertEquals(array(0 => 1, 2 => 3), $under);
  }

  public function testCanFilterRejectedValuesFromAnArray()
  {
    $under = Arrays::reject($this->arrayNumbers, function($value) {
      return $value % 2 != 0;
    });

    $this->assertEquals(array(1 => 2), $under);
  }

  public function testCanMatchAnArrayContent()
  {
    $under = Arrays::matches($this->arrayNumbers, function($value) {
      return is_int($value);
    });

    $this->assertTrue($under);
  }

  public function testCanMatchPathOfAnArrayContent()
  {
    $under = Arrays::matchesAny($this->arrayNumbers, function($value) {
      return $value == 2;
    });

    $this->assertTrue($under);
  }

  public function testCanInvokeFunctionsOnValues()
  {
    $array = array('   foo', '   bar');
    $array = Arrays::invoke($array, 'trim');

    $this->assertEquals(array('foo', 'bar'), $array);
  }

  public function testCanPluckColumns()
  {
    $under = Arrays::pluck($this->arrayMulti, 'foo');
    $matcher = array('bar', 'bar', array('bar' => 'foo', 'bis' => 'ter'));

    $this->assertEquals($matcher, $under);
  }
}
