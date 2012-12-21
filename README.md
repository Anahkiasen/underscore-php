# Underscore.php [![Build Status](https://secure.travis-ci.org/Anahkiasen/underscore-php.png?branch=master)](https://travis-ci.org/Anahkiasen/underscore-php)
## The PHP manipulation toolbet

First off : Underscore.php is **not** a PHP port of [Underscore.js][] (well ok I mean it was at first).
It's doesn't aim to blatantly port its methods, but more port its philosophy.

It's a full-on PHP manipulation toolbet sugar-coated by an elegant syntax directly inspired by the [Laravel framework][]. Out through the window went the infamous `__()`, replaced by methods and class names that are meant to be read like sentences _à la_ Rails : `Arrays::from($article)->sortBy('author')->toJSON()`.

It features a good hundred of methods for all kinds of types : strings, objects, arrays, integers, and provides a parsing class that help switching from one type to the other mid-course. Oh also it's growing all the time.
The cherry on top ? It wraps nicely around native PHP functions meaning `String::replace` is actually a dynamic call to `str_replace` but with the benefit of allowed chaining and a **finally** consistant argument order (all functions in _Underscore_ put the subject as the first argument).

It works both as a stand-alone via *Composer* or as a bundle for the Laravel framework. So you know, you don't really have any excuse.

### Install Underscore

To install Underscore.php you can either add it via Composer :

    "anahkiasen/underscore-php" : "dev-master"

Or if you're using the Laravel framework, via the Artisan CLI :

    artisan bundle:install underscore

And then adding the following to your bundles files :

    'underscore' => array('auto' => true),

### Using Underscore

It can be used both as a static class, and an Object-Oriented class, so both the following are valid :

```php
$array = array(1, 2, 3);

// One-off calls to helpers
Underscore::each($array, function($value) { return $value * 2; })

// Or chain calls
Underscore::chain($array)->filter(...)->sort(...)->get(2)
```

You can also (and it's the recommended syntax) use Underscore's core classes and call them at any time, this mostly provides syntaxic elegance :

```php
// One-off calls
Arrays::first()
Object::methods()
String::escape()

// Chained calls
Arrays::create()->set('foo', 'bar')
Arrays::from($array)->sort()->toJSON()
```

The core concept is this : static calls return values from their methods, while chained calls update the value of the object they're working on. Which means that an Underscore object don't return its value until you call the `->obtain` method on it — until then you can chain as long as you want, it will remain an object.
The exception are certains properties that are considered _breakers_ and that will return the object's value. An example is `Arrays->get`.

Note that since all data passed to Underscore is transformed into an object, you can do this sort of things, plus the power of chained methods, it all makes the manipulation of arrays and objects a breeze.

```php
$array = array('foo' => 'bar');
$array = Arrays::from($array);

echo $array->foo // Returns 'bar'

$array->bis = 'ter'
$array->obtain() // Returns array('foo' => 'bar', 'bis' => 'ter')
```

## Customizing Underscore

Underscore.php provides the ability to extend any class with custom functions so go crazy. Don't forget that if you think you have a function anybody could enjoy, do a pull request, let everyone enjoy it !

```php
String::extend('summary', function($string) {
  return String::limitWords($string, 10, '... — click to read more');
});

String::from($article->content)->summary()->title()
```

It comes with a config file that allows you to alias the main class to whatever you want, the default being `Underscore`.
You can also give custom aliases to all of Underscore's methods, in said config file. Just add entries to the `aliases` option, the key being the alias, and the value the method to point to.

## Documentation

You can find a detailed summary of all classes and methods in the [repo's wiki][] or the [official page][].

Note that as Underscore natively extends PHP, it can automatically reference original PHP functions when the context matches. Per example the following will go call the original `array_diff` and `array_merge` functions.
The advantage is obviously that it allows chaining on a lot of otherwise one-off functions or that only work by reference.

```php
Arrays::diff($array, $array2, $array3)
Arrays::from($array)->diff($array2, $array3)->merge($array4)
```

## About Underscore.php

There is technically another port of Underscore.js to PHP available [on Github][] — I first discovered it when I saw it was for a time used on Laravel 4. I quickly grew disapoint of what a mess the code was, the lack of updates, and the 1:1 mentality that went behind it.
This revamped Underscore.php doesn't aim to be a direct port of Underscore.js. It sometimes omits methods that aren't relevant to PHP developers, rename others to match terms that are more common to them, provides a richer syntax, adds a whole lot of methods, and leaves room for future ones to be added all the time — whereas the previous port quickly recoded all JS methods to PHP and left it at that.

[official page]: http://anahkiasen.github.com/underscore-php/
[Laravel framework]: http://laravel.com/
[Underscore.js]: https://github.com/documentcloud/underscore
[repo's wiki]: https://github.com/Anahkiasen/underscore-php/wiki/_pages
[on Github]: https://github.com/brianhaveri/Underscore.php
