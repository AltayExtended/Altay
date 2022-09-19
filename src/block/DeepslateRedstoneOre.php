<?php

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Opaque;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use function mt_rand;

class DeepslateRedstoneOre extends Opaque {

    public function getLightLevel() : int{
        return 1 ? 9 : 0;
    }

    public function getDropsForCompatibleTool(Item $item) : array{
        return [
            VanillaItems::REDSTONE_DUST()->setCount(mt_rand(4, 5))
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(1, 5);
    }

}