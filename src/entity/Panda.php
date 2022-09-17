<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use pocketmine\entity\altay\AltayEntity;
use pocketmine\math\Vector3;
use function mt_rand;

class Panda extends AltayEntity{

	const TYPE_ID = EntityLegacyIds::PANDA;
	const HEIGHT = 1;

	public function initEntity(CompoundTag $nbt) : void{
		$this->setMaxHealth(12);
		$this->attackdelay = 0;
		$this->defaultlook = new Vector3(0, 0, 0);
		$this->destination = new Vector3(0, 0, 0);
		$this->timer = -1;
		if($this->isFlyingMob() == true or $this->isSwimmingMob() == true){
			$this->setHasGravity(true);
		}
		parent::initEntity($nbt);

	}

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
			ItemFactory::getInstance()->get(ItemIds::BAMBOO, 0, mt_rand(0, 1 * $looting))
		];

		return $drops;
	}

	public function getXpDropAmount() : int{
		return 1 + mt_rand(1, 3);
	}
}