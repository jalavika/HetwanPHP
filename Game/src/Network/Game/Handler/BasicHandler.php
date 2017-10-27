<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:18:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 21:55:51
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Helper\MapDataHelper;

use Hetwan\Network\Game\Protocol\Formatter\BasicMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


class BasicHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'a':
				$this->mapAdminTeleport($data);

				break;
			case 'D':
				$this->currentServerDate();

				break;
			default:
				echo "Unable to handle basic action packet: {$data}\n";

				break;
		}
	}

	private function mapAdminTeleport(string $data)
	{
		$mapPosition = explode(',', substr($data, 2));

		if (($mapData = MapDataLoader::getMapWithPosition((int) $mapPosition[0], (int) $mapPosition[1])) == null)
			return;

		$this->send(GameMessageFormatter::mapDataMessage(
			$mapData->getId(), 
			$mapData->getDate(),
			$mapData->getKey()
		));

		MapDataHelper::removePlayerInMap((int) $this->getPlayer()->getMapId(), $this->getPlayer());

		$this->getPlayer()->setMapId($mapData->getId());
	}

	private function currentServerDate()
	{
		$this->send(BasicMessageFormatter::currentDateMessage());
	}
}