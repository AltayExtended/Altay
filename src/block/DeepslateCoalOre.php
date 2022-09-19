<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;

class DeepslateCoalOre extends Opaque {


	public function getDropsForCompatibleTool(Item $item) : array{
        return [
            VanillaItems::COAL()
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(1, 3);
    }

}