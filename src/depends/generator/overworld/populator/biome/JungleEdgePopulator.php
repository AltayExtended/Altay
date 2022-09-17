<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\overworld\populator\biome;

use pocketmine\depends\generator\object\tree\BigOakTree;
use pocketmine\depends\generator\object\tree\CocoaTree;
use pocketmine\depends\generator\overworld\biome\BiomeIds;
use pocketmine\depends\generator\overworld\decorator\types\TreeDecoration;

class JungleEdgePopulator extends JunglePopulator{

	/** @var TreeDecoration[] */
	protected static array $TREES;

	protected static function initTrees() : void{
		self::$TREES = [
			new TreeDecoration(BigOakTree::class, 10),
			new TreeDecoration(CocoaTree::class, 45)
		];
	}

	protected function initPopulators() : void{
		$this->tree_decorator->setAmount(2);
		$this->tree_decorator->setTrees(...self::$TREES);
	}

	public function getBiomes() : ?array{
		return [BiomeIds::JUNGLE_EDGE, BiomeIds::JUNGLE_EDGE_MUTATED];
	}
}
JungleEdgePopulator::init();