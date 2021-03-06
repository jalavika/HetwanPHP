<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 00:03:30
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 01:39:17
 */

namespace Hetwan\Network\Game\Protocol\Enum;


abstract class AbstractEnum
{
    protected static $constCacheArray = null;

    protected static function getConstants()
    {
        if (self::$constCacheArray ==  null)
            self::$constCacheArray = [];

        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) 
        {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict)
            return array_key_exists($name, $constants);

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict);
    }

    public static function fromString($name)
    {
        if (self::isValidName($name, $strict = true))
        {
            $constants = self::getConstants();

            return $constants[$name];
        }

        return false;
    }

    public static function toString($value, $strict = true)
    {
        if (self::isValidValue($value, $strict))
            return array_search($value, self::getConstants());

        return false;
    }
}