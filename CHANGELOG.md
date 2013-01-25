Underscore.php
=====

1.1.0
-----

- Add String::randomStrings
- Repositories can now call the `->isEmpty` method to check if the subject is empty
- Type classes now convert their subjects, meaning an object passed to an `Arrays::from` will convert the object to array
- Parse::toInteger($string) now returns the length of the string
- Fix bug with some native PHP functions when chaining
- Fix bug with type routing

1.0.0
-----

- Intial release of Underscore.php
- Type classes are now extendable
- Macros can't conflict between types
- Added Arrays::replaceValue to do an str_replace