<?php

namespace pocketmine\block;

use pocketmine\item\VanillaItems;
use pocketmine\item\Item;
use function mt_rand;

class AmethystCluster extends Opaque
{

	public function getDropsForCompatibleTool(Item $item): array
	{
		return [
			VanillaItems::AMETHYST_SHARD()->setCount(mt_rand(2, 5))
		];
	}

	public function isAffectedBySilkTouch(): bool
	{
		return true;
	}
}