<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 23:52:24
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 12:59:51
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class ItemHelper extends AbstractHelper
{
	public static function generateItem($itemId, $perfectEffects = false)
	{
		$item = null;
		$itemData = self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\ItemData')
			->findOneById($itemId);

		if ($itemData != null)
		{
			$item = new \Hetwan\Entity\Game\Item;

			$item
				->setItemId($itemId)
				->setTemplateId($itemId)
				->setPosition(-1)
				->setQuantity(1)
				->setEffects(
					ItemEffectHelper::toString(ItemEffectHelper::generateEffectsFromString($itemData->getEffects(), $perfectEffects))
				);
		}

		return $item;
	}

	public static function getPlayerInventory($playerId)
	{
		return self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\Item')
			->findBy([
				'playerId' => $playerId,
				'position' => ItemPositionEnum::INVENTORY
			]);
	}

	public static function getPlayerEquipedItems($playerId)
	{
		return self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\Item')
			->findBy([
				'playerId' => $playerId, 
				'position' => [
					ItemPositionEnum::AMULET,
					ItemPositionEnum::WEAPON,
					ItemPositionEnum::RING_ONE,
					ItemPositionEnum::WAISTBAND,
					ItemPositionEnum::RING_TWO,
					ItemPositionEnum::BOOTS,
					ItemPositionEnum::CAP,
					ItemPositionEnum::MANTLE,
					ItemPositionEnum::ANIMAL,
					ItemPositionEnum::DOFUS_ONE,
					ItemPositionEnum::DOFUS_TWO,
					ItemPositionEnum::DOFUS_THREE,
					ItemPositionEnum::DOFUS_FOUR,
					ItemPositionEnum::DOFUS_FIVE,
					ItemPositionEnum::DOFUS_SIX,
					ItemPositionEnum::SHIELD
				]
			]);
	}
}