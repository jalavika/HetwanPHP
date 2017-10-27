<?php

/**
 * @Author: jean
 * @Date:   2017-09-09 23:17:22
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:30:14
 */

namespace Hetwan\Network\Exchange\Protocol\Formatter;


class ExchangeMessageFormatter
{
	public static function helloConnectMessage() 
	{
		return 'HC';
	}

	public static function authentificationValidatedMessage()
	{
		return 'Av';
	}

	public static function authentificationFailedMessage()
	{
		return 'Af';
	}

	public static function accountTicketMessage($ticketKey, $ipAddress, $accountId)
	{
		return 'T' . $ticketKey . '|' . $ipAddress . '|' . $accountId;
	}

	public static function accountDisconnectMessage($accountId)
	{
		return 'Ad' . $accountId;
	}
}