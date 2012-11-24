<?php
use Underscore\Dispatch;

class DispatchTest extends UnderscoreWrapper
{
  // Data providers ------------------------------------------------ /

  public function provideTypes()
  {
    return array(
      array('string', '\Underscore\String'),
      array(array(), '\Underscore\Arrays'),
      array(new stdClass, '\Underscore\Object'),
      array(512, false),
    );
  }

  /**
   * @dataProvider provideTypes
   */
  public function testCanGetClassFromType($subject, $expected)
  {
    if (!$expected) $this->setExpectedException('InvalidArgumentException');

    $dispatch = Dispatch::toClass($subject);

    $this->assertEquals($expected, $dispatch);
  }
}
