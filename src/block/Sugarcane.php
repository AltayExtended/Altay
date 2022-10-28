<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\BlockLegacyIds as Ids;

class Sugarcane extends Flowable
{

	public function hasEntityCollision(): bool
	{
		return true;
	}

	public function ticksRandomly(): bool
	{
		return true;
	}

	public function onRandomTick(): void
	{
		if ($this->control_limit()) {
			$this->chance_control();
		}
	}

	public function onNearbyBlockChange(): void
	{
		$down = $this->getSide(Facing::DOWN);
		if (!$this->isValidSupport($down)) {
			$this->position->getWorld()->useBreakOn($this->position);
		}
	}

	public function chance_control()
	{
		$chance = rand(1, $this->position->getWorld()->getServer()->getAltayIntConfig("sugarcane-grown-chance"));
		switch ($chance) {
			case 1:
				if ($this->block_control()) {
					$this->grown_sugarcane();
				}
				break;
		}
	}

	public function grown_sugarcane()
	{
		$world = $this->position->getWorld();
		$pos = new Vector3($this->position->x, $this->position->y + 1, $this->position->z);
		if ($world->isInWorld((int)$this->position->x, (int)$this->position->y + 1, (int)$this->position->z)) {
			$world->setBlock($pos, VanillaBlocks::SUGARCANE());
		}
	}

	public function control_limit(): bool
	{
		$world = $this->position->getWorld();

		$block1 = $world->getBlockAt($this->position->x, $this->position->y, $this->position->z);
		$block2 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z);
		$block4 = $world->getBlockAt($this->position->x, $this->position->y - 1, $this->position->z);
		$block5 = $world->getBlockAt($this->position->x, $this->position->y - 2, $this->position->z);

		if ($block1->getId() == Ids::REEDS_BLOCK) {
			if ($block2->getId() == Ids::AIR) {
				if ($block4->getId() == Ids::SAND or $block4->getId() == Ids::GRASS or $block4->getId() == Ids::DIRT or $block4->getId() == Ids::PODZOL) {
					return true;
				}
			}
		}
		if ($block5->getId() == Ids::SAND or $block5->getId() == Ids::GRASS or $block5->getId() == Ids::DIRT or $block5->getId() == Ids::PODZOL) {
			if ($block4->getId() == Ids::REEDS_BLOCK) {
				if ($block2->getId() == Ids::AIR) {
					return true;
				}
			}
		}
		return false;
	}

	public function block_control(): bool
	{
		$world = $this->position->getWorld();
		$getblock = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z + 1);
		$getblock2 = $world->getBlockAt($this->position->x + 1, $this->position->y + 1, $this->position->z);
		$getblock3 = $world->getBlockAt($this->position->x - 1, $this->position->y + 1, $this->position->z);
		$getblock4 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z - 1);

		if ($getblock->getId() == Ids::AIR) {
			if ($getblock2->getId() == Ids::AIR) {
				if ($getblock3->getId() == Ids::AIR) {
					if ($getblock4->getId() == Ids::AIR) {
						return true;
					}
				}
			}
		}
		return false;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
	{
		$down = $this->getSide(Facing::DOWN);
		if ($down->isSameType($this)) {
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		} elseif ($down->getId() === BlockLegacyIds::GRASS or $down->getId() === BlockLegacyIds::DIRT or $down->getId() === BlockLegacyIds::SAND or $down->getId() === BlockLegacyIds::PODZOL) {
			foreach (Facing::HORIZONTAL as $side) {
				if ($down->getSide($side) instanceof Water) {
					return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
				}
			}
		}
		return false;
	}

	private function isValidSupport(Block $block): bool
	{
		$id = $block->getId();
		return $block->isSameType($this)
			|| $id === BlockLegacyIds::GRASS
			|| $id === BlockLegacyIds::DIRT
			|| $id === BlockLegacyIds::PODZOL
			|| $id === BlockLegacyIds::MYCELIUM
			|| $id === BlockLegacyIds::SAND;
	}
}