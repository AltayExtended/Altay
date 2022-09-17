<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\altay\AltayMobs;
use pocketmine\block\utils\SupportType;
use pocketmine\block\tile\MonsterSpawner as MonsterSP;
use pocketmine\tile\Tile;
use pocketmine\data\bedrock\LegacyEntityIdToStringIdMap;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\item\ToolTier;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\entity\Entity;
use pocketmine\item\SpawnEgg;
use pocketmine\world\World;

use function mt_rand;

class MonsterSpawner extends Transparent{

	protected int $entityId;

	public function __construct(){
		parent::__construct(new BlockIdentifier(BlockLegacyIds::MOB_SPAWNER, 0, null, MonsterSP::class), "Monster Spawner", new BlockBreakInfo(5.0, BlockToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel()));
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		if($item->getNamedTag()->getTag("EntityId") !== null){
			$this->entityId = $item->getNamedTag()->getInt("EntityId", -1);
			if($this->entityId > 10){
				$this->generateSpawnerTile();
			}
		}
		return true;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{

		if($item instanceof SpawnEgg){
			if($player instanceof Player){

				$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
				if(!$tile instanceof MonsterSP){
					$tile = new MonsterSP($this->getPosition()->getWorld(), $this->getPosition());
				}
				$tile->setEntityId($item->getMeta());
				$tile->writeSaveData(new CompoundTag());
				$this->onScheduledUpdate();
				$this->getPosition()->getWorld()->addTile($tile);

				$nbt = new CompoundTag();
				$nbt->setInt("EntityId", (int) $tile->getEntityId());

				$blockk = $this->getPosition()->getWorld()->getBlock(new Vector3((int) $this->getPosition()->getFloorX(), (int) $this->getPosition()->getFloorY(), (int) $this->getPosition()->getFloorZ()));
				$this->getPosition()->getWorld()->setBlock($this->getPosition(), $blockk);
				$item->pop();
				$player->getInventory()->setItemInHand($item);

			}
		}
		return true;
	}

	private function generateSpawnerTile() : void{
		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());

		if(!$tile instanceof MonsterSP){
			$tile = new MonsterSP($this->getPosition()->getWorld(), $this->getPosition());
		}
		$tile->setEntityId($this->entityId);
		$tile->writeSaveData(new CompoundTag());
		$this->onScheduledUpdate();
		$this->getPosition()->getWorld()->addTile($tile);
	}

	public function onScheduledUpdate() : void{
		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if(!$tile instanceof MonsterSP){
			return;
		}
		if($tile->getTick() > 0) $tile->decreaseTick();
		if($tile->isValidEntity() && $tile->canEntityGenerate() && $tile->getTick() <= 0){
			$tile->setTick(20);
			if($tile->getSpawnDelay() > 0){
				$tile->decreaseSpawnDelay();
			}else{
				$tile->setSpawnDelay($tile->getMinSpawnDelay() + mt_rand(0, min(0, $tile->getMaxSpawnDelay() - $tile->getMinSpawnDelay())));
				for($i = 0; $i < $tile->getSpawnCount(); $i++){
					$pos = $tile->getPosition();
					$pos = new Location($pos->x + mt_rand(1, 2), $pos->y + 1, $pos->z + mt_rand(1, 2), $pos->getWorld(), 0, 0);


					if($tile->getEntityId() == 10){
						$entity = (new AltayMobs)->createChicken($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 11){
						$entity = (new AltayMobs)->createCow($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 12){
						$entity = (new AltayMobs)->createPig($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 13){
						$entity = (new AltayMobs)->createSheep($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 14){
						$entity = (new AltayMobs)->createWolf($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 15){
						$entity = (new AltayMobs)->createVillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 16){
						$entity = (new AltayMobs)->createMooshroom($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 17){
						$entity = (new AltayMobs)->createSquid($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 18){
						$entity = (new AltayMobs)->createRabbit($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 19){
						$entity = (new AltayMobs)->createBat($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 20){
						$entity = (new AltayMobs)->createIronGolem($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 22){
						$entity = (new AltayMobs)->createOcelot($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 23){
						$entity = (new AltayMobs)->createHorse($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 24){
						$entity = (new AltayMobs)->createDonkey($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 25){
						$entity = (new AltayMobs)->createMule($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 26){
						$entity = (new AltayMobs)->createSkeletonHorse($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 27){
						$entity = (new AltayMobs)->createZombieHorse($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 28){
						$entity = (new AltayMobs)->createPolarBear($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 29){
						$entity = (new AltayMobs)->createLlama($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 30){
						$entity = (new AltayMobs)->createParrot($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 31){
						$entity = (new AltayMobs)->createDolphin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 32){
						$entity = (new AltayMobs)->createZombie($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 33){
						$entity = (new AltayMobs)->createCreeper($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 34){
						$entity = (new AltayMobs)->createSkeleton($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 35){
						$entity = (new AltayMobs)->createSpider($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 36){
						$entity = (new AltayMobs)->createZombifiedPiglin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 37){
						$entity = (new AltayMobs)->createSlime($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 38){
						$entity = (new AltayMobs)->createEnderman($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 39){
						$entity = (new AltayMobs)->createSilverFish($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 40){
						$entity = (new AltayMobs)->createCaveSpider($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 41){
						$entity = (new AltayMobs)->createGhast($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 42){
						$entity = (new AltayMobs)->createMagmaCube($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 43){
						$entity = (new AltayMobs)->createBlaze($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 44){
						$entity = (new AltayMobs)->createZombieVillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 45){
						$entity = (new AltayMobs)->createWitch($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 46){
						$entity = (new AltayMobs)->createStray($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 47){
						$entity = (new AltayMobs)->createHusk($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 48){
						$entity = (new AltayMobs)->createWitherSkeleton($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 49){
						$entity = (new AltayMobs)->createGuardian($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 50){
						$entity = (new AltayMobs)->createElderGuardian($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 54){
						$entity = (new AltayMobs)->createShulker($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 55){
						$entity = (new AltayMobs)->createEndermite($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 57){
						$entity = (new AltayMobs)->createVindicator($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 58){
						$entity = (new AltayMobs)->createPhantom($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 59){
						$entity = (new AltayMobs)->createRavager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 74){
						$entity = (new AltayMobs)->createSeaTurtle($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 75){
						$entity = (new AltayMobs)->createCat($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 104){
						$entity = (new AltayMobs)->createEvoker($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 105){
						$entity = (new AltayMobs)->createVex($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 108){
						$entity = (new AltayMobs)->createPufferFish($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 109){
						$entity = (new AltayMobs)->createSalmon($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 110){
						$entity = (new AltayMobs)->createDrowned($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 111){
						$entity = (new AltayMobs)->createTropicalFish($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 112){
						$entity = (new AltayMobs)->createCod($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 113){
						$entity = (new AltayMobs)->createPanda($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 114){
						$entity = (new AltayMobs)->createPillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 116){
						$entity = (new AltayMobs)->createZombieVillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 118){
						$entity = (new AltayMobs)->createWanderingTrader($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 120){
						$entity = (new AltayMobs)->createElderGuardian($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 121){
						$entity = (new AltayMobs)->createFox($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 122){
						$entity = (new AltayMobs)->createBee($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 123){
						$entity = (new AltayMobs)->createPiglin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 124){
						$entity = (new AltayMobs)->createHoglin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 125){
						$entity = (new AltayMobs)->createStrider($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 126){
						$entity = (new AltayMobs)->createZoglin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 127){
						$entity = (new AltayMobs)->createPiglinBrute($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 128){
						$entity = (new AltayMobs)->createGoat($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 129){
						$entity = (new AltayMobs)->createGlowSquid($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 130){
						$entity = (new AltayMobs)->createAxolotl($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 131){
						$entity = (new AltayMobs)->createWarden($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 132){
						$entity = (new AltayMobs)->createFrog($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 133){
						$entity = (new AltayMobs)->createTadpole($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 134){
						$entity = (new AltayMobs)->createAllay($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}
					if($tile->getEntityId() == 157){
						$entity = (new AltayMobs)->createTraderLlama($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
						$entity->spawnToAll();
					}

					$i++;
				}
			}
		}
		$this->position->getWorld()->scheduleDelayedBlockUpdate($this->position, 1);
	}
}