<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\BlockLegacyIds as Ids;

class Sugarcane extends Flowable{

	public function hasEntityCollision() : bool{
		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	}
	public function onRandomTick() : void{
		$control = $this->controllimit();
		if($control === "appropriate"){
			$this->chancecontrol();
		}
	}
	public function onNearbyBlockChange() : void{
		$down = $this->getSide(Facing::DOWN);
		if(!$this->isValidSupport($down)){
			$this->position->getWorld()->useBreakOn($this->position);
		}
	}
	public function chancecontrol(){
		$getchance = $this->position->getWorld()->getServer()->getAltayIntConfig("sugarcane-grown-chance");
		$chance = rand(1, $getchance);
		switch($chance){
			case 1:
				$control = $this->blockcontrol();
				if($control === "grown"){
					$this->grownsugarcane();
				}
				break;
		}
	}
    public function grownsugarcane(){
		$world = $this->position->getWorld();
		$positionblock = new Vector3($this->position->x, $this->position->y + 1, $this->position->z);
		if($world->isInWorld((int) $this->position->x, (int) $this->position->y + 1, (int) $this->position->z)){
			$world->setBlock($positionblock, VanillaBlocks::SUGARCANE());
		}
	}
	public function controllimit(){
		$world = $this->position->getWorld();

		$block1 = $world->getBlockAt($this->position->x, $this->position->y, $this->position->z);
		$block2 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z);
		$block4 = $world->getBlockAt($this->position->x, $this->position->y - 1, $this->position->z);
		$block5 = $world->getBlockAt($this->position->x, $this->position->y - 2, $this->position->z);

		if($block1->getId() == Ids::REEDS_BLOCK){
			if($block2->getId() == Ids::AIR){
				if($block4->getId() == Ids::SAND or $block4->getId() == Ids::GRASS or $block4->getId() == Ids::DIRT or $block4->getId() == Ids::PODZOL){
					return "appropriate";
				}
			}
		}
		if($block5->getId() == Ids::SAND or $block5->getId() == Ids::GRASS or $block5->getId() == Ids::DIRT or $block5->getId() == Ids::PODZOL){
			if($block4->getId() == Ids::REEDS_BLOCK){
				if($block2->getId() == Ids::AIR){
					return "appropriate";
				}
			}
		}
	}
	public function blockcontrol(){
		$world = $this->position->getWorld();
		$getblock = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z + 1);
		$getblock2 = $world->getBlockAt($this->position->x + 1, $this->position->y + 1, $this->position->z);
		$getblock3 = $world->getBlockAt($this->position->x - 1, $this->position->y + 1, $this->position->z);
		$getblock4 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z - 1);

		if($getblock->getId() == Ids::AIR){
			if($getblock2->getId() == Ids::AIR){
				if($getblock3->getId() == Ids::AIR){
					if($getblock4->getId() == Ids::AIR){
						return "grown";
					}
				}
			}
		}
	}
	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->getSide(Facing::DOWN);
		if($down->isSameType($this)){
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}elseif($down->getId() === BlockLegacyIds::GRASS or $down->getId() === BlockLegacyIds::DIRT or $down->getId() === BlockLegacyIds::SAND or $down->getId() === BlockLegacyIds::PODZOL){
			foreach(Facing::HORIZONTAL as $side){
				if($down->getSide($side) instanceof Water){
					return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
				}
			}
		}
		return false;
	}
	private function isValidSupport(Block $block) : bool{
		$id = $block->getId();
		return $block->isSameType($this)
			|| $id === BlockLegacyIds::GRASS
			|| $id === BlockLegacyIds::DIRT
			|| $id === BlockLegacyIds::PODZOL
			|| $id === BlockLegacyIds::MYCELIUM
			|| $id === BlockLegacyIds::SAND;
	}
}