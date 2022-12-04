<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\inventory\HopperInventory;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class Hopper extends Spawnable implements Container, Nameable{

	use ContainerTrait;
	use NameableTrait;

	private const TAG_TRANSFER_COOLDOWN = "TransferCooldown";

	private HopperInventory $inventory;
	protected int $transferCooldown = 8;
	protected int $tickedGameTime = 0;

	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->inventory = new HopperInventory($this->position);
	}

	public function readSaveData(CompoundTag $nbt) : void{

		$this->transferCooldown = $nbt->getInt(self::TAG_TRANSFER_COOLDOWN, 0);
	}


	protected function writeSaveData(CompoundTag $nbt) : void{

		$nbt->setInt(self::TAG_TRANSFER_COOLDOWN, $this->transferCooldown);
	}

	public function close() : void{
		if(!$this->closed){
			$this->inventory->removeAllViewers();

			parent::close();
		}
	}

	public function getDefaultName() : string{
		return "Hopper";
	}

	/**
	 * @return HopperInventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

	/**
	 * @return HopperInventory
	 */
	public function getRealInventory(){
		return $this->inventory;
	}
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
}