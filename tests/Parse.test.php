<?php
use Underscore\Parse;

class ParseTest extends UnderscoreWrapper
{
  public function testCanCreateCsvFiles()
  {
    $csv = Parse::toCSV($this->arrayMulti);
    $matcher = '"bar";"ter"' . PHP_EOL . '"bar";"ter"' .PHP_EOL. '"foo";"ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanUseCustomCsvDelimiter()
  {
    $csv = Parse::toCSV($this->arrayMulti, ',');
    $matcher = '"bar","ter"' . PHP_EOL . '"bar","ter"' .PHP_EOL. '"foo","ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanOutputCsvHeaders()
  {
    $csv = Parse::toCSV($this->arrayMulti, ',', true);
    $matcher = 'foo,bis' . PHP_EOL . '"bar","ter"' . PHP_EOL . '"bar","ter"' .PHP_EOL. '"foo","ter"';

    $this->assertEquals($matcher, $csv);
  }

  public function testCanConvertToJson()
  {
    $json = Parse::toJSON($this->arrayMulti);
    $matcher = '[{"foo":"bar","bis":"ter"},{"foo":"bar","bis":"ter"},{"bar":"foo","bis":"ter"}]';

    $this->assertEquals($matcher, $json);
  }

  public function testCanParseJson()
  {
    $json = Parse::toJSON($this->arrayMulti);
    $array = Parse::fromJSON($json);

    $this->assertEquals($this->arrayMulti, $array);
  }

  public function testCanConvertToArray()
  {
    $string = Parse::toArray('foobar');
    $number = Parse::toArray(15);
    $object = Parse::toArray($this->object);

    $this->assertEquals($this->array, $object);
    $this->assertEquals(array(15), $number);
    $this->assertEquals(array('foobar'), $string);
  }

}
