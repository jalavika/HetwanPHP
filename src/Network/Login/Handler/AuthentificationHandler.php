<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:16:59
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 22:08:58
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Model\AccountModel;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Handler\AbstractHandler;
use Hetwan\Network\Handler\AbstractHandlerPart;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


class VersionVerification extends AbstractHandlerPart
{
	public function execute($version)
	{
		$sameVersion = ($goodVersion = $this->getHandler()->getContainer()->get('Configuration')->get('dofus.version')) == $version;

		if (false == $sameVersion)
			$this->getClient()->send(LoginMessageFormatter::wrongClientVersionMessage($goodVersion));

		return HandlerInterface::EXECUTED;
	}
}

class AccountVerification extends AbstractHandlerPart
{
	public static $waiting = true;

	public function execute($packet)
	{
		$credentials = explode('#', $packet);

		try
		{
			$accountQuery = $this->getEntityManager()->createQuery('SELECT a from \Hetwan\Entity\Account a WHERE a.username = ?1');
			$accountQuery->setParameter(1, $credentials[0]);
			$account = $accountQuery->getSingleResult();
		}
		catch (\Doctrine\ORM\NoResultException $e)
		{
			$account = null;
		}

		if (!$account || AccountModel::cryptPassword($account->getPassword(), $this->getClient()->key) != $credentials[1])
			$this->getClient()->send(LoginMessageFormatter::identificationFailedMessage());
		elseif (true == $account->getIsBanned())
			$this->getClient()->send(LoginMessageFormatter::accountBannedMessage());
		else if ($this->getHandler()->getContainer()->get('ClientPool')->hasAccount($account->getId()))
		{
			$this->getClient()->send(LoginMessageFormatter::accountAlreadyConnectedMessage());

			if (null != ($client = $this->getHandler()->getContainer()->get('ClientPool')->getClientWithAccount($account->getId())))
				$client->getConnection()->close();
		}
		else
		{
			$this->getClient()->setAccount($account);

			return HandlerInterface::EXECUTED;
		}

		return HandlerInterface::FAILED;
	}
}

class NicknameChoice extends AbstractHandlerPart
{
	public static $waiting = false;

	public function condition()
	{
		var_dump($this->getClient()->getAccount()->getNickname());
		return $this->getClient()->getAccount()->getNickname() == null;
	}

	public function execute($nickname = null)
	{
		if (null == $nickname)
		{
			$this->getClient()->send(LoginMessageFormatter::emptyAccountNickname());

			return HandlerInterface::CONTINUE;
		}
		else
		{
			try
			{
				$nicknameQuery = $this->getEntityManager()->createQuery('SELECT a from \Hetwan\Entity\Account a WHERE a.nickname = ?1');
				$nicknameQuery->setParameter(1, $nickname);
				$nicknameQuery->getSingleScalarResult();
			}
			catch (\Doctrine\ORM\NonUniqueResultException $e)
			{
				$nicknameAlreadyExist = true;
			}
			catch (\Doctrine\ORM\NoResultException $e)
			{
				$nicknameAlreadyExist = false;
			}

			if (false != $nicknameAlreadyExist)
			{
				$this->getClient()->send(LoginMessageFormatter::notAvailableAccountNickname());

				return HandlerInterface::CONTINUE;
			}
			else
			{
				$this->getClient()->getAccount()->setNickname($nickname);
				$this->getEntityManager()->persist($this->handler->getClient()->getAccount());
				$this->getEntityManager()->flush();

				return HandlerInterface::EXECUTED;
			}
		}
	}
}

class AuthentificationHandler extends AbstractHandler
{
	protected $actions = [
		VersionVerification::class => HandlerInterface::UNEXECUTED,
		AccountVerification::class => HandlerInterface::UNEXECUTED,
		NicknameChoice::class => HandlerInterface::UNEXECUTED,
	];

	public function __construct(\Hetwan\Network\Login\LoginClient $client)
	{
		$this->client = $client;

		$this->client->send(LoginMessageFormatter::helloConnectMessage($client->key));
	}

	public function handle($packet)
	{
		$this->executeAction($packet);
	}
}