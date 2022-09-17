<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemUseResult;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\entity\altay\AltayEntity;

class NameTag extends Item{

	public function onInteractAltayEntity(Player $player, AltayEntity $entity) : ItemUseResult{
		$this->pop();
			return parent::onInteractAltayEntity($player, $entity);

		$this->pop();
		return ItemUseResult::SUCCESS();
	}
}