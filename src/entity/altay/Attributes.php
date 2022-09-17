<?php

declare(strict_types=1);

namespace pocketmine\entity\altay;

class Attributes{

	public function NearFighter(string $name) : bool{
		return in_array($name, [
			"Zombie", "Drowned", "Warden", "CaveSpider", "Spider", "Slime", "Wolf", "ZombieVillager", "Vindicator", "Husk", "Evoker"
		]);
	}

	public function isFlyingMob(string $name) : bool{
		return in_array($name, ["Parrot", "Bat", "Bee", "Allay", "Vex", "Phantom"]);
	}

	public function canBeCaughtinSunLight(string $name) : bool{
		return in_array($name, ["Drowned", "Zombie", "Skeleton", "ZombieVillager", "Phantom"]);
	}

	public function isJumpingMob(string $name) : bool{
		return in_array($name, ["Rabbit", "Frog", "Slime"]);
	}

	public function isWarden(string $name) : bool {
		return in_array($name, ["Warden"]);
	}

	public function isSwimmingMob(string $name) : bool{
		return in_array($name, ["Cod", "Dolphin", "ElderGuardian", "PufferFish", "Salmon", "Squid", "TropicalFish", "GlowSquid","Tadpole", "Axolotl", "Drowned"]);
	}

	public function getEnemyAttack(string $name) : string{
		$enemies = ["Zombie" => "Villager", "Wolf" => "Sheep", "Fox" => "Rabbit", "Fox" => "Chicken"];
		foreach($enemies as $source => $target){
			if($source === $name){
				return $target;
			}
		}
		return "none";
	}
} 