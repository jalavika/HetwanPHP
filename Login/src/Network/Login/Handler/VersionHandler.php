<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:03:54
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-20 13:39:18
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class VersionHandler extends AbstractLoginHandler
{
	public function initialize()
	{
		$this->send(LoginMessageFormatter::helloConnectMessage($this->getClient()->key));
	}

	public function handle($version)
	{
		$sameVersion = ($goodVersion = $this->getContainer()->get('configuration')->get('dofus.version')) == $version;

		if (false == $sameVersion)
		{
			$this->send(LoginMessageFormatter::badClientVersionMessage($goodVersion));

			return HandlerInterface::FAILED;
		}

		$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\AuthentificationHandler');
	}
}