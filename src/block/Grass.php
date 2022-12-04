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

class Grass extends Opaque
{

	public function getDropsForCompatibleTool(Item $item): array
	{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function isAffectedBySilkTouch(): bool
	{
		return true;
	}

	public function ticksRandomly(): bool
	{
		return true;
	}

	public function isDayTime(World $world): bool
	{
		return $world->getSunAngleDegrees() < 90 or $world->getSunAngleDegrees() > 270;
	}

	public function allowed_worlds(): bool
	{
		if ($this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-allowed-worlds")) {
			if ($this->position->getWorld()->getServer()->allowedworlds($this->position->getWorld()->getFolderName())) {
				return true;
			}
		}
		return false;
	}

	public function not_allowed_worlds(): bool
	{
		if ($this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-not-allowed-worlds")) {
			if ($this->position->getWorld()->getServer()->notallowedworlds($this->position->getWorld()->getFolderName())) {
				return true;
			}
		}
		return false;
	}

	public function Spawn_Random_Mob()
	{
		$chance = $this->position->getWorld()->getServer()->getAltayIntConfig("auto-mob-spawn-chance");
		if ($this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn")) {
			foreach ($this->position->getWorld()->getServer()->getOnlinePlayers() as $player) {
				if ($player->getPosition()->distance($this->getPosition()) < 11) {
					if ($this->isDayTime($this->position->getWorld())) {
						$random = rand(1, $chance);
						switch ($random) {
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
					} else {
						$randomc = rand(1, $chance);
						switch ($randomc) {
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
	public function control(){
		$not_allowed_worlds = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-not-allowed-worlds");
		$allowed_worlds = $this->position->getWorld()->getServer()->getAltayBoolConfig("auto-mob-spawn-allowed-worlds");
		if ($not_allowed_worlds and $allowed_worlds) {
			if ($this->allowed_worlds()) {
				$this->Spawn_Random_Mob();
			}
		} else {
			if ($not_allowed_worlds) {
				if ($this->not_allowed_worlds()) {
				}else{
					$this->Spawn_Random_Mob();
				}
			}
			if ($allowed_worlds) {
				if ($this->allowed_worlds()) {
					$this->Spawn_Random_Mob();
				}
			}
		}
		if ($not_allowed_worlds == false and $allowed_worlds == false) {
			$this->Spawn_Random_Mob();
		}
	}
	public function onRandomTick(): void
	{
		$this->control();

		$lightAbove = $this->position->getWorld()->getFullLightAt($this->position->x, $this->position->y + 1, $this->position->z);
		if ($lightAbove < 4 && $this->position->getWorld()->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z)->getLightFilter() >= 2) {
			//grass dies
			$ev = new BlockSpreadEvent($this, $this, VanillaBlocks::DIRT());
			$ev->call();
			if (!$ev->isCancelled()) {
				$this->position->getWorld()->setBlock($this->position, $ev->getNewState(), false);
			}
		} elseif ($lightAbove >= 9) {
			//try grass spread
			for ($i = 0; $i < 4; ++$i) {
				$x = mt_rand($this->position->x - 1, $this->position->x + 1);
				$y = mt_rand($this->position->y - 3, $this->position->y + 1);
				$z = mt_rand($this->position->z - 1, $this->position->z + 1);

				$b = $this->position->getWorld()->getBlockAt($x, $y, $z);
				if (
					!($b instanceof Dirt) ||
					$b->isCoarse() ||
					$this->position->getWorld()->getFullLightAt($x, $y + 1, $z) < 4 ||
					$this->position->getWorld()->getBlockAt($x, $y + 1, $z)->getLightFilter() >= 2
				) {
					continue;
				}

				$ev = new BlockSpreadEvent($b, $this, VanillaBlocks::GRASS());
				$ev->call();
				if (!$ev->isCancelled()) {
					$this->position->getWorld()->setBlock($b->position, $ev->getNewState(), false);
				}
			}
		}
	}
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool
	{
		if ($face !== Facing::UP) {
			return false;
		}
		if ($item instanceof Fertilizer) {
			$item->pop();
			TallGrassObject::growGrass($this->position->getWorld(), $this->position, new Random(mt_rand()), 8, 2);

			return true;
		} elseif ($item instanceof Hoe) {
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::FARMLAND();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		} elseif ($item instanceof Shovel && $this->getSide(Facing::UP)->getId() === BlockLegacyIds::AIR) {
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::GRASS_PATH();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		}

		return false;
	}
}