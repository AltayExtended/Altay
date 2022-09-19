<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;

class DeepslateDiamondOre extends Opaque {


	public function getDropsForCompatibleTool(Item $item) : array{
        return [
            VanillaItems::DIAMOND()
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(3, 7);
    }

}