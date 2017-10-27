<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 21:55:00
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 21:56:13
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class BasicMessageFormatter
{
	public static function currentDateMessage()
	{
		$currentDate = new \DateTime('NOW');

		return 'BD' . $currentDate->format('Y|m|d');
	}
}