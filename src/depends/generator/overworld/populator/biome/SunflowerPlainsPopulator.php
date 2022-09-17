<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\overworld\populator\biome;

use pocketmine\depends\generator\overworld\biome\BiomeIds;
use pocketmine\depends\generator\overworld\decorator\types\DoublePlantDecoration;
use pocketmine\block\VanillaBlocks;

class SunflowerPlainsPopulator extends PlainsPopulator{

	/** @var DoublePlantDecoration[] */
	private static array $DOUBLE_PLANTS;

	public static function init() : void{
		parent::init();
		self::$DOUBLE_PLANTS = [
			new DoublePlantDecoration(VanillaBlocks::SUNFLOWER(), 1)
		];
	}

	protected function initPopulators() : void{
		$this->double_plant_decorator->setAmount(10);
		$this->double_plant_decorator->setDoublePlants(...self::$DOUBLE_PLANTS);
	}

	public function getBiomes() : ?array{
		return [BiomeIds::SUNFLOWER_PLAINS];
	}
}

SunflowerPlainsPopulator::init();