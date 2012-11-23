# Underscore.php

Underscore.php is a PHP port of Underscore.js. Its goal is to ease the working and manipulation of arrays, strings and such in PHP. My first goal is to match all of Underscore's methods but I'll probably add more helpers along the way for stuff that people do on a daily basis.
It can be used both as a static class, and an Object-Oriented class, so both the following are valid :

```php
$array = array(1, 2, 3);

// One-off calls to helpers
Underscore::map($array, function($value) { return $value * 2; })
underscore($array)->map(function($value) { return $value * 2; })

// Or chain calls
Underscore::chain($array)->filter(...)->sort(...)->get(2)
```

You can also alias Underscore's core classes and call them at any time, this mostly provides syntaxic elegance :

```php
// One-off calls
Arrays::first(...)
Arrays::each(...)
String::escape(...)

// Chained calls
Arrays::from($array)->filter(...)->get(2)
```

It comes with a config file that allows you to alias the main class to whatever you want, the default being `Underscore` and the most common probably being `__` (which is already taken in **Laravel** by the translation helper).
You can also give custom aliases to all of Underscore's methods, in said config file. Just add entries to the `aliases` option, the key being the alias, and the value the method to point to.

# Documentation

**Available classes**
- [Arrays][] : Helpers for arrays

## Arrays

### Arrays::get

Get a value from an array using dot-notation

```php
$array = underscore(array('foo' => array('bar' => 'ter')));
$array->get('foo.bar') // Return 'ter'
```

### Arrays::count

Count the number of items in an array

```php
Underscore::count(array(1, 2, 3)) // Returns 3
```

### Arrays::each

Iterate over an array to execute a callback at each loop

```php
$multiplier = 3;
Underscore::each(array(1, 2, 3), function($value) use ($multiplier) {
  echo $value * $multiplier; // Prints out 3, 6, 9
});
```

### Arrays::map

Iterate over an array and apply a callback to each value

```php
Underscore::map(array(1, 2, 3), function($value) {
  return $value * 3; // Return array(3, 6, 9)
});
```

### Arrays::find

Find the first value in an array that passes a truth test

```php
Underscore::find(array(1, 2, 3), function($value) {
  return $value % 2 == 0; // Returns 2
});
```

### Arrays::filter

Find all values in an array that passes a truth test

```php
Underscore::filter(array(1, 2, 3), function($value) {
  return $value % 2 != 0; // Returns array(1, 3)
});
```

### Arrays::reject

Find all values in an array that are rejected by a truth test

```php
Underscore::filter(array(1, 2, 3), function($value) {
  return $value % 2 != 0; // Returns array(2)
});
```

### Arrays::matches

Check if all items in an array match a truth test

```php
Underscore::matches(array(1, 2, 3), function($value) {
  return $value % 2 == 0; // Returns false
});
```

### Arrays::matchesAny

Same than above but returns true if at least one item matches

```php
Underscore::matchesAny(array(1, 2, 3), function($value) {
  return $value % 2 == 0; // Returns true
});
```

### Arrays::invoke

Invoke a function on all of an array's values

```php
Underscore::invoke(array('   foo'), 'trim'); // Returns array('foo')
```

[Arrays]: #arrays
