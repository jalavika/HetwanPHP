<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 10:40:11
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 12:43:52
 */

namespace Hetwan\Core;

use React\EventLoop\Factory as LoopFactory;
use React\Socket\Connector;

use Ratchet\Server\IoServer;


class Core
{
	/**
	 * @var \React\EventLoop\Factory
	 */
	protected static $loop;

	public function __construct()
	{
		self::$loop = LoopFactory::create();

		// Load static data
		\App\AppKernel::getContainer()->get('database')->load();

		new \Hetwan\Data\Breed\BreedData; // TODO: datacenter
	}

	public function makeGameServer()
	{
		$uri = [
			'address' => \App\AppKernel::getContainer()->get('configuration')->get('network.game.ip'),
			'port' => \App\AppKernel::getContainer()->get('configuration')->get('network.game.port')
		];

		IoServer::factory(
			\App\AppKernel::getContainer()->make('Hetwan\Network\Game\GameServer'),
			$uri['address'] . ':' . $uri['port'],
			self::$loop
		);
	}

	public function makeExchangeClient()
	{
		$uri = [
			'address' => \App\AppKernel::getContainer()->get('configuration')->get('network.exchange.ip'),
			'port' => \App\AppKernel::getContainer()->get('configuration')->get('network.exchange.port')
		];

		$exchangeClient = new Connector(self::$loop, ['timeout' => 5.00, 'dns' => false]);
		$exchangeClient->connect($uri['address'] . ':' . $uri['port'])->then(
			function (\React\Socket\ConnectionInterface $connection) {
				\App\AppKernel::getContainer()->get('logger')->debug("Exchange client started\n");

				new \Hetwan\Network\Exchange\ExchangeClient($connection);
			},
			function (\Exception $exception) {
        		\App\AppKernel::getContainer()->get('logger')->error("Unable to start exchange client !\n");

        		self::$loop->stop();
			}
		);
	}

	public function run()
	{
		self::$loop->run();
	}

	public static function getLoop()
	{
		return self::$loop;
	}
}