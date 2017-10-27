<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:10:11
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 23:11:40
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ItemMessageFormatter
{
	public static function inventoryStatsMessage($pods, $maxPods)
	{
		return 'Ow' . $pods . '|' . $maxPods;
	}
}