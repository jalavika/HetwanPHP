<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 00:35:30
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 18:20:13
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


trait ActorBuilderTrait
{
	public static function buildPlayerActorMessage($actor)
	{
		$colors = explode(';', $actor->getConvertedColors());

		return [
			$actor->getName(), 
			$actor->getBreed(), 
			$actor->getSkinId() . '^' . '100', //TODO: actor size
			$actor->getGender(),
			$actor->getFaction(),
			$colors[0],
			$colors[1],
			$colors[2],
			\Hetwan\Helper\PlayerHelper::getPlayerAccessories($actor),
			($actor->getLevel() >= 100) ? ($actor->getLevel() >= 200) ? 200 : 100  : 0,
			null, //TODO: emotes
			null, //TODO: emotes timer
			null, //TODO: guild name
			null, //TODO: guild emblem
			0,
			null, // TODO: speed restrictions
			null // TODO: mount
		];
	}
}

class GameMessageFormatter
{
	use ActorBuilderTrait;

	public static function queueMessage($position, $subscribers, $nonSubscribers, $isSubscriber, $queuId = 1)
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . $isSubscriber . '|' . $queuId;
	}

	public static function playerLoadedMessage($playerName, $succeed = true)
	{
		return 'GCK|' . (int) $succeed . '|' . $playerName;
	}

	public static function playerRegenerationIntervalMessage($interval)
	{
		return 'ILS' . $interval;
	}

	public static function mapFightCountMessage($fights)
	{
		return 'fC' . (int) $fights;
	}

	public static function playerStatisticsMessage($player)
	{
		$experience = \Hetwan\Helper\ExperienceDataHelper::getExperience($player->getLevel());

		$packet = [
			'As' . implode(',', [$player->getExperience(), $experience[0]['player'], $experience[1]['player']]),
			$player->getKamas(), 
			$player->getPointsOfCharacteristics(), 
			$player->getSpellPoints(), 
			$player->getFaction(),
			$player->getTotalLifePoints() . ',' . $player->getTotalMaximumLifePoints(),
			$player->getEnergy() . ',' . 10000,
			$player->getPlayerStatistics()['INITIATIVE']->getTotal(),
			$player->getPlayerStatistics()['PROSPECTION']->getTotal(),
			implode(',', [$player->getPlayerStatistics()['AP']->getBase(), $player->getPlayerStatistics()['AP']->getBonus(), $player->getPlayerStatistics()['AP']->getGift(), $player->getPlayerStatistics()['AP']->getContext(), $player->getPlayerStatistics()['AP']->getTotal()]),
			implode(',', [$player->getPlayerStatistics()['MP']->getBase(), $player->getPlayerStatistics()['MP']->getBonus(), $player->getPlayerStatistics()['MP']->getGift(), $player->getPlayerStatistics()['MP']->getContext(), $player->getPlayerStatistics()['MP']->getTotal()]),
			implode(',', [$player->getPlayerStatistics()['STRENGTH']->getBase(), $player->getPlayerStatistics()['STRENGTH']->getBonus(), $player->getPlayerStatistics()['STRENGTH']->getGift(), $player->getPlayerStatistics()['STRENGTH']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['VITALITY']->getBase(), $player->getPlayerStatistics()['VITALITY']->getBonus(), $player->getPlayerStatistics()['VITALITY']->getGift(), $player->getPlayerStatistics()['VITALITY']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['WISDOM']->getBase(), $player->getPlayerStatistics()['WISDOM']->getBonus(), $player->getPlayerStatistics()['WISDOM']->getGift(), $player->getPlayerStatistics()['WISDOM']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['CHANCE']->getBase(), $player->getPlayerStatistics()['CHANCE']->getBonus(), $player->getPlayerStatistics()['CHANCE']->getGift(), $player->getPlayerStatistics()['CHANCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['AGILITY']->getBase(), $player->getPlayerStatistics()['AGILITY']->getBonus(), $player->getPlayerStatistics()['AGILITY']->getGift(), $player->getPlayerStatistics()['AGILITY']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['INTELLIGENCE']->getBase(), $player->getPlayerStatistics()['INTELLIGENCE']->getBonus(), $player->getPlayerStatistics()['INTELLIGENCE']->getGift(), $player->getPlayerStatistics()['INTELLIGENCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['SP']->getBase(), $player->getPlayerStatistics()['SP']->getBonus(), $player->getPlayerStatistics()['SP']->getGift(), $player->getPlayerStatistics()['SP']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['INVOCATION']->getBase(), $player->getPlayerStatistics()['INVOCATION']->getBonus(), $player->getPlayerStatistics()['INVOCATION']->getGift(), $player->getPlayerStatistics()['INVOCATION']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['DAMAGE']->getBase(), $player->getPlayerStatistics()['DAMAGE']->getBonus(), $player->getPlayerStatistics()['DAMAGE']->getGift(), $player->getPlayerStatistics()['DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PHYSICAL_DAMAGE']->getBase(), $player->getPlayerStatistics()['PHYSICAL_DAMAGE']->getBonus(), $player->getPlayerStatistics()['PHYSICAL_DAMAGE']->getGift(), $player->getPlayerStatistics()['PHYSICAL_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['MAGICAL_DAMAGE']->getBase(), $player->getPlayerStatistics()['MAGICAL_DAMAGE']->getBonus(), $player->getPlayerStatistics()['MAGICAL_DAMAGE']->getGift(), $player->getPlayerStatistics()['PHYSICAL_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PERCENT_DAMAGE']->getBase(), $player->getPlayerStatistics()['PERCENT_DAMAGE']->getBonus(), $player->getPlayerStatistics()['PERCENT_DAMAGE']->getGift(), $player->getPlayerStatistics()['PERCENT_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['TRAP_DAMAGE']->getBase(), $player->getPlayerStatistics()['TRAP_DAMAGE']->getBonus(), $player->getPlayerStatistics()['TRAP_DAMAGE']->getGift(), $player->getPlayerStatistics()['TRAP_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['TRAP_PERCENT_DAMAGE']->getBase(), $player->getPlayerStatistics()['TRAP_PERCENT_DAMAGE']->getBonus(), $player->getPlayerStatistics()['TRAP_PERCENT_DAMAGE']->getGift(), $player->getPlayerStatistics()['TRAP_PERCENT_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['HEAL']->getBase(), $player->getPlayerStatistics()['HEAL']->getBonus(), $player->getPlayerStatistics()['HEAL']->getGift(), $player->getPlayerStatistics()['HEAL']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['RETURN_DAMAGE']->getBase(), $player->getPlayerStatistics()['RETURN_DAMAGE']->getBonus(), $player->getPlayerStatistics()['RETURN_DAMAGE']->getGift(), $player->getPlayerStatistics()['RETURN_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['CRITICAL_DAMAGE']->getBase(), $player->getPlayerStatistics()['CRITICAL_DAMAGE']->getBonus(), $player->getPlayerStatistics()['CRITICAL_DAMAGE']->getGift(), $player->getPlayerStatistics()['CRITICAL_DAMAGE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['CRITICAL_FAILURE']->getBase(), $player->getPlayerStatistics()['CRITICAL_FAILURE']->getBonus(), $player->getPlayerStatistics()['CRITICAL_FAILURE']->getGift(), $player->getPlayerStatistics()['CRITICAL_FAILURE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['DODGE_AP']->getBase(), $player->getPlayerStatistics()['DODGE_AP']->getBonus(), $player->getPlayerStatistics()['DODGE_AP']->getGift(), $player->getPlayerStatistics()['DODGE_AP']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['DODGE_MP']->getBase(), $player->getPlayerStatistics()['DODGE_MP']->getBonus(), $player->getPlayerStatistics()['DODGE_MP']->getGift(), $player->getPlayerStatistics()['DODGE_MP']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['NEUTRAL_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['NEUTRAL_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['NEUTRAL_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['NEUTRAL_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['NEUTRAL_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['NEUTRAL_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['NEUTRAL_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['NEUTRAL_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['EARTH_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['EARTH_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['EARTH_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['EARTH_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['EARTH_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['EARTH_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['EARTH_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['EARTH_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['FIRE_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['FIRE_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['FIRE_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['FIRE_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['FIRE_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['FIRE_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['FIRE_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['FIRE_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['WATER_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['WATER_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['WATER_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['WATER_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['WATER_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['WATER_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['WATER_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['WATER_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['AIR_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['AIR_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['AIR_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['AIR_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['AIR_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['AIR_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['AIR_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['AIR_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_NEUTRAL_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_NEUTRAL_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_NEUTRAL_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_NEUTRAL_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_EARTH_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_EARTH_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_EARTH_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_EARTH_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_EARTH_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_EARTH_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_EARTH_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_EARTH_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_FIRE_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_FIRE_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_FIRE_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_FIRE_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_FIRE_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_FIRE_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_FIRE_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_FIRE_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_WATER_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_WATER_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_WATER_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_WATER_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_WATER_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_WATER_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_WATER_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_WATER_PERCENT_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_AIR_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_AIR_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_AIR_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_AIR_DAMAGE_REDUCE']->getContext()]),
			implode(',', [$player->getPlayerStatistics()['PVP_AIR_PERCENT_DAMAGE_REDUCE']->getBase(), $player->getPlayerStatistics()['PVP_AIR_PERCENT_DAMAGE_REDUCE']->getBonus(), $player->getPlayerStatistics()['PVP_AIR_PERCENT_DAMAGE_REDUCE']->getGift(), $player->getPlayerStatistics()['PVP_AIR_PERCENT_DAMAGE_REDUCE']->getContext()]),
		];

		return implode('|', $packet);
	}

	public static function mapDataMessage($id, $date, $key)
	{
		return 'GDM|' . $id . '|' . $date . '|' . $key;
	}

	public static function mapLoadedMessage()
	{
		return 'GDK';
	}

	public static function showActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actor)
			$packet[] = '|+' . implode(';', array_merge([$actor->getCellId(), $actor->getOrientation(), 0, $actor->getId()], self::buildPlayerActorMessage($actor)));

		return implode('', $packet);
	}

	public static function updateActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actor)
			$packet[] = '|~' . implode(';', array_merge([$actor->getCellId(), $actor->getOrientation(), 0, $actor->getId()], self::buildPlayerActorMessage($actor)));

		return implode('', $packet);
	}

	public static function removeActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actorId)
			$packet[] = '|-' . $actorId;

		return implode('', $packet);
	}
}