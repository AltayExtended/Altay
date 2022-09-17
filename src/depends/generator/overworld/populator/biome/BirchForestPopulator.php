<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\overworld\populator\biome;

use pocketmine\depends\generator\object\tree\BirchTree;
use pocketmine\depends\generator\overworld\biome\BiomeIds;
use pocketmine\depends\generator\overworld\decorator\types\TreeDecoration;

class BirchForestPopulator extends ForestPopulator{

	private const BIOMES = [BiomeIds::BIRCH_FOREST, BiomeIds::BIRCH_FOREST_HILLS];

	/** @var TreeDecoration[] */
	protected static array $TREES;

	protected static function initTrees() : void{
		self::$TREES = [
			new TreeDecoration(BirchTree::class, 1)
		];
	}

	protected function initPopulators() : void{
		parent::initPopulators();
		$this->tree_decorator->setTrees(...self::$TREES);
	}

	public function getBiomes() : ?array{
		return self::BIOMES;
	}
}

BirchForestPopulator::init();
