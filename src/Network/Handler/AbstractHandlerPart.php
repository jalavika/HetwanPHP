<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 13:50:51
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 21:57:18
 */

namespace Hetwan\Network\Handler;

use Hetwan\Network\Handler\HandlerPartInterface;


abstract class AbstractHandlerPart implements HandlerPartInterface
{
	/**
	 * @var \Hetwan\Network\Login\LoginClient
	 */
	protected $handler;

	public static $waiting = true;

	public function __construct(\Hetwan\Network\Handler\HandlerInterface $handler)
	{
		$this->handler = $handler;
	}

	public function condition()
	{
		return true;
	}

	protected function getHandler()
	{
		return $this->handler;
	}

	protected function getClient()
	{
		return $this->handler->getClient();
	}

	protected function getAccount()
	{
		return $this->handler->getClient()->getAccount();
	}

	protected function getEntityManager()
	{
		return $this->handler->getContainer()->get('Database')->getEntityManager();
	}
}