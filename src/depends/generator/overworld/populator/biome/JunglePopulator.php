<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\overworld\populator\biome;

use pocketmine\depends\generator\object\tree\BigOakTree;
use pocketmine\depends\generator\object\tree\CocoaTree;
use pocketmine\depends\generator\object\tree\JungleBush;
use pocketmine\depends\generator\object\tree\MegaJungleTree;
use pocketmine\depends\generator\overworld\biome\BiomeIds;
use pocketmine\depends\generator\overworld\decorator\MelonDecorator;
use pocketmine\depends\generator\overworld\decorator\types\TreeDecoration;
use pocketmine\utils\Random;
use pocketmine\world\BlockTransaction;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;

class JunglePopulator extends BiomePopulator{

	/** @var TreeDecoration[] */
	protected static array $TREES;

	protected static function initTrees() : void{
		self::$TREES = [
			new TreeDecoration(BigOakTree::class, 10),
			new TreeDecoration(JungleBush::class, 50),
			new TreeDecoration(MegaJungleTree::class, 15),
			new TreeDecoration(CocoaTree::class, 30)
		];
	}

	protected MelonDecorator $melon_decorator;

	public function __construct(){
		$this->melon_decorator = new MelonDecorator();
		parent::__construct();
	}

	protected function initPopulators() : void{
		$this->tree_decorator->setAmount(65);
		$this->tree_decorator->setTrees(...self::$TREES);
		$this->flower_decorator->setAmount(4);
		$this->flower_decorator->setFlowers(...self::$FLOWERS);
		$this->tall_grass_decorator->setAmount(25);
		$this->tall_grass_decorator->setFernDensity(0.25);
	}

	public function getBiomes() : ?array{
		return [BiomeIds::JUNGLE, BiomeIds::JUNGLE_HILLS, BiomeIds::JUNGLE_MUTATED];
	}

	protected function populateOnGround(ChunkManager $world, Random $random, int $chunk_x, int $chunk_z, Chunk $chunk) : void{
		$source_x = $chunk_x << 4;
		$source_z = $chunk_z << 4;

		for($i = 0; $i < 7; ++$i){
			$x = $random->nextBoundedInt(16);
			$z = $random->nextBoundedInt(16);
			$y = $chunk->getHighestBlockAt($x, $z);
			$delegate = new BlockTransaction($world);
			$bush = new JungleBush($random, $delegate);
			if($bush->generate($world, $random, $source_x + $x, $y, $source_z + $z)){
				$delegate->apply();
			}
		}

		parent::populateOnGround($world, $random, $chunk_x, $chunk_z, $chunk);
		$this->melon_decorator->populate($world, $random, $chunk_x, $chunk_z, $chunk);
	}
}

JunglePopulator::init();