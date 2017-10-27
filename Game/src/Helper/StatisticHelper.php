<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 17:41:21
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 20:00:03
 */

namespace Hetwan\Helper;


class Statistic
{
	private $statisticId,
			$base,
			$bonus,
			$gift, 
			$context;

	public function __construct(string $statisticId, $base = 0, $bonus = 0, $gift = 0, $context = 0)
	{
		$this->statisticId = $statisticId;
		$this->base = $base;
		$this->bonus = $bonus;
		$this->gift = $gift;
		$this->context = $context;
	}

	public function getStatisticId()
	{
		return $this->statisticId;
	}

	public function setBase($base)
	{
		$this->base = $base;

		return $this;
	}

	public function getBase()
	{
		return $this->base;
	}

	public function getBonus()
	{
		return $this->bonus;
	}

	public function getGift()
	{
		return $this->gift;
	}

	public function getContext()
	{
		return $this->context;
	}

	public function getTotal()
	{
		return $this->base + $this->bonus + $this->gift + $this->context; 
	}
}

class StatisticHelper
{
	public static function getPlayerStatistic(string $statisticId, $playerBase = 0, array $equipedItemsBonus = [])
	{
		$playerBonus = 0;

		foreach ($equipedItemsBonus as $effectId => $effectValue)
		{
			if ($effectId == strtoupper('add_' . $statisticId))
				$playerBonus += (int) $effectValue;
			elseif ($effectId == strtoupper('sub_' . $statisticId))
				$playerBonus -= (int) $effectValue;
		}

		return new Statistic($statisticId, $playerBase, $playerBonus);
	}
}