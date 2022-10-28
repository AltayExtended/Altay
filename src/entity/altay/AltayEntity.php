<?php

declare(strict_types=1);

namespace pocketmine\entity\altay;

use pocketmine\data\bedrock\LegacyEntityIdToStringIdMap;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\altay\Attributes;
use pocketmine\entity\altay\EntityMove;
use pocketmine\entity\Living;
use pocketmine\entity\EntitySizeInfo;

class AltayEntity extends Living{

	const TYPE_ID = 0;
	const HEIGHT = 0.0;

	public $attackdelay;
	public $defaultlook;
	public $destination;
	public $timer;

	public static function getNetworkTypeId() : string{
		return LegacyEntityIdToStringIdMap::getInstance()->legacyToString(static::TYPE_ID);
	}

	public function initEntity(CompoundTag $nbt) : void{
		$this->setImmobile(false);
		$this->setHasGravity(true);

		$this->attackdelay = 0;
		$this->defaultlook = new Vector3(0, 0, 0);
		$this->destination = new Vector3(0, 0, 0);
		$this->timer = -1;
		if($this->isFlyingMob() == true or $this->isSwimmingMob() == true){
			$this->setHasGravity(false);
		}

		parent::initEntity($nbt);
	}

	public function getName() : string{
		$data = explode("\\", get_class($this));
		$name = end($data);
		return $name;
	}

	protected function getInitialSizeInfo() : EntitySizeInfo{
		return new EntitySizeInfo(1.8, 0.6);
	}

	public function canSaveWithChunk() : bool{
		return false;
	}

	public function setDefaultLook(Vector3 $defaultlook){
		$this->defaultlook = $defaultlook;
	}

	public function getDefaultLook(){
		return $this->defaultlook;
	}

	public function setDestination(Vector3 $destination){
		$this->destination = $destination;
	}

	public function getDestination() : Vector3{
		return $this->destination;
	}

	public function setTimer(int $timer){
		$this->timer = $timer;
	}

	public function getTimer() : int{
		return $this->timer;
	}

	public function setAttackDelay(int $attackdelay){
		$this->attackdelay = $attackdelay;
	}

	public function getAttackDelay(){
		return $this->attackdelay;
	}

	public function knockBack(float $x, float $z, float $force = 0.4, ?float $verticalLimit = 0.4) : void{
		if($this->NearFighter() == true){
			$this->timer = 20;
			$this->setMovementSpeed(1.50);
		}else{
			if($this->isSwimmingMob() == true or $this->isJumpingMob() == true or $this->isWarden() == true or $this->isFlyingMob() == true){
				$this->timer = 0;
				$this->setMovementSpeed(2);
			}else{
				$this->timer = 12;
			}
		}

		parent::knockBack($x, $z, $force);
	}

	public function entityBaseTick(int $diff = 1) : bool{
		(new EntityMove)->tick($this);
		return parent::entityBaseTick($diff);
	}

	public function mortalenemy() : string{
		return (new Attributes)->getEnemyAttack($this->getName());
	}

	public function canBeCaughtinSunLight() : bool{
		return (new Attributes)->canBeCaughtinSunLight($this->getName());
	}

	public function isFlyingMob() : bool{
		return (new Attributes)->isFlyingMob($this->getName());
	}

	public function isJumpingMob() : bool{
		return (new Attributes)->isJumpingMob($this->getName());
	}

	public function isWarden() : bool {
		return (new Attributes)->isWarden($this->getName());
	}

	public function NearFighter() : bool{
		return (new Attributes)->NearFighter($this->getName());
	}

	public function isSnowGolem() : bool {
		return (new Attributes)->isSnowGolem($this->getName());
	}

	public function isSwimmingMob() : bool{
		$swim = (new Attributes)->isSwimmingMob($this->getName());
		$ticks = $this->getAirSupplyTicks();
		$maxticks = $this->getMaxAirSupplyTicks();
		if($swim == true and $this->isBreathing() == false and $ticks < ($maxticks / 2)){
			$this->setAirSupplyTicks($maxticks);
		}
		return $swim;
	}

	public function fall(float $fallDistance) : void{
	}
}