<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-03 21:35:27
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 21:26:35
 */

namespace Hetwan\Network\Login\Protocol\Formatter;

class LoginMessageFormatter
{
	public static function helloConnectMessage($key)
	{
		return 'HC' . $key;
	}

	public static function wrongClientVersionMessage($requiredVersion)
	{
		return 'AlEv' . $requiredVersion;
	}

	public static function identificationFailedMessage()
	{
		return 'AlEf';
	}

	public static function accountBannedMessage()
	{
		return 'AlEb';
	}

	public static function accountAlreadyConnectedMessage()
	{
		return 'AlEc';
	}

	public static function emptyAccountNickname()
	{
        return 'AlEr';
    }

    public static function notAvailableAccountNickname()
    {
        return 'AlEs';
    }


	public static function identificationSuccessMessage(bool $hasRights)
	{
		return 'AlK' . $hasRights;
	}

	public static function accountNicknameInformationMessage($nickname)
	{
		return 'Ad' . $nickname;
	}

	public static function accountCommunityInformationMessage($community)
	{
		return 'Ac' . $community;
	}

	public static function accountSecretQuestionInformationMessage($secretQuestion)
	{
		return 'AQ' . str_replace(' ', '+', $secretQuestion);
	}

	public static function serversInformationsMessage($servers)
	{
		function buildServerInformationsMessage($server)
		{
			return '{$server->getId()};{$server->getState()};{$server->getPopulation()};{$server->needSubscription()}|';
		}

		$packet = 'AH';

		foreach ($servers as $server)
			$packet .= buildServerInformationsMessage($server);

		return $packet;
	}
}