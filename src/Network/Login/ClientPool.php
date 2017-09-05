<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 22:06:08
 */

namespace Hetwan\Network\Login;

class ClientPool
{
	protected $accounts = [];

	protected $clients = [];

	public function addAccount($key, $account)
	{
		$this->accounts[$key] = $account;
	}

	public function hasAccount($key)
	{
		return isset($this->accounts[$key]);
	}

	public function getAccounts()
	{
		return $this->accounts;
	}

	public function removeAccount($key)
	{
		unset($this->accounts[$key]);
	}

	public function addClient($key, $client)
	{
		$this->clients[$key] = $client;
	}

	public function getClient($key)
	{
		return $this->clients[$key];
	}

	public function getClientWithAccount($key)
	{
		foreach ($this->clients as $client)
		{
			if (null != ($account = $client->getAccount()) && $account->getId() == $key)
				return $client;
		}

		return null;
	}

	public function getClients()
	{
		return $this->clients;
	}

	public function removeClient($key)
	{
		unset($this->clients[$key]);
	}
}