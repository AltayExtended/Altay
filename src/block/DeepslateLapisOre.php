<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use function mt_rand;

class DeepslateLapisOre extends Opaque {

    public function getDropsForCompatibleTool(Item $item) : array{
        return [
            VanillaItems::LAPIS_LAZULI()->setCount(mt_rand(4, 8))
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(1, 5);
    }

}