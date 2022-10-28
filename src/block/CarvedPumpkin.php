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

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\entity\altay\AltayMobs;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\BlockLegacyIds as Ids;

class CarvedPumpkin extends Opaque
{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;

	public function readStateFromData(int $id, int $stateMeta): void
	{
		$this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x03);
	}

	protected function writeStateToMeta(): int
	{
		return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing);
	}

	public function getStateBitmask(): int
	{
		return 0b11;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
	{
		if ($this->checkBlock($this->position->x, $this->position->y, $this->position->z, $this->position->getWorld()->getFolderName())) {
			if($this->position->getWorld()->getServer()->getAltayBoolConfig("snow-golem-creation")) {
				$this->SpawnSnowGolem();
			}
			return false;
		} else {
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}
	}

	public function checkBlock(int $xx, int $yy, int $zz, string $worldfoldername): bool
	{
		$world = $this->position->getWorld()->getServer()->getWorldManager()->getWorldByName($worldfoldername);
		$pos = new Vector3($xx, $yy, $zz);
		$pos2 = new Vector3($xx, $yy - 1, $zz);
		$pos3 = new Vector3($xx, $yy - 2, $zz);

		$posc = $world->getBlockAt($xx, $yy - 1, $zz);
		$posc2 = $world->getBlockAt($xx, $yy - 2, $zz);
		if ($this->position->getWorld()->getServer()->getAltayBoolConfig("snow-golem-creation")) {
			if ($posc->getId() == Ids::SNOW_BLOCK) {
				if ($posc2->getId() == Ids::SNOW_BLOCK) {
					$world->setBlock($pos, VanillaBlocks::AIR());
					$world->setBlock($pos2, VanillaBlocks::AIR());
					$world->setBlock($pos3, VanillaBlocks::AIR());
					return true;
				}
			}
		}
		return false;
	}

	public function SpawnSnowGolem(){
		$entity = (new AltayMobs)->createSnowGolem($this->position->getWorld(), $this->position->add(0.5, 0, 0.5), lcg_value() * 360, 0);
		$entity->spawnToAll();

		$pos = new Vector3($this->position->x, $this->position->y, $this->position->z);
		$world = $this->position->getWorld();
		$world->setBlock($pos, VanillaBlocks::AIR());
	}
}
