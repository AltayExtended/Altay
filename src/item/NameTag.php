<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\altay\Session;
use pocketmine\entity\altay\AltayEntity;
use pocketmine\entity\Entity;
use pocketmine\player\Player;

class NameTag extends Item{

	public function onInteractEntity(Player $player, Entity $entity) : ItemUseResult{
		if ($entity instanceof AltayEntity) {
			if ($player->getInventory()->getItemInHand() instanceof NameTag) {
				if ($player->getInventory()->getItemInHand()->hasCustomName()) {
					$entity->setNameTag($player->getInventory()->getItemInHand()->getCustomName());
					Session::playSound($player, "note.bell");
					if($player->hasFiniteResources()) {
						$item = $player->getInventory()->getItemInHand();
						$item->pop(1);
						$player->getInventory()->setItemInHand($item);
					}
					return ItemUseResult::SUCCESS();
				}
			}
		}
		return ItemUseResult::FAIL();
	}
	public function getCooldownTicks() : int{
		return 20;
	}
}