<?php
include '_start.php';

use Underscore\Dispatch;

class DispatchTest extends UnderscoreWrapper
{
  // Data providers ------------------------------------------------ /

  public function provideTypes()
  {
    return array(
      array('string', 'String'),
      array(5.14, 'Number'),
      array(512, 'Number'),
      array(1.2e3, 'Number'),
      array(7E-10, 'Number'),
      array(array(), 'Arrays'),
      array(new stdClass, 'Object'),
    );
  }

  /**
   * @dataProvider provideTypes
   */
  public function testCanGetClassFromType($subject, $expected)
  {
    if (!$expected) $this->setExpectedException('InvalidArgumentException');

    $dispatch = Dispatch::toClass($subject);

    $this->assertEquals('\Underscore\Types\\'.$expected, $dispatch);
  }
}
