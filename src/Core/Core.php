<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 10:40:11
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-09-04 18:38:04
 */

namespace Hetwan\Core;

use Ratchet\Server\IoServer;

class Core
{
	private $app;
	private $server;

	public function __construct($app)
	{
		$this->app = $app;

		$this->server = IoServer::factory(
			$this->app->getContainer()->make('Hetwan\Network\Login\LoginServer'), 
			$this->app->getContainer()->get('Configuration')->get('network.login.port'), 
			$this->app->getContainer()->get('Configuration')->get('network.login.ip')
		);

		$this->app->getContainer()->get('Database')->create(
			$this->app->getRootDir().'/src/Entity'
		);
	}

	public function run()
	{
		$this->server->run();
	}
}