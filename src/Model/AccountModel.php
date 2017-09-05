<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 21:29:02
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 22:12:26
 */

namespace Hetwan\Model;

class AccountModel
{
	public static $hashKey = [
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
     	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '-', '_'
    ];

	public static function generateKey($size = 64) 
	{
    	$key = '';
    	$hashKeySize = count(self::$hashKey);

    	if ($size > $hashKeySize)
    		$size = $hashKeySize;

    	for ($i = 1; $i <= $size; $i++)
    		$key .= self::$hashKey[rand(0, $hashKeySize - 1)];

    	return $key;
	}

	public static function cryptPassword($password, $key)
	{
		$key = str_split($key);
		$splittedPasswd = str_split($password);
		$cryptedPasswd = '1';

		for ($i = 0; $i < strlen($password); $i++)
		{
			$pKeys = [ord($splittedPasswd[$i]), ord($key[$i])];
			$hKeys = [$pKeys[0] / 16, $pKeys[0] % 16];
			$cryptedPasswd .= self::$hashKey[($hKeys[0] + $pKeys[1]) % count(self::$hashKey)] . self::$hashKey[($hKeys[1] + $pKeys[1]) % count(self::$hashKey)];
		}

		return $cryptedPasswd;
	}
}