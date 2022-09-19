<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;

class DeepslateIronOre extends Opaque
{

	public function getDropsForCompatibleTool(Item $item): array
	{
		return [
			VanillaItems::RAW_IRON()
		];
	}

	public function isAffectedBySilkTouch(): bool
	{
		return true;
	}

}