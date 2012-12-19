<?php
use Underscore\Types\String;

class LaravelStringTest extends UnderscoreWrapper
{
  /**
   * Test the String::length method.
   *
   * @group laravel
   */
  public function testStringLengthIsCorrect()
  {
    $this->assertEquals(6, String::length('Taylor'));
    $this->assertEquals(5, String::length('ラドクリフ'));
  }

  /**
   * Test the String::lower method.
   *
   * @group laravel
   */
  public function testStringCanBeConvertedToLowercase()
  {
    $this->assertEquals('taylor', String::lower('TAYLOR'));
    $this->assertEquals('άχιστη', String::lower('ΆΧΙΣΤΗ'));
  }

  /**
   * Test the String::upper method.
   *
   * @group laravel
   */
  public function testStringCanBeConvertedToUppercase()
  {
    $this->assertEquals('TAYLOR', String::upper('taylor'));
    $this->assertEquals('ΆΧΙΣΤΗ', String::upper('άχιστη'));
  }

  /**
   * Test the String::title method.
   *
   * @group laravel
   */
  public function testStringCanBeConvertedToTitleCase()
  {
    $this->assertEquals('Taylor', String::title('taylor'));
    $this->assertEquals('Άχιστη', String::title('άχιστη'));
  }

  /**
   * Test the String::limit method.
   *
   * @group laravel
   */
  public function testStringCanBeLimitedByCharacters()
  {
    $this->assertEquals('Tay...', String::limit('Taylor', 3));
    $this->assertEquals('Taylor', String::limit('Taylor', 6));
    $this->assertEquals('Tay___', String::limit('Taylor', 3, '___'));
  }

  /**
   * Test the String::words method.
   *
   * @group laravel
   */
  public function testStringCanBeLimitedByWords()
  {
    $this->assertEquals('Taylor...', String::words('Taylor Otwell', 1));
    $this->assertEquals('Taylor___', String::words('Taylor Otwell', 1, '___'));
    $this->assertEquals('Taylor Otwell', String::words('Taylor Otwell', 3));
  }

  /**
   * Test the String::plural and String::singular methods.
   *
   * @group laravel
   */
  public function testStringsCanBeSingularOrPlural()
  {
    $this->assertEquals('user', String::singular('users'));
    $this->assertEquals('users', String::plural('user'));
    $this->assertEquals('User', String::singular('Users'));
    $this->assertEquals('Users', String::plural('User'));
    $this->assertEquals('user', String::plural('user', 1));
    $this->assertEquals('users', String::plural('user', 2));
    $this->assertEquals('chassis', String::plural('chassis', 2));
    $this->assertEquals('traffic', String::plural('traffic', 2));
  }

  /**
   * Test the String::slug method.
   *
   * @group laravel
   */
  public function testStringsCanBeSlugged()
  {
    $this->assertEquals('my-new-post', String::slug('My nEw post!!!'));
    $this->assertEquals('my_new_post', String::slug('My nEw post!!!', '_'));
  }

  /**
   * Test the String::classify method.
   *
   * @group laravel
   */
  public function testStringsCanBeClassified()
  {
    $this->assertEquals('Something_Else', String::classify('something.else'));
    $this->assertEquals('Something_Else', String::classify('something_else'));
  }

  /**
   * Test the String::random method.
   *
   * @group laravel
   */
  public function testRandomStringsCanBeGenerated()
  {
    $this->assertEquals(40, strlen(String::random(40)));
  }
}