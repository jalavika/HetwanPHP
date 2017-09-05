<?php

namespace Hetwan\Network\Login;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Hetwan\Model\AccountModel;

class LoginClient
{
	private $container;
	private $handler;
	private $account;
	private $connection;

	/**
	 * @Inject
	 * @param \DI\Container $container
	 */
	public function __construct(ConnectionInterface $conn, \DI\Container $container)
	{
		$this->connection = $conn;
		$this->container = $container;
		$this->key = AccountModel::generateKey(32);

		$this->setHandler('\Hetwan\Network\Login\Handler\AuthentificationHandler', ['client' => $this]);
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setAccount($account)
	{
		$this->account = $account;

		$this->container->get('ClientPool')->addAccount($account->getId(), $account);
	}

	public function send($packet)
	{
		$packet = $packet . chr(0);

		$this->container->get('Logger')->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		return $this->connection->send($packet);
	}

	public function handle($message)
	{
		$this->handler->handle($message);
	}

	public function setHandler($handler, array $parameters = [])
	{
		$this->handler = $this->container->make($handler, $parameters);
	}

	public function getConnection()
	{
		return $this->connection;
	}
}