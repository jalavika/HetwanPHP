<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:17:42
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-05 21:05:35
 */

namespace Hetwan\Network\Handler;

use Hetwan\Network\Handler\HandlerInterface;


abstract class AbstractHandler implements HandlerInterface
{
	/**
	 * @Inject
	 * @var \DI\Container
	 */
	protected $container;

	/**
	 * @var \Hetwan\Network\Login\LoginClient
	 */
	protected $client;

	protected $actions = [];

	public function __construct(\Hetwan\Network\Login\LoginClient $client)
	{
		$this->client = $client;
	}

	public function executeAction($data)
	{
		foreach ($this->actions as $actionClass => $state)
		{
			if ($state == HandlerInterface::UNEXECUTED || $state == HandlerInterface::CONTINUE)
			{
				if (true == $actionClass::$waiting && null == $data)
					break;

				$action = new $actionClass($this);

				if (true == $action->condition())
					$state = $this->actions[$actionClass] = $action->execute($data);

				if ($state == HandlerInterface::EXECUTED)
					$data = null;
				elseif ($state == HandlerInterface::FAILED)
					break;
			}
		}
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function getLogger()
	{
		return $this->getContainer()->get('Logger');
	}

	public function getClient()
	{
		return $this->client;
	}
}