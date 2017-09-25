<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore\Types;

use Underscore\Dummies\DummyDefault;
use Underscore\UnderscoreTestCase;

/**
 * @coversNothing
 */
class ObjectTest extends UnderscoreTestCase
{
    public function testCanCreateObject()
    {
        $object = Object::create();

        $this->assertInstanceOf('stdClass', $object->obtain());
    }

    public function testCanObjectifyAnArray()
    {
        $object = Object::from(['foo' => 'bar']);
        $this->assertSame('bar', $object->foo);

        $object->bis = 'ter';
        $this->assertSame('ter', $object->bis);

        $this->assertSame(['foo' => 'bar', 'bis' => 'ter'], (array) $object->obtain());
    }

    public function testCanGetKeys()
    {
        $object = Object::keys($this->object);

        $this->assertSame(['foo', 'bis'], $object);
    }

    public function testCanGetValues()
    {
        $object = Object::Values($this->object);

        $this->assertSame(['bar', 'ter'], $object);
    }

    public function testCanGetMethods()
    {
        $methods = [
            'getDefault',
            'toArray',
            '__construct',
            '__toString',
            'create',
            'from',
            '__get',
            '__set',
            'isEmpty',
            'setSubject',
            'obtain',
            'extend',
            '__callStatic',
            '__call',
        ];

        $this->assertSame($methods, Object::methods(new DummyDefault()));
    }

    public function testCanPluckColumns()
    {
        $object = Object::pluck($this->objectMulti, 'foo');
        $matcher = (object) ['bar', 'bar', null];

        $this->assertSame($matcher, $object);
    }

    public function testCanSetValues()
    {
        $object = (object) ['foo' => ['foo' => 'bar'], 'bar' => 'bis'];
        $object = Object::set($object, 'foo.bar.bis', 'ter');

        $this->assertSame('ter', $object->foo['bar']['bis']);
        $this->assertObjectHasAttribute('bar', $object);
    }

    public function testCanRemoveValues()
    {
        $array = Object::remove($this->objectMulti, '0.foo');
        $matcher = (array) $this->objectMulti;
        unset($matcher[0]->foo);

        $this->assertSame((object) $matcher, $array);
    }

    public function testCanConvertToJson()
    {
        $under = Object::toJSON($this->object);

        $this->assertSame('{"foo":"bar","bis":"ter"}', $under);
    }

    public function testCanSort()
    {
        $child = (object) ['sort' => 5];
        $child_alt = (object) ['sort' => 12];
        $object = (object) ['name' => 'foo', 'age' => 18, 'child' => $child];
        $object_alt = (object) ['name' => 'bar', 'age' => 21, 'child' => $child_alt];
        $collection = [$object, $object_alt];

        $under = Object::sort($collection, 'name', 'asc');
        $this->assertSame([$object_alt, $object], $under);

        $under = Object::sort($collection, 'child.sort', 'desc');
        $this->assertSame([$object_alt, $object], $under);

        $under = Object::sort($collection, function ($value) {
            return $value->child->sort;
        }, 'desc');
        $this->assertSame([$object_alt, $object], $under);
    }

    public function testCanConvertToArray()
    {
        $object = Object::toArray($this->object);

        $this->assertSame($this->array, $object);
    }

    public function testCanUnpackObjects()
    {
        $multi = (object) ['attributes' => ['name' => 'foo', 'age' => 18]];
        $objectAuto = Object::unpack($multi);
        $objectManual = Object::unpack($multi, 'attributes');

        $this->assertObjectHasAttribute('name', $objectAuto);
        $this->assertObjectHasAttribute('age', $objectAuto);
        $this->assertSame('foo', $objectAuto->name);
        $this->assertSame(18, $objectAuto->age);
        $this->assertSame($objectManual, $objectAuto);
    }

    public function testCanReplaceValues()
    {
        $object = Object::replace($this->object, 'foo', 'notfoo', 'notbar');
        $matcher = (object) ['notfoo' => 'notbar', 'bis' => 'ter'];

        $this->assertSame($matcher, $object);
    }

    public function testCanSetAnGetValues()
    {
        $object = $this->object;
        $getset = Object::setAndGet($object, 'set', 'get');
        $get = Object::get($object, 'set');

        $this->assertSame($getset, 'get');
        $this->assertSame($get, $getset);
    }

    public function testFilterBy()
    {
        $a = [
            (object) ['id' => 123, 'name' => 'foo', 'group' => 'primary', 'value' => 123456],
            (object) ['id' => 456, 'name' => 'bar', 'group' => 'primary', 'value' => 1468],
            (object) ['id' => 499, 'name' => 'baz', 'group' => 'secondary', 'value' => 2365],
            (object) ['id' => 789, 'name' => 'ter', 'group' => 'primary', 'value' => 2468],
        ];

        $b = Object::filterBy($a, 'name', 'baz');
        $this->assertCount(1, $b);
        $this->assertSame(2365, $b[0]->value);

        $c = Object::filterBy($a, 'value', 2468);
        $this->assertCount(1, $c);
        $this->assertSame('primary', $c[0]->group);

        $d = Object::filterBy($a, 'group', 'primary');
        $this->assertCount(3, $d);

        $e = Object::filterBy($a, 'value', 2000, 'lt');
        $this->assertCount(1, $e);
        $this->assertSame(1468, $e[0]->value);
    }

    public function testFindBy()
    {
        $a = [
            (object) ['id' => 123, 'name' => 'foo', 'group' => 'primary', 'value' => 123456],
            (object) ['id' => 456, 'name' => 'bar', 'group' => 'primary', 'value' => 1468],
            (object) ['id' => 499, 'name' => 'baz', 'group' => 'secondary', 'value' => 2365],
            (object) ['id' => 789, 'name' => 'ter', 'group' => 'primary', 'value' => 2468],
        ];

        $b = Object::findBy($a, 'name', 'baz');
        $this->assertInstanceOf('\stdClass', $b);
        $this->assertSame(2365, $b->value);
        $this->assertObjectHasAttribute('name', $b);
        $this->assertObjectHasAttribute('group', $b);
        $this->assertObjectHasAttribute('value', $b);

        $c = Object::findBy($a, 'value', 2468);
        $this->assertInstanceOf('\stdClass', $c);
        $this->assertSame('primary', $c->group);

        $d = Object::findBy($a, 'group', 'primary');
        $this->assertInstanceOf('\stdClass', $d);
        $this->assertSame('foo', $d->name);

        $e = Object::findBy($a, 'value', 2000, 'lt');
        $this->assertInstanceOf('\stdClass', $e);
        $this->assertSame(1468, $e->value);
    }
}
