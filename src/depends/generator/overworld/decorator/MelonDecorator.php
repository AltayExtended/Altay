<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\overworld\decorator;

use pocketmine\depends\generator\Decorator;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;

class MelonDecorator extends Decorator{

	public function decorate(ChunkManager $world, Random $random, int $chunk_x, int $chunk_z, Chunk $chunk) : void{
		$source_x = ($chunk_x << 4) + $random->nextBoundedInt(16);
		$source_z = ($chunk_z << 4) + $random->nextBoundedInt(16);
		$sea_level = 64;
		$source_y = $random->nextBoundedInt($sea_level << 1);

		for($i = 0; $i < 64; ++$i){
			$x = $source_x + $random->nextBoundedInt(8) - $random->nextBoundedInt(8);
			$z = $source_z + $random->nextBoundedInt(8) - $random->nextBoundedInt(8);
			$y = $source_y + $random->nextBoundedInt(4) - $random->nextBoundedInt(4);

			if(
				$world->getBlockAt($x, $y, $z)->getId() === BlockLegacyIds::AIR &&
				$world->getBlockAt($x, $y - 1, $z)->getId() === BlockLegacyIds::GRASS
			){
				$world->setBlockAt($x, $y, $z, VanillaBlocks::MELON());
			}
		}
	}
}