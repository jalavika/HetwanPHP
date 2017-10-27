<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:02:17
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:20:25
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\MapDataHelper;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


class GameHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'C':
				$this->playerLoaded();

				break;
			case 'I':
				$this->playerSpawn();

				break;
			default:
				echo "Unable to handle game action packet: {$data}\n";

				break;
		}
	}

	private function playerLoaded()
	{
		$this->send(GameMessageFormatter::playerLoadedMessage($this->getPlayer()->getName(), true));
		$this->send(GameMessageFormatter::playerStatisticsMessage($this->getPlayer()));
		$this->send(GameMessageFormatter::playerRegenerationIntervalMessage(2000));

		if (($mapData = MapDataLoader::getMapWithId((int) $this->getPlayer()->getMapId())) == null)
			return;

		$this->send(GameMessageFormatter::mapDataMessage(
			$mapData->getId(), 
			$mapData->getDate(),
			$mapData->getKey()
		));
	}

	private function playerSpawn()
	{
		MapDataHelper::addPlayerInMap((int) $this->getPlayer()->getMapId(), $this->getPlayer());

		$this->send(GameMessageFormatter::mapLoadedMessage());
		$this->send(GameMessageFormatter::mapFightCountMessage(0));
	}
}