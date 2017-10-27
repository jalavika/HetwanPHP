<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:16:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 22:12:09
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Model\AccountModel;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\LoginServer;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class AuthentificationHandler extends AbstractLoginHandler
{
	public function handle($packet)
	{
		if (strpos($packet, '#1') != true)
		{
			$this->send(LoginMessageFormatter::badPacketMessage());

			return HandlerInterface::FAILED;
		}

		$credentials = explode('#', $packet);

		$account = $this->getEntityManager()
						->getRepository('\Hetwan\Entity\Account')
						->findOneByUsername($credentials[0])
						->refresh();

		if (!$account || \Hetwan\Util\Cryptography::encryptValue($account->getPassword(), $this->getClient()->key) != $credentials[1])
			$this->send(LoginMessageFormatter::identificationFailedMessage());
		elseif (null != ($ban = $account->getIsBanned()))
			$this->send(LoginMessageFormatter::accountBannedMessage($ban->getEndDate()));
		elseif (null != LoginServer::getClientWithAccount($account->getId()))
			$this->send(LoginMessageFormatter::accountAlreadyConnectedMessage());
		elseif (true == $account->getIsOnline())
		{
			foreach (\Hetwan\Network\Exchange\ExchangeServer::getClientsPool() as $server)
				$server->send(ExchangeMessageFormatter::accountDisconnectMessage($account->getId()));

			$this->send(LoginMessageFormatter::accountAlreadyConnectedOnGameServerMessage());
		}
		else
		{
			$this->getClient()->setAccount($account);

			if ($account->getNickname() == null)
				$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\NicknameChoiceHandler');
			else
				$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\GameServerChoiceHandler');

			return HandlerInterface::COMPLETED;
		}

		return HandlerInterface::FAILED;
	}
}