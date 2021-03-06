<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 15:32:49
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 16:49:51
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ChannelMessageFormatter
{
    public static function addChannelsMessage($channels)
    {
    	$packet = ['cC+'];

    	if ($channels != null)
    		foreach ($channels as $channel)
    			$packet[] = $channel;

    	return implode('', $packet);
    }

    public static function enabledEmotesMessage($emotes = '', $suffix = 0)
    {
        return 'eL' . $emotes . '|' . $suffix;
    }
}