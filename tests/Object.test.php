<?php
use Underscore\Object;
use Underscore\Underscore;

class ObjectTest extends UnderscoreWrapper
{
  public function testCanGetKeys()
  {
    $object = Object::keys($this->object);

    $this->assertEquals(array('foo', 'bis'), $object);
  }

  public function testCanGetValues()
  {
    $object = Object::Values($this->object);

    $this->assertEquals(array('bar', 'ter'), $object);
  }

  public function testCanConvertToJson()
  {
    $under = Object::toJSON($this->object);

    $this->assertEquals('{"foo":"bar","bis":"ter"}', $under);
  }
}
