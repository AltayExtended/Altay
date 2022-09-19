<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use function mt_rand;

class DeepslateCopperOre extends Opaque
{


	public function getDropsForCompatibleTool(Item $item): array
	{
		return [
			VanillaItems::RAW_COPPER()->setCount(mt_rand(1, 3))
		];
	}

	public function isAffectedBySilkTouch(): bool
	{
		return true;
	}


}