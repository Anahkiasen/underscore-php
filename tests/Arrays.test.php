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

  public function testCanGetKeys()
  {
    $array = Arrays::keys($this->array);

    $this->assertEquals(array('foo', 'bis'), $array);
  }

  public function testCanGetValues()
  {
    $array = Arrays::Values($this->array);

    $this->assertEquals(array('bar', 'ter'), $array);
  }

  public function testCanCheckIfHasValue()
  {
    $under = Arrays::has($this->array, 'foo');

    $this->assertTrue($under);
  }

  public function testCanGetValueFromArray()
  {
    $array = array('foo' => array('bar' => 'bis'));
    $under = Arrays::get($array, 'foo.bar');

    $this->assertEquals('bis', $under);
  }

  public function testCanDoSomethingAtEachValue()
  {
    $closure = function($value, $key) {
      echo $key.':'.$value.':';
    };

    Arrays::at($this->array, $closure);
    $result = 'foo:bar:bis:ter:';

    $this->expectOutputString($result);
  }

  public function testCanActOnEachValueFromArray()
  {
    $closure = function($value, $key) {
      return $key.':'.$value;
    };

    $under = Arrays::each($this->array, $closure);
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

  public function testCanCalculateAverageValue()
  {
    $average1 = array(5, 10, 15, 20);
    $average2 = array('foo', 'b', 'ar');
    $average3 = array(array('lol'), 10, 20);

    $average1 = Arrays::average($average1);
    $average2 = Arrays::average($average2);
    $average3 = Arrays::average($average3);

    $this->assertEquals(13, $average1);
    $this->assertEquals(0,  $average2);
    $this->assertEquals(10, $average3);
  }

  public function testCanGetFirstValue()
  {
    $under1 = Arrays::first($this->array);
    $under2 = Arrays::first($this->arrayNumbers, 2);

    $this->assertEquals('bar', $under1);
    $this->assertEquals(array(1, 2), $under2);
  }

  public function testCanGetLastValue()
  {
    $under = Arrays::last($this->array);

    $this->assertEquals('ter', $under);
  }

  public function testCanGetMaxValueFromAnArray()
  {
    $under = Arrays::max($this->arrayNumbers);

    $this->assertEquals(3, $under);
  }

  public function testCanGetMaxValueFromAnArrayWithClosure()
  {
    $under = Arrays::max($this->arrayNumbers, function($value) {
      return $value * -1;
    });

    $this->assertEquals(-1, $under);
  }

  public function testCanGetMinValueFromAnArray()
  {
    $under = Arrays::min($this->arrayNumbers);

    $this->assertEquals(1, $under);
  }

  public function testCanGetMinValueFromAnArrayWithClosure()
  {
    $under = Arrays::min($this->arrayNumbers, function($value) {
      return $value * -1;
    });

    $this->assertEquals(-3, $under);
  }

  public function testCanConvertToJson()
  {
    $under = Arrays::toJSON($this->array);

    $this->assertEquals('{"foo":"bar","bis":"ter"}', $under);
  }
}
