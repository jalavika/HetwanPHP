<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 18:26:50
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 17:41:08
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ApproachMessageFormatter
{
	public static function helloGameMessage()
	{
		return 'HG';
	}

	public static function regionalVersionResponseMessage($community)
	{
		return 'AV' . $community;
	}

	public static function playerSelectionMessage($player)
	{
		$itemFormatter = function ($item)
		{
			$convertedTemplateId = dechex($item->getTemplateId());

			return "{$item->getId()}~{$convertedTemplateId}~{$item->getQuantity()}~{$item->getPosition()}~{$item->getEffects()}";
		};

		$packet = [
			'ASK',
			$player->getId(),
			$player->getName(),
			$player->getLevel(),
			$player->getFaction(),
			$player->getGender(),
			$player->getSkinId(),
			preg_replace('/;/', '|', $player->getColors())
		];

		$itemsPacket = [];

		foreach (array_merge($player->getInventory(), $player->getEquipedItems()) as $item)
			$itemsPacket[] = $itemFormatter($item);

		return implode('|', $packet) . '|' . implode(';', $itemsPacket);
	}
}