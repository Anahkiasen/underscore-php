<?php

/*
 * This file is part of Underscore.php
 *
 * (c) Maxime Fabre <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Underscore\Methods;

use Closure;

/**
 * Abstract Collection type
 * Methods that apply to both objects and arrays.
 */
abstract class CollectionMethods
{
    ////////////////////////////////////////////////////////////////////
    ///////////////////////////// ANALYZE //////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Check if an array has a given key.
     *
     * @param mixed $array
     * @param mixed $key
     */
    public static function has($array, $key)
    {
        // Generate unique string to use as marker
        $unfound = StringsMethods::random(5);

        return static::get($array, $key, $unfound) !== $unfound;
    }

    ////////////////////////////////////////////////////////////////////
    //////////////////////////// FETCH FROM ////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Get a value from an collection using dot-notation.
     *
     * @param array  $collection The collection to get from
     * @param string $key        The key to look for
     * @param mixed  $default    Default value to fallback to
     *
     * @return mixed
     */
    public static function get($collection, $key, $default = null)
    {
        if (null === $key) {
            return $collection;
        }

        $collection = (array) $collection;

        if (isset($collection[$key])) {
            return $collection[$key];
        }

        // Crawl through collection, get key according to object or not
        foreach (explode('.', $key) as $segment) {
            $collection = (array) $collection;

            if (!isset($collection[$segment])) {
                return $default instanceof Closure ? $default() : $default;
            }

            $collection = $collection[$segment];
        }

        return $collection;
    }

    /**
     * Set a value in a collection using dot notation.
     *
     * @param mixed  $collection The collection
     * @param string $key        The key to set
     * @param mixed  $value      Its value
     *
     * @return mixed
     */
    public static function set($collection, $key, $value)
    {
        static::internalSet($collection, $key, $value);

        return $collection;
    }

    /**
     * Get a value from a collection and set it if it wasn't.
     *
     * @param mixed  $collection The collection
     * @param string $key        The key
     * @param mixed  $default    The default value to set if it isn't
     *
     * @return mixed
     */
    public static function setAndGet(&$collection, $key, $default = null)
    {
        // If the key doesn't exist, set it
        if (!static::has($collection, $key)) {
            $collection = static::set($collection, $key, $default);
        }

        return static::get($collection, $key);
    }

    /**
     * Remove a value from an array using dot notation.
     *
     * @param mixed $collection
     * @param mixed $key
     */
    public static function remove($collection, $key)
    {
        // Recursive call
        if (is_array($key)) {
            foreach ($key as $k) {
                static::internalRemove($collection, $k);
            }

            return $collection;
        }

        static::internalRemove($collection, $key);

        return $collection;
    }

    /**
     * Fetches all columns $property from a multimensionnal array.
     *
     * @param mixed $collection
     * @param mixed $property
     */
    public static function pluck($collection, $property)
    {
        $plucked = array_map(function ($value) use ($property) {
            return ArraysMethods::get($value, $property);
        }, (array) $collection);

        // Convert back to object if necessary
        if (is_object($collection)) {
            $plucked = (object) $plucked;
        }

        return $plucked;
    }

    /**
     * Filters an array of objects (or a numeric array of associative arrays) based on the value of a particular property within that.
     *
     * @param string $property
     * @param string $value
     * @param string $comparisonOp
     * @param mixed  $collection
     */
    public static function filterBy($collection, $property, $value, $comparisonOp = null)
    {
        if (!$comparisonOp) {
            $comparisonOp = is_array($value) ? 'contains' : 'eq';
        }
        $ops = [
            'eq' => function ($item, $prop, $value) {
                return $item[$prop] === $value;
            },
            'gt' => function ($item, $prop, $value) {
                return $item[$prop] > $value;
            },
            'gte' => function ($item, $prop, $value) {
                return $item[$prop] >= $value;
            },
            'lt' => function ($item, $prop, $value) {
                return $item[$prop] < $value;
            },
            'lte' => function ($item, $prop, $value) {
                return $item[$prop] <= $value;
            },
            'ne' => function ($item, $prop, $value) {
                return $item[$prop] !== $value;
            },
            'contains' => function ($item, $prop, $value) {
                return in_array($item[$prop], (array) $value, true);
            },
            'notContains' => function ($item, $prop, $value) {
                return !in_array($item[$prop], (array) $value, true);
            },
            'newer' => function ($item, $prop, $value) {
                return strtotime($item[$prop]) > strtotime($value);
            },
            'older' => function ($item, $prop, $value) {
                return strtotime($item[$prop]) < strtotime($value);
            },
        ];
        $result = array_values(array_filter((array) $collection, function ($item) use (
            $property,
            $value,
            $ops,
            $comparisonOp
        ) {
            $item = (array) $item;
            $item[$property] = static::get($item, $property, []);

            return $ops[$comparisonOp]($item, $property, $value);
        }));
        if (is_object($collection)) {
            $result = (object) $result;
        }

        return $result;
    }

    public static function findBy($collection, $property, $value, $comparisonOp = 'eq')
    {
        $filtered = static::filterBy($collection, $property, $value, $comparisonOp);

        return ArraysMethods::first($filtered);
    }

    ////////////////////////////////////////////////////////////////////
    ///////////////////////////// ANALYZE //////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Get all keys from a collection.
     *
     * @param mixed $collection
     */
    public static function keys($collection)
    {
        return array_keys((array) $collection);
    }

    /**
     * Get all values from a collection.
     *
     * @param mixed $collection
     */
    public static function values($collection)
    {
        return array_values((array) $collection);
    }

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////// ALTER ///////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Replace a key with a new key/value pair.
     *
     * @param mixed $collection
     * @param mixed $replace
     * @param mixed $key
     * @param mixed $value
     */
    public static function replace($collection, $replace, $key, $value)
    {
        $collection = static::remove($collection, $replace);
        $collection = static::set($collection, $key, $value);

        return $collection;
    }

    /**
     * Sort a collection by value, by a closure or by a property
     * If the sorter is null, the collection is sorted naturally.
     *
     * @param mixed      $collection
     * @param null|mixed $sorter
     * @param mixed      $direction
     */
    public static function sort($collection, $sorter = null, $direction = 'asc')
    {
        $collection = (array) $collection;

        // Get correct PHP constant for direction
        $direction = ('desc' === strtolower($direction)) ? SORT_DESC : SORT_ASC;

        // Transform all values into their results
        if ($sorter) {
            $results = ArraysMethods::each($collection, function ($value) use ($sorter) {
                return is_callable($sorter) ? $sorter($value) : ArraysMethods::get($value, $sorter);
            });
        } else {
            $results = $collection;
        }

        // Sort by the results and replace by original values
        array_multisort($results, $direction, SORT_REGULAR, $collection);

        return $collection;
    }

    /**
     * Group values from a collection according to the results of a closure.
     *
     * @param mixed $collection
     * @param mixed $grouper
     * @param mixed $saveKeys
     */
    public static function group($collection, $grouper, $saveKeys = false)
    {
        $collection = (array) $collection;
        $result = [];

        // Iterate over values, group by property/results from closure
        foreach ($collection as $key => $value) {
            $groupKey = is_callable($grouper) ? $grouper($value, $key) : ArraysMethods::get($value, $grouper);
            $newValue = static::get($result, $groupKey);

            // Add to results
            if (null !== $groupKey && $saveKeys) {
                $result[$groupKey] = $newValue;
                $result[$groupKey][$key] = $value;
            } elseif (null !== $groupKey) {
                $result[$groupKey] = $newValue;
                $result[$groupKey][] = $value;
            }
        }

        return $result;
    }

    /**
     * Given a list, and an iteratee function that returns
     * a key for each element in the list (or a property name),
     * returns an object with an index of each item.
     * Just like groupBy, but for when you know your keys are unique.
     *
     * @param array $array
     * @param mixed $key
     *
     * @return array
     */
    public static function indexBy(array $array, $key)
    {
        $results = [];

        foreach ($array as $a) {
            if (isset($a[$key])) {
                $results[$a[$key]] = $a;
            }
        }

        return $results;
    }

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS /////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Internal mechanic of set method.
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected static function internalSet(&$collection, $key, $value)
    {
        if (null === $key) {
            return $collection = $value;
        }

        // Explode the keys
        $keys = explode('.', $key);

        // Crawl through the keys
        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If we're dealing with an object
            if (is_object($collection)) {
                $collection->$key = static::get($collection, $key, []);
                $collection = &$collection->$key;
                // If we're dealing with an array
            } else {
                $collection[$key] = static::get($collection, $key, []);
                $collection = &$collection[$key];
            }
        }

        // Bind final tree on the collection
        $key = array_shift($keys);
        if (is_array($collection)) {
            $collection[$key] = $value;
        } else {
            $collection->$key = $value;
        }
    }

    /**
     * Internal mechanics of remove method.
     *
     * @param mixed $key
     */
    protected static function internalRemove(&$collection, $key)
    {
        // Explode keys
        $keys = explode('.', $key);

        // Crawl though the keys
        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!static::has($collection, $key)) {
                return false;
            }

            // If we're dealing with an object
            if (is_object($collection)) {
                $collection = &$collection->$key;
                // If we're dealing with an array
            } else {
                $collection = &$collection[$key];
            }
        }

        $key = array_shift($keys);
        if (is_object($collection)) {
            unset($collection->$key);
        } else {
            unset($collection[$key]);
        }
    }
}
