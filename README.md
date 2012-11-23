# Underscore.php

Underscore.php is a PHP port of Underscore.js. Its goal is to ease the working and manipulation of arrays, strings and such in PHP.
It can be used both as a static class, and an Object-Oriented class, so both the following are valid :

```php
$array = array(1, 2, 3);

Underscore::map($array, function($value) { return $value * 2; })
underscore($array)->map(function($value) { return $value * 2; })
```

# API

## get

Get a value from an array using dot-notation

```php
$array = underscore(array('foo' => array('bar' => 'ter')));
$array->get('foo.bar') // Return 'ter'
```

## each

Iterate over an array to execute a callback at each loop

```php
$multiplier = 3;
Underscore::each(array(1, 2, 3), function($value) use ($multiplier) {
  echo $value * $multiplier; // Prints out 3, 6, 9
});
```

## map

Iterate over an array and apply a callback to each value

```php
Underscore::map(array(1, 2, 3), function($value) {
  return $value * 3; // Return array(3, 6, 9)
});
```
