<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Hopper as TileHopper;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\InvalidBlockStateException;
use pocketmine\block\utils\PoweredByRedstoneTrait;
use pocketmine\block\utils\SupportType;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\entity\Entity;
use pocketmine\block\tile\Hopper as AltayHopper;

use pocketmine\block\inventory\FurnaceInventory;
use pocketmine\block\Jukebox as BlockJukebox;
use pocketmine\block\tile\Container;
use pocketmine\block\tile\Furnace;
use pocketmine\block\tile\Jukebox;
use pocketmine\entity\object\ItemEntity;
use pocketmine\item\Bucket;
use pocketmine\item\Record;
use pocketmine\Server;
use pocketmine\block\VanillaBlocks;

class Hopper extends Transparent{
	use PoweredByRedstoneTrait;

	private int $facing = Facing::DOWN;
	protected bool $powered = false;
	private int $transferCooldown = 8;
	private int $tickedGameTime = 0;

	public function readStateFromData(int $id, int $stateMeta) : void{
		$facing = BlockDataSerializer::readFacing($stateMeta & 0x07);
		if($facing === Facing::UP){
			throw new InvalidBlockStateException("Hopper may not face upward");
		}
		$this->facing = $facing;
		$this->powered = ($stateMeta & BlockLegacyMetadata::HOPPER_FLAG_POWERED) !== 0;
	}

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeFacing($this->facing) | ($this->powered ? BlockLegacyMetadata::HOPPER_FLAG_POWERED : 0);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function getFacing() : int{ return $this->facing; }

	/** @return $this */
	public function setFacing(int $facing) : self{
		if($facing === Facing::UP){
			throw new \InvalidArgumentException("Hopper may not face upward");
		}
		$this->facing = $facing;
		return $this;
	}

	protected function recalculateCollisionBoxes() : array{
		$result = [
			AxisAlignedBB::one()->trim(Facing::UP, 6 / 16)
		];

		foreach(Facing::HORIZONTAL as $f){
			$result[] = AxisAlignedBB::one()->trim($f, 14 / 16);
		}
		return $result;
	}
	public function readStateFromWorld(): void {
		parent::readStateFromWorld();

		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if (!$tile instanceof AltayHopper) return;

		$this->setTransferCooldown($tile->getTransferCooldown());
		$this->setTickedGameTime($tile->getTickedGameTime());
	}
	public function writeStateToWorld(): void {
		parent::writeStateToWorld();

		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
		assert($tile instanceof AltayHopper);
	}

	public function getSupportType(int $facing) : SupportType{
		return match($facing){
			Facing::UP => SupportType::FULL(),
			Facing::DOWN => $this->facing === Facing::DOWN ? SupportType::CENTER() : SupportType::NONE(),
			default => SupportType::NONE()
		};
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->facing = $face === Facing::DOWN ? Facing::DOWN : Facing::opposite($face);

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$tile = $this->position->getWorld()->getTile($this->position);
			if($tile instanceof TileHopper or $tile instanceof AltayHopper){
				$player->setCurrentWindow($tile->getInventory());
			}
			return true;
		}
		return false;
	}
	protected function ejectItem(): bool {
		$hopper = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if (!$hopper instanceof AltayHopper) return false;

		$target = $this->getPosition()->getWorld()->getTile($this->getSide($this->getFacing())->getPosition());
		$juke = $target instanceof Jukebox;
		if (!$target instanceof Container && !$juke) return false;

		$furnace = $target instanceof Furnace && $this->getFacing() !== Facing::DOWN;

		$inventory = $hopper->getInventory();
		$slot = null;
		$item = null;
		for ($i = 0; $i < $inventory->getSize(); $i++) {
			$ejectItem = $inventory->getItem($i);
			if ($ejectItem->isNull()) continue;
			if ($juke && !$ejectItem instanceof Record) continue;
			if ($furnace && $ejectItem->getFuelTime() <= 0) continue;

			$slot = $i;
			$item = $ejectItem;
			break;
		}
		if ($slot === null) return false;

		$pop = $item->pop();
		if ($target instanceof Jukebox) {
			$targetBlock = $target->getBlock();
			if (!$targetBlock instanceof BlockJukebox) return false;
			if ($targetBlock->getRecord() !== null) return false;
			if (!$pop instanceof Record) return false;



			$targetBlock->insertRecord($pop);
			$targetBlock->writeStateToWorld();
			$inventory->setItem($slot, $item);
			return true;
		}

		$targetInventory = $target->getInventory();
		if ($targetInventory instanceof FurnaceInventory) {
			$targetSlot = $this->getFacing() === Facing::DOWN ? 0 : 1;
			if ($targetSlot === 1 && $pop->getFuelTime() <= 0) return false;

			$targetItem = $targetInventory->getItem($targetSlot);
			if ($targetItem->isNull()) {
				$targetInventory->setItem($targetSlot, $pop);
				$inventory->setItem($slot, $item);
				return true;
			}

			$count = $targetItem->getCount() + $pop->getCount();
			if ($targetItem->canStackWith($pop) && $count <= $targetItem->getMaxStackSize()) {
				$targetItem->setCount($count);
				$targetInventory->setItem($targetSlot, $targetItem);
				$inventory->setItem($slot, $item);
				return true;
			}

			return false;
		}

		if (!$targetInventory->canAddItem($pop)) return false;



		$targetInventory->addItem($pop);
		$inventory->setItem($slot, $item);

		$block = $target->getBlock();
		if (!$block instanceof Hopper) return true;

		$block->setTransferCooldown($block->getTickedGameTime() >= $this->getTickedGameTime() ? 7 : 8);
		$block->writeStateToWorld();
		return true;
	}

	protected function suckItem(): bool {
		$source = $this->getPosition()->getWorld()->getTile($this->getSide(Facing::UP)->getPosition());
		if (!$source instanceof Container) return false;

		$sourceInventory = $source->getInventory();
		$slot = null;
		$item = null;
		if ($sourceInventory instanceof FurnaceInventory) {
			$fuel = $sourceInventory->getFuel();
			if ($fuel instanceof Bucket) {
				$slot = 1;
				$item = $fuel;
			} else {
				$result = $sourceInventory->getResult();
				if (!$result->isNull()) {
					$slot = 2;
					$item = $result;
				}
			}
		} else {
			for ($i = 0; $i < $sourceInventory->getSize(); $i++) {
				$suckItem = $sourceInventory->getItem($i);
				if ($suckItem->isNull()) continue;

				$slot = $i;
				$item = $suckItem;
				break;
			}
		}
		if ($slot === null) return false;

		$hopper = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if (!$hopper instanceof AltayHopper) return false;

		$pop = $item->pop();
		$inventory = $hopper->getInventory();
		if (!$inventory->canAddItem($pop)) return false;



		$inventory->addItem($pop);
		$sourceInventory->setItem($slot, $item);
		return true;
	}
	protected function suckEntity(): bool {
		$hopper = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if (!$hopper instanceof AltayHopper) return false;

		$inventory = $hopper->getInventory();
		$pos = $this->getPosition();
		$bb = new AxisAlignedBB($pos->getFloorX(), $pos->getFloorY() + 1, $pos->getFloorZ(), $pos->getFloorX() + 1, $pos->getFloorY() + 2, $pos->getFloorZ() + 1);
		$entities = $this->getPosition()->getWorld()->getNearbyEntities($bb);
		$check = false;
		for ($i = 0; $i < count($entities); $i++) {
			$entity = $entities[$i];
			if (!$entity instanceof ItemEntity) continue;

			$source = clone $entity->getItem();
			$count = $inventory->getAddableItemQuantity($source);
			if ($count === 0) continue;

			$pop = $source->pop($count);


			$inventory->addItem($pop);
			$entity->getItem()->pop($count);
			if ($source->getCount() === 0) $entity->flagForDespawn();
			$check = true;
		}
		return $check;
	}

	public function onScheduledUpdate(): void {
		$this->getPosition()->getWorld()->scheduleDelayedBlockUpdate($this->getPosition(), 1);

		$this->setTransferCooldown($this->getTransferCooldown() - 1);
		$this->setTickedGameTime(Server::getInstance()->getTick());
		if (!$this->isPowered()) $this->suckEntity();
		if ($this->getTransferCooldown() > 0) {
			$this->writeStateToWorld();
			return;
		}

		$this->setTransferCooldown(0);
		if ($this->isPowered()) {
			$this->writeStateToWorld();
			return;
		}

		$check = $this->ejectItem();
		$check |= $this->suckItem();
		if ($check) $this->setTransferCooldown(8);
		$this->writeStateToWorld();
	}
	public function onRedstoneUpdate(): void {
	}

	public function isPowered() : bool{ return $this->powered; }

	public function getTransferCooldown(): int {
		return $this->transferCooldown;
	}

	public function setTransferCooldown(int $cooldown): void {
		$this->transferCooldown = $cooldown;
	}

	public function getTickedGameTime(): int {
		return $this->tickedGameTime;
	}

	public function setTickedGameTime(int $tick): void {
		$this->tickedGameTime = $tick;
	}

	//TODO: redstone logic, sucking logic
}