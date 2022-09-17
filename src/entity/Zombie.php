<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use pocketmine\entity\altay\AltayEntity;
use function mt_rand;

class Zombie extends AltayEntity{
	const TYPE_ID = EntityLegacyIds::ZOMBIE;
	const HEIGHT = 1.95;


	public function getDrops() : array{
		$looting = 1;
		$cause = $this->lastDamageCause;
		if($cause instanceof EntityDamageByEntityEvent){
			$dmg = $cause->getDamager();
			if($dmg instanceof Player){
				$looting = 1;
			}
		}
		$drops = [
			ItemFactory::getInstance()->get(ItemIds::ROTTEN_FLESH, 0, mt_rand(0, 2 * $looting))
		];

		if(mt_rand(0, 199) < 5){
			switch(mt_rand(0, 2)){
				case 0:
					$drops[] = ItemFactory::getInstance()->get(ItemIds::IRON_INGOT, 0, 1 * $looting);
					break;
				case 1:
					$drops[] = ItemFactory::getInstance()->get(ItemIds::CARROT, 0, 1 * $looting);
					break;
				case 2:
					$drops[] = ItemFactory::getInstance()->get(ItemIds::POTATO, 0, 1 * $looting);
					break;
			}
		}

		return $drops;
	}

	public function getXpDropAmount() : int{
		return 5 + mt_rand(1, 3);
	}
}