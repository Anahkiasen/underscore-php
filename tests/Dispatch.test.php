<?php
use Underscore\Dispatch;

class DispatchTest extends UnderscoreWrapper
{
  // Data providers ------------------------------------------------ /

  public function provideTypes()
  {
    return array(
      array('string', 'String'),
      array(array(), 'Arrays'),
      array(new stdClass, 'Object'),
      array(512, 'Number'),
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
