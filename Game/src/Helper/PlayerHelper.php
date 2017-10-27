<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:48:16
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 21:40:49
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


trait NameGeneratorTrait
{
    public static function generate()
   	{
   		static $beginning = [
	    	'Kr', 'Ca', 'Ra', 'Mrok', 'Cru',
	        'Ray', 'Bre', 'Zed', 'Drak', 'Mor', 'Jag', 'Mer', 'Jar', 'Mjol',
	        'Zork', 'Mad', 'Cry', 'Zur', 'Creo', 'Azak', 'Azur', 'Rei', 'Cro',
	        'Mar', 'Luk'
	    ];

	    static $middle = [
	    	'air', 'ir', 'mi', 'sor', 'mee', 'clo',
	        'red', 'cra', 'ark', 'arc', 'miri', 'lori', 'cres', 'mur', 'zer',
	        'marac', 'zoir', 'slamar', 'salmar', 'urak'
	    ];
	    
	    static $ending = [
	    	'd', 'ed', 'ark', 'arc', 'es', 'er', 'der',
	        'tron', 'med', 'ure', 'zur', 'cred', 'mur'
	    ];

		return $beginning[rand(0, count($beginning) - 1)] . $middle[rand(0, count($middle) - 1)] . $ending[rand(0, count($ending) - 1)];
    }
}

class PlayerHelper extends AbstractHelper
{
	public static function generatePlayerName()
	{
		return NameGeneratorTrait::generate();
	}

	public static function createPlayer($name, $breed, $gender, $colors, $serverId)
	{
		$player = new \Hetwan\Entity\Login\Player();
		$breedData = \Hetwan\Data\Breed\BreedData::getBreedFromId((int) $breed);

		$player->setName($name)
		 	   ->setBreed($breed)
			   ->setGender($gender)
			   ->setColors($colors[0] . ';' . $colors[1] . ';' . $colors[2])
			   ->setLifePoints($breedData['startLifePoints'])
			   ->setMaximumLifePoints($player->getLifePoints())
			   ->setActionPoints($breedData['startActionPoints'])
			   ->setMovementPoints($breedData['startMovementPoints'])
			   ->setLevel(1)
			   ->setExperience(0)
			   ->setSkinId($breed . $gender)
			   ->setFaction(0)
			   ->setFactionHonorPoints(-1)
			   ->setFactionDishonorPoints(-1)
			   ->setServerId($serverId);

		return $player;
	}

	public static function getPlayerAccessories(\Hetwan\Entity\Login\Player $player)
	{
		$accessories = [
			ItemPositionEnum::CAP => null,
			ItemPositionEnum::MANTLE => null,
			ItemPositionEnum::ANIMAL => null,
			ItemPositionEnum::SHIELD => null
		];

		foreach ($player->getEquipedItems() as $accessory)
			if (array_key_exists($accessory->getPosition(), $accessories))
				$accessories[$accessory->getPosition()] = dechex($accessory->getTemplateId());

		return ',' . implode(',', $accessories);
	}

	public static function getPlayerStatistics($player)
	{
		$breedData = \Hetwan\Data\Breed\BreedData::getBreedFromId((int) $player->getBreed());
		$playerStatistics = [
			'AP' => $player->getActionPoints(),
			'MP' => $player->getMovementPoints(),
			'SP' => 0,
			'INITIATIVE' => 0,
			'PROSPECTION' =>  ($player->getBaseChance() + $player->getChance()) / 10,
			'STRENGTH' => $player->getBaseStrength() + $player->getStrength(),
			'VITALITY' => $player->getBaseVitality() + $player->getVitality(),
			'WISDOM' => $player->getBaseWisdom() + $player->getWisdom(),
			'INTELLIGENCE' => $player->getBaseIntelligence() + $player->getIntelligence(),
			'CHANCE' => $player->getBaseChance() + $player->getChance(),
			'AGILITY' => $player->getBaseAgility() + $player->getAgility(),
			'INVOCATION' => 1,
			'DAMAGE' => 0,
			'PERCENT_DAMAGE' => 0,
			'PHYSICAL_DAMAGE' => 0,
			'MAGICAL_DAMAGE' => 0,
			'TRAP_DAMAGE' => 0,
			'TRAP_PERCENT_DAMAGE' => 0,
			'HEAL' => 0,
			'RETURN_DAMAGE' => 0,
			'CRITICAL_DAMAGE' => 0,
			'CRITICAL_FAILURE' => 0,
			'DODGE_AP' => 0,
			'DODGE_MP' => 0,
			'NEUTRAL_DAMAGE_REDUCE' => 0,
			'NEUTRAL_PERCENT_DAMAGE_REDUCE' => 0,
			'EARTH_DAMAGE_REDUCE' => 0,
			'EARTH_PERCENT_DAMAGE_REDUCE' => 0,
			'FIRE_DAMAGE_REDUCE' => 0,
			'FIRE_PERCENT_DAMAGE_REDUCE' => 0,
			'WATER_DAMAGE_REDUCE' => 0,
			'WATER_PERCENT_DAMAGE_REDUCE' => 0,
			'AIR_DAMAGE_REDUCE' => 0,
			'AIR_PERCENT_DAMAGE_REDUCE' => 0,
			'PVP_NEUTRAL_DAMAGE_REDUCE' => 0,
			'PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE' => 0,
			'PVP_EARTH_DAMAGE_REDUCE' => 0,
			'PVP_EARTH_PERCENT_DAMAGE_REDUCE' => 0,
			'PVP_FIRE_DAMAGE_REDUCE' => 0,
			'PVP_FIRE_PERCENT_DAMAGE_REDUCE' => 0,
			'PVP_WATER_DAMAGE_REDUCE' => 0,
			'PVP_WATER_PERCENT_DAMAGE_REDUCE' => 0,
			'PVP_AIR_DAMAGE_REDUCE' => 0,
			'PVP_AIR_PERCENT_DAMAGE_REDUCE' => 0,
		];

		foreach ($playerStatistics as $statisticId => $base)
			$playerStatistics[$statisticId] = StatisticHelper::getPlayerStatistic($statisticId, $base, $player->getEquipedItemsBonus());

		$playerStatistics['INITIATIVE']->setBase($playerStatistics['INITIATIVE']->getBase() + (($playerStatistics['CHANCE']->getBase() + $playerStatistics['INTELLIGENCE']->getBase() + $playerStatistics['STRENGTH']->getBase() + $playerStatistics['AGILITY']->getBase()) * ($player->getLifePoints() / $player->getMaximumLifePoints())));

		return $playerStatistics;
	}
}