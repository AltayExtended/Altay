<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\altay\AltayMobs;
use pocketmine\entity\Location;
use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\item\Fertilizer;
use pocketmine\item\Hoe;
use pocketmine\item\Item;
use pocketmine\item\Shovel;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\Random;
use pocketmine\world\World;
use pocketmine\world\generator\object\TallGrass as TallGrassObject;
use pocketmine\world\sound\ItemUseOnBlockSound;
use pocketmine\entity\Entity;

use function mt_rand;

class Grass extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function isDayTime(World $world) : bool{
		return $world->getSunAngleDegrees() < 90 or $world->getSunAngleDegrees() > 270;
	}

	public function allowedcheck(){
		$allowedworldscheck = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-allowed-worlds");
		if($allowedworldscheck == true){
			$worldfoldername = $this->position->getWorld()->getFolderName();
			if($this->position->getWorld()->getServer()->allowedworlds($worldfoldername)){
				return "spawnmob";
			}else{
				return "notspawn";
			}

		}
	}

	public function notallowedcheck(){

		$notallowedworldscheck = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-not-allowed-worlds");
		if($notallowedworldscheck == true){
			$worldfoldername = $this->position->getWorld()->getFolderName();
			if($this->position->getWorld()->getServer()->notallowedworlds($worldfoldername)){
				return "notspawn";
			}else{
				return "spawnmob";
			}
		}
	}

	public function spawnmob(){
		$otomobspawncheck = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn");

		if($otomobspawncheck == true){

			foreach($this->position->getWorld()->getServer()->getOnlinePlayers() as $player){
				if($player->getPosition()->distance($this->getPosition()) < 11){
					if($this->isDayTime($this->position->getWorld())){


						$random = rand(1, 300);
						switch($random){
							case 1:
								$entity = (new AltayMobs)->createSheep($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 2:
								$entity = (new AltayMobs)->createCow($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 3:
								$entity = (new AltayMobs)->createChicken($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 4:
								$entity = (new AltayMobs)->createPig($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 5:
								$entity = (new AltayMobs)->createGoat($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 6:
								$entity = (new AltayMobs)->createHorse($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 7:
								$entity = (new AltayMobs)->createBee($this->position->getWorld(), $this->position->add(0.5, 6, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
						}
					}else{
						$randomc = rand(1, 300);
						switch($randomc){
							case 1:
								$entity = (new AltayMobs)->createZombie($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 2:
								$entity = (new AltayMobs)->createSkeleton($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 3:
								$entity = (new AltayMobs)->createHusk($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 4:
								$entity = (new AltayMobs)->createSpider($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 5:
								$entity = (new AltayMobs)->createPhantom($this->position->getWorld(), $this->position->add(0.5, 6, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
							case 6:
								$entity = (new AltayMobs)->createCreeper($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
								$entity->spawnToAll();
								break;
						}
					}
				}
			}
		}
	}

	public function onRandomTick() : void{
		$notallowedworldscheck = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-not-allowed-worlds");
		$allowedworldscheck = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-allowed-worlds");
		if($notallowedworldscheck == true and $allowedworldscheck == true){

		}else{
			if($notallowedworldscheck == true){
				$control2 = $this->notallowedcheck();
				if($control2 === "notspawn"){

				}else{
					if($control2 === "spawnmob"){
						$this->spawnmob();
					}
				}

			}
			if($allowedworldscheck == true){
				$control = $this->allowedcheck();
				if($control === "notspawn"){

				}else{
					if($control === "spawnmob"){
						$this->spawnmob();
					}
				}

			}
		}
		if($notallowedworldscheck == false and $allowedworldscheck == false){
			$this->spawnmob();
		}

		$lightAbove = $this->position->getWorld()->getFullLightAt($this->position->x, $this->position->y + 1, $this->position->z);
		if($lightAbove < 4 && $this->position->getWorld()->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z)->getLightFilter() >= 2){
			//grass dies
			$ev = new BlockSpreadEvent($this, $this, VanillaBlocks::DIRT());
			$ev->call();
			if(!$ev->isCancelled()){
				$this->position->getWorld()->setBlock($this->position, $ev->getNewState(), false);
			}
		}elseif($lightAbove >= 9){
			//try grass spread
			for($i = 0; $i < 4; ++$i){
				$x = mt_rand($this->position->x - 1, $this->position->x + 1);
				$y = mt_rand($this->position->y - 3, $this->position->y + 1);
				$z = mt_rand($this->position->z - 1, $this->position->z + 1);

				$b = $this->position->getWorld()->getBlockAt($x, $y, $z);
				if(
					!($b instanceof Dirt) ||
					$b->isCoarse() ||
					$this->position->getWorld()->getFullLightAt($x, $y + 1, $z) < 4 ||
					$this->position->getWorld()->getBlockAt($x, $y + 1, $z)->getLightFilter() >= 2
				){
					continue;
				}

				$ev = new BlockSpreadEvent($b, $this, VanillaBlocks::GRASS());
				$ev->call();
				if(!$ev->isCancelled()){
					$this->position->getWorld()->setBlock($b->position, $ev->getNewState(), false);
				}
			}
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($face !== Facing::UP){
			return false;
		}
		if($item instanceof Fertilizer){
			$item->pop();
			TallGrassObject::growGrass($this->position->getWorld(), $this->position, new Random(mt_rand()), 8, 2);

			return true;
		}elseif($item instanceof Hoe){
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::FARMLAND();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		}elseif($item instanceof Shovel && $this->getSide(Facing::UP)->getId() === BlockLegacyIds::AIR){
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::GRASS_PATH();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		}

		return false;
	}
}