<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 18:09:38
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:13:07
 */

namespace Hetwan\Helper;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


class MapDataHelper extends AbstractHelper
{
	public static function addPlayerInMap(int $mapId, $player)
	{
		MapDataLoader::addPlayerInMap($mapId, $player); // Add player to map

		// Add player to all players in map
		\Hetwan\Network\Game\GameServer::sendToAllPlayersInMap(
			$mapId,
			GameMessageFormatter::showActorsMessage([$player]),
			[$player->getId()]
		);

		// Send players in map to current player
		\Hetwan\Network\Game\GameServer::getClientWithPlayer($player->getId())->send(
			GameMessageFormatter::showActorsMessage(\Hetwan\Loader\MapDataLoader::getPlayersInMap($mapId))
		);
	}

	public static function removePlayerInMap(int $mapId, $player)
	{
		MapDataLoader::removePlayerInMap($mapId, $player);

		\Hetwan\Network\Game\GameServer::sendToAllPlayersInMap(
        	$mapId,
        	GameMessageFormatter::removeActorsMessage([$player->getId()])
        );
	}
}