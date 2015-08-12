# CHANGELOG

## 2.1.0 - 2015-08-12

### Added

- Added `$saveKeys` argument to `Collection::group` to preserve the keys of the grouped elements

## 2.0.0 - 2015-05-16

### Added

- Added `Functions::partial`

### Deprecated

- `String` and `StringMethods` renamed to `Strings` and `StringsMethods` for PHP7 compatibility
- Package doesn't rely anymore on `illuminate/support` and should now be installable on any version of Laravel

## 1.3.1 - 2015-01-16

### Changed
- Minimum PHP version bumped to 5.4
- Allow non existant properties to be part of comparison instead of filtered out

## 1.3.0 - 2014-09-25

### Added
- Make helpers file opt-in
- Added `Arrays::interescts` and `Arrays::interesctions`
- Added `Collection::findBy` and `Collection::filterBy`
- Added `Arrays::removeValue`

## 1.2.3 - 2014-03-13

### Fixed
- Don't overwrite already defined `__` functions

## 1.2.2 - 2014-01-14

### Fixed
- Fixed `Arrays::find` not returning null on failed find
- Fixed bug in `Arrays::contains`

## 1.2.1 - 2013-06-25

### Added
- Added `Strings::isIp`, `Strings::isEmail` and `Strings::isUrl` from @robclancy Str class
- Added `Strings::prepend` and `Strings::append`
- Added `Strings::baseClass` to get the class out of a namespace (ie `Class` from `Namespace\My\Class`)

## 1.2.0 - 2013-03-15

### Changed
- Underscore.php now uses Illuminate's Strings class instead of Laravel 3's
- The `Underscore::chain` method was renamed to `Underscore::from` to match Repositories behavior

## 1.1.1 - 2013-02-11

### Added
- Parse::toArray will now use existing `toArray` method on objects if existing
- Add various case switchers (`toPascalCase`, `toSnakeCase`, `toCamelCase`)
- Add `Arrays::replaceKeys` to swap all the keys of an array
- Add possibility to change which character `Arrays::flatten` uses to flatten arrays
- Make Repositories use `Parse::toString` on `__toString`

## 1.1.0 - 2013-01-25

### Added
- Add Strings::randomStrings
- Repositories can now call the `->isEmpty` method to check if the subject is empty

### Changed
- Type classes now convert their subjects, meaning an object passed to an `Arrays::from` will convert the object to array
- Parse::toInteger($string) now returns the length of the string

### Fixed
- Fix bug with some native PHP functions when chaining
- Fix bug with type routing

## 1.0.0 - 2013-01-18

### Added
- Intial release of Underscore.php
- Type classes are now extendable
- Macros can't conflict between types
- Added Arrays::replaceValue to do an str_replace

[2.0.0]: https://github.com/Anahkiasen/underscore-php/compare/1.3.1...2.0.0
[1.3.1]: https://github.com/Anahkiasen/underscore-php/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/Anahkiasen/underscore-php/compare/1.2.3...1.3.0
[1.2.3]: https://github.com/Anahkiasen/underscore-php/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/Anahkiasen/underscore-php/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/Anahkiasen/underscore-php/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/Anahkiasen/underscore-php/compare/1.1.1...1.2.0
[1.1.1]: https://github.com/Anahkiasen/underscore-php/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/Anahkiasen/underscore-php/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/Anahkiasen/underscore-php/compare/1.0.0...1.0.0
