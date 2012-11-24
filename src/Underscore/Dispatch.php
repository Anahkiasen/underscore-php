<?php
namespace Underscore;

class Dispatch
{
  /**
   * Compute the right class to call according to something's type
   *
   * @param mixed   $subjet The subject of a class
   * @return string Its fully qualified corresponding class
   */
  public static function toClass($subject)
  {
    switch (gettype($subject)) {
      case 'string':
        $class = 'String';
        break;

      case 'array':
        $class = 'Arrays';
        break;

      case 'object':
      case 'resource':
        $class = 'Object';
        break;
    }

    return '\\'.__NAMESPACE__.'\\'.$class;
  }

}
