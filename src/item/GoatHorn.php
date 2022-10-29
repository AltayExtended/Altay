<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\altay\Session;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\types\LevelSoundEvent;
use pocketmine\player\Player;
use pocketmine\world\sound\GoatHorn0;
use pocketmine\world\sound\GoatHorn1;
use pocketmine\world\sound\GoatHorn2;
use pocketmine\world\sound\GoatHorn3;
use pocketmine\world\sound\GoatHorn4;
use pocketmine\world\sound\GoatHorn5;
use pocketmine\world\sound\GoatHorn6;
use pocketmine\world\sound\GoatHorn7;

class GoatHorn extends Item{

	public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult{
		if($player->getInventory()->getItemInHand()->getMeta() == 0){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn0());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 1){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn1());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 2){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn2());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 3){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn3());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 4){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn4());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 5){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn5());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 6){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn6());
		}
		if($player->getInventory()->getItemInHand()->getMeta() == 7){
			$player->getWorld()->addSound($player->getPosition()->add(0.5, 0.5, 0.5), new GoatHorn7());
		}
			return ItemUseResult::SUCCESS();
	}
	public function getMaxStackSize() : int{
		return 1;
	}

	public function getCooldownTicks() : int{
		return 80;
	}

}
