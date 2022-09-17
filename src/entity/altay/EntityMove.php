<?php

declare(strict_types=1);

namespace pocketmine\entity\altay;

use pocketmine\block\BlockLegacyIds as Ids;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\block\Water;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\entity\altay\AltayEntity;
use pocketmine\world\World;
use pocketmine\block\VanillaBlocks;

class EntityMove{

	public function tick(AltayEntity $entity){
		$timer = $entity->getTimer() - 1;
		$typeflyingmob = $entity->isFlyingMob();
		$entity->setTimer($timer);

		if($timer > 0){
			return $this->waitentity($entity);
		}
		if($timer == 0 and $typeflyingmob == false and mt_rand(0, 1) == 1 and $entity->getTargetEntity() === null){
			return $entity->setTimer(mt_rand(120, 400));
		}
		$position = $entity->getDestination();
		if(!$position->x and !$position->y and !$position->z){
			$entity->setDestination($this->getRandomPosition($entity));
		}
		if($entity->getTimer() > 0){
			return;
		}
		$this->entitymove($entity);
	}

	public function getRandomPosition(AltayEntity $entity) : Vector3{
		$position = $this->getEnemyPosition($entity);

		if(!$position->equals(new Vector3(0, 0, 0))){
			return $position;
		}

		$position = $this->getSaferSpawn($entity->getPosition(), $entity->getWorld(), 15);

		if($entity->isFlyingMob() == true){
			$position->add(0, 10, 0);
		}
		if($entity->isSwimmingMob() == true){
			$position->add(0, mt_rand(-10, 10), 0);
		}

		$block = $entity->getWorld()->getBlock($position);

		if($entity->isSwimmingMob() and !$block instanceof Water){
			$entity->setTimer(40);
			return new Vector3(0, 0, 0);
		}
		if(!$entity->isSwimmingMob() and $block instanceof Water){
			$entity->setTimer(40);
			return new Vector3(0, 0, 0);
		}
		if($block->isSolid()){
			$entity->setTimer(40);
			return new Vector3(0, 0, 0);
		}
		return $position;
	}

	public function getEnemyPosition(AltayEntity $entity) : Vector3{
		if($entity->NearFighter() == false){
			return new Vector3(0, 0, 0);
		}
		if($entity->getTargetEntity() !== null){
			return $entity->getTargetEntity()->getPosition()->asVector3();
		}
		foreach($entity->getWorld()->getNearbyEntities($entity->getBoundingBox()->expandedCopy(15, 15, 15)) as $e){
			if($e instanceof Player and $e->isAlive() and $e->isCreative() == false){
				$entity->setTargetEntity($e);
				$pos = $e->getPosition();
				return new Vector3($pos->x, 0, $pos->z);
			}
			if(($e instanceof Player or $e instanceof AltayEntity) and $e->getName() === $entity->mortalenemy()){
				$entity->setTargetEntity($e);
				$entity->setMovementSpeed(2.00);
				$pos = $e->getPosition();
				return new Vector3($pos->x, 0, $pos->z);
			}
		}
		return new Vector3(0, 0, 0);
	}

	public function getSaferSpawn(Vector3 $start, World $world, int $radius) : Vector3{
		for($r = $radius; $r > 5; $r -= 5){
			$x = mt_rand(-$r, $r);
			$m = sqrt(pow($r, 2) - pow($x, 2));
			$z = mt_rand((int) -$m, (int) $m);

			$vector = new Vector3($start->x + $x, $start->y, $start->z + $z);

			$chunk = $world->getOrLoadChunkAtPosition($vector);

			if($chunk === null){
				continue;
			}
			$safeposition = $world->getSafeSpawn($vector);
			if($safeposition->y > 0){

				return $safeposition;

			}

			return $start;
		}
	}

	public function stopentity(Vector3 $start, World $world, int $radius) : Vector3{
		for($r = $radius; $r > 5; $r -= 5){
			$x = mt_rand(-$r, $r);
			$m = sqrt(pow($r, 2) - pow($x, 2));
			$z = mt_rand((int) -$m, (int) $m);

			$vector = new Vector3($start->x + $x, $start->y, $start->z + $z);

			$chunk = $world->getOrLoadChunkAtPosition($vector);

			if($chunk === null){
				continue;
			}

			return $start;
		}

	}

	public function entitymove(AltayEntity $entity){
		$motion = $entity->getMotion();
		$location = $entity->getLocation();
		$position = $entity->getPosition();
		$swimmingmob = $entity->isSwimmingMob();
		$flyingmob = $entity->isFlyingMob();
		$nearfighter = $entity->NearFighter();
		$world = $entity->getPosition()->getWorld();

		if($entity->NearFighter() == true){
			if($world->isInWorld((int) $position->getFloorX(), (int) $position->getFloorY(), (int) $position->getFloorZ())){

				$targetpos = $this->calculatemotion($entity);
				$motion->x = $targetpos->x;
				$motion->y = $targetpos->y;
				$motion->z = $targetpos->z;

				$look = new Vector3($location->x + $motion->x, $location->y + $motion->y + $entity->getEyeHeight(), $location->z + $motion->z);
				$blockx = intval($location->x + $motion->x);
				$blocky = intval($location->y + $motion->y + $entity->getEyeHeight());
				$blockz = intval($location->z + $motion->z);

				$block1 = $world->getBlockAt($blockx + 1, $blocky, $blockz);
				$block2 = $world->getBlockAt($blockx - 1, $blocky, $blockz);
				$block3 = $world->getBlockAt($blockx, $blocky, $blockz + 1);
				$block4 = $world->getBlockAt($blockx, $blocky, $blockz - 1);
				if(!$block1->getId() == Ids::AIR or !$block2->getId() == Ids::AIR or !$block3->getId() == Ids::AIR or !$block4->getId() == Ids::AIR){
					return $entity->setDestination($this->getRandomPosition($entity));
				}

			}
		}

		if(!$entity->onGround and $motion->y < 0 and $flyingmob == false and $swimmingmob == false){
			$motion->y *= 0.6;
		}else{
			if(mt_rand(0, 500) == 1 or ($entity->isCollided == true and $swimmingmob == true)){

				$entity->setDestination($this->getRandomPosition($entity));
			}
			$targetpos = $this->calculatemotion($entity);
			$motion->x = $targetpos->x;
			$motion->y = $targetpos->y;
			$motion->z = $targetpos->z;
		}
		if($entity->getTimer() > 0){
			return;
		}
		if($entity->isCollidedHorizontally == true and $swimmingmob == false){
			$motion->y = 1;
		}
		if($entity->isJumpingMob() == true and $entity->onGround){
			$motion->y = 1;
		}

		$vector = new Vector3($motion->x, $motion->y, $motion->z);
		$look = new Vector3($location->x + $motion->x, $location->y + $motion->y + $entity->getEyeHeight(), $location->z + $motion->z);

		$entity->setDefaultLook($look);

		$entity->lookAt($look);
		$entity->setMotion($vector);
		$this->attack($entity, 4);
	}

	public function isHaveSun(World $world) : bool{
		return $world->getSunAngleDegrees() < 90 or $world->getSunAngleDegrees() > 270;
	}

	public function waitentity(AltayEntity $entity){
		$location = $entity->getLocation();
		foreach($entity->getPosition()->getWorld()->getServer()->getOnlinePlayers() as $player){
			if($player->getPosition()->distance($entity->getPosition()) < 6){
				$position = new Vector3($player->getPosition()->getFloorX(), $player->getPosition()->getFloorY() + 1, $player->getPosition()->getFloorZ());
				$entity->lookAt($position);
				if($entity->NearFighter() == true){
					$this->attack($entity, 4);

				}
			}
		}
		if($entity->lastUpdate % 100 == 0){
			if($entity->getHealth() < $entity->getMaxHealth()){
				$entity->setHealth($entity->getHealth() + 1);
			}
		}
		if($entity->isFlyingMob() == true){
			return;
		}
		if($entity->isSwimmingMob() == true){
			if(!$entity->isUnderwater()){
				$entity->setTimer(-1);
			}
			return;
		}
		if($entity->canBeCaughtinSunLight() == true and $this->isHaveSun($entity->getWorld())){
			$entity->setOnFire(120);
			$entity->setTargetEntity($entity);
		}
		if($entity->isOnFire()){
			$this->attack($entity, 4);
		}
		if(mt_rand(1, 200) == 1){
			$entity->lookAt($entity->getDefaultLook());
			return;
		}
		if(mt_rand(1, 200) == 1){
			$x = $location->x + mt_rand(-1, 1);
			$y = $location->y + mt_rand(-1, 1);
			$z = $location->z + mt_rand(-1, 1);
			$entity->lookAt(new Vector3($x, $y, $z));
		}
	}

	public function calculatemotion(AltayEntity $entity) : Vector3{
		$dest = $entity->getDestination();
		$epos = $entity->getPosition();
		$motion = $entity->getMotion();
		$speed = $entity->getMovementSpeed();
		$speed = 1.0;
		$flyingmob = $entity->isFlyingMob();

		$x = $dest->x - $epos->x;
		$y = $dest->y - $epos->y;
		$z = $dest->z - $epos->z;

		if($x ** 2 + $z ** 2 < 0.7){
			if($entity->getTargetEntity() === null){
				$motion->y = 0;
				$entity->setTimer($flyingmob == true ? 100 : 200);
				$entity->setDestination(new Vector3(0, 0, 0));
			}
		}else{
			$diff = abs($x) + abs($z);

			$motion->x = $speed * 0.15 * ($x / $diff);
			$motion->y = 0;
			$motion->z = $speed * 0.15 * ($z / $diff);

			if($entity->isSwimming()){
				$motion->y = $speed * 0.15 * ($y / $diff);
			}
		}

		return new Vector3($motion->x, $motion->y, $motion->z);
	}

	public function attack(AltayEntity $entity, int $damage){
		$target = $entity->getTargetEntity();

		if($target === null){
			return;
		}

		$dist = $entity->getPosition()->distanceSquared($target->getPosition());

		if(!$target->isAlive() or $dist >= 50 or ($target instanceof Player and $target->isCreative() == true)){
			$entity->setMovementSpeed(1.00);
			$entity->setTargetEntity(null);
			return;
		}

		if($entity->getAttackDelay() > 20){
			if($entity->getPosition()->distance($target->getPosition()) <= 2.0){
				$entity->setAttackDelay(0);
				$ev = new EntityDamageByEntityEvent($entity, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
				$target->attack($ev);
			}
		}

		$entity->setAttackDelay($entity->getAttackDelay() + 1);

		$pos = $target->getPosition();
		$entity->setDestination(new Vector3($pos->x, 0, $pos->z));
	}
}