<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 15:35:32
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 16:22:42
 */

namespace Hetwan\Data\Breed;

use Hetwan\Network\Game\Protocol\Enum\ItemEffectEnum;


class BreedData
{
	private static $breeds = [];

	public function __construct()
	{
		$directory = realpath(dirname(__FILE__));

		foreach (scandir($directory) as $breedFile)
		{
			if (pathinfo($breedFile)['extension'] != 'xml')
				continue;

			$this->parse($directory . '/' . $breedFile);
		}
	}

	private function parse($breedFile)
	{
		$breed = ['name' => substr(basename($breedFile), 0, -4)];

		$XMLReader = new \XMLReader();
		$XMLReader->open($breedFile);

		while ($XMLReader->read())
		{
			static $lastStatisticId = null;

			if ($XMLReader->nodeType == \XMLReader::ELEMENT)
				switch ($XMLReader->name)
				{
					case 'breed':
						$breed['id'] = $XMLReader->getAttribute('id');
						$breed['startActionPoints'] = $XMLReader->getAttribute('startActionPoints');
						$breed['startMovementPoints'] = $XMLReader->getAttribute('startMovementPoints');
						$breed['startLifePoints'] = $XMLReader->getAttribute('startLife');
						$breed['startProspection'] = $XMLReader->getAttribute('startProspection');

						break;
					case 'levels':
						$lastStatisticId = $statisticId = ItemEffectEnum::fromString(strtoupper('add_' . $XMLReader->getAttribute('type')));
						
						if (!isset($breed['statistics']))
							$breed['statistics'] = [$statisticId => []];
						else
							$breed['statistics'][$statisticId] = [];

						break;
					case 'level':
						$statisticRange = [
							'range' => explode('..', $XMLReader->getAttribute('range')),
							'bonus' => $XMLReader->getAttribute('bonus'),
							'cost' => $XMLReader->getAttribute('cost')
						];

						$breed['statistics'][$lastStatisticId][] = $statisticRange;

						break;
				}
		}

		$XMLReader->close();

		self::$breeds[$breed['id']] = $breed;
	}

	public static function getBreedFromId(int $breedId)
	{
		if (isset(self::$breeds[$breedId]))
			return self::$breeds[$breedId];

		return null;
	}

	public static function getBreedFromName($breedName)
	{
		foreach (self::$breeds as $breed)
			if ($breed['name'] == $breedName)
				return $breed;

		return null;
	}
}