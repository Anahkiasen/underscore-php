<?php
namespace Underscore;

use StdClass;

class DispatchTest extends UnderscoreTestCase
{
    // Data providers ------------------------------------------------ /

    public function provideTypes()
    {
        return [
            ['string', 'String'],
            [5.14, 'Number'],
            [512, 'Number'],
            [1.2e3, 'Number'],
            [7E-10, 'Number'],
            [[], 'Arrays'],
            [new StdClass(), 'Object'],
            [
                function () {
                    return;
                },
                'Functions',
            ],
            [null, 'String'],
        ];
    }

    /**
     * @dataProvider provideTypes
     */
    public function testCanGetClassFromType($subject, $expected)
    {
        $dispatch = Dispatch::toClass($subject);

        $this->assertEquals('Underscore\Types\\'.$expected, $dispatch);
    }

    public function testCanThrowExceptionAtUnknownTypes()
    {
        $this->setExpectedException('InvalidArgumentException');

        $file = fopen('../.travis.yml', 'w+');
        $dispatch = Dispatch::toClass($file);
    }
}
