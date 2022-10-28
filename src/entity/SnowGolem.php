<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\altay\AltayEntity;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;

class SnowGolem extends AltayEntity {

	const TYPE_ID = EntityLegacyIds::SNOW_GOLEM;
	const HEIGHT = 1.0;

	public function initEntity(CompoundTag $nbt) : void{
		$this->setMaxHealth(10);
		parent::initEntity($nbt);
	}
}