<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;

class DeepslateGoldOre extends Opaque
{

	public function getDropsForCompatibleTool(Item $item): array
	{
		return [
			VanillaItems::RAW_GOLD()
		];
	}

	public function isAffectedBySilkTouch(): bool
	{
		return true;
	}

}