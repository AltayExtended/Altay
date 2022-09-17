<?php

namespace pocketmine\entity\altay;

use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\world\World;
use pocketmine\entity\Chicken;
use pocketmine\entity\Bee;
use pocketmine\entity\Cow;
use pocketmine\entity\Pig;
use pocketmine\entity\Sheep;
use pocketmine\entity\Wolf;
use pocketmine\entity\PolarBear;
use pocketmine\entity\Ocelot;
use pocketmine\entity\Cat;
use pocketmine\entity\Mooshroom;
use pocketmine\entity\Bat;
use pocketmine\entity\Parrot;
use pocketmine\entity\Rabbit;
use pocketmine\entity\Llama;
use pocketmine\entity\Horse;
use pocketmine\entity\Donkey;
use pocketmine\entity\Mule;
use pocketmine\entity\SkeletonHorse;
use pocketmine\entity\ZombieHorse;
use pocketmine\entity\TropicalFish;
use pocketmine\entity\Cod;
use pocketmine\entity\PufferFish;
use pocketmine\entity\Salmon;
use pocketmine\entity\Dolphin;
use pocketmine\entity\SeaTurtle;
use pocketmine\entity\Panda;
use pocketmine\entity\Fox;
use pocketmine\entity\Creeper;
use pocketmine\entity\Enderman;
use pocketmine\entity\SilverFish;
use pocketmine\entity\Skeleton;
use pocketmine\entity\WitherSkeleton;
use pocketmine\entity\Stray;
use pocketmine\entity\Slime;
use pocketmine\entity\Spider;
use pocketmine\entity\Zombie;
use pocketmine\entity\ZombifiedPiglin;
use pocketmine\entity\Husk;
use pocketmine\entity\Drowned;
use pocketmine\entity\Squid;
use pocketmine\entity\GlowSquid;
use pocketmine\entity\CaveSpider;
use pocketmine\entity\Witch;
use pocketmine\entity\Guardian;
use pocketmine\entity\ElderGuardian;
use pocketmine\entity\Endermite;
use pocketmine\entity\MagmaCube;
use pocketmine\entity\Strider;
use pocketmine\entity\Hoglin;
use pocketmine\entity\Piglin;
use pocketmine\entity\Zoglin;
use pocketmine\entity\PiglinBrute;
use pocketmine\entity\Goat;
use pocketmine\entity\Axolotl;
use pocketmine\entity\Warden;
use pocketmine\entity\Allay;
use pocketmine\entity\Frog;
use pocketmine\entity\Tadpole;
use pocketmine\entity\TraderLlama;
use pocketmine\entity\Ghast;
use pocketmine\entity\Blaze;
use pocketmine\entity\Shulker;
use pocketmine\entity\Vindicator;
use pocketmine\entity\Evoker;
use pocketmine\entity\Vex;
use pocketmine\entity\Villager;
use pocketmine\entity\WanderingTrader;
use pocketmine\entity\ZombieVillager;
use pocketmine\entity\Phantom;
use pocketmine\entity\Pillager;
use pocketmine\entity\Ravager;

class AltayMobs{

	public function createChicken(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Chicken(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createBee(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Bee(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createCow(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Cow(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPig(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Pig(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSheep(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Sheep(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createWolf(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Wolf(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPolarBear(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new PolarBear(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createOcelot(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Ocelot(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createCat(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Cat(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createMooshroom(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Mooshroom(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createBat(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Bat(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createParrot(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Parrot(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createRabbit(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Rabbit(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createLlama(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Llama(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createHorse(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Horse(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createDonkey(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Donkey(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createMule(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Mule(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSkeletonHorse(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new SkeletonHorse(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createZombieHorse(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new ZombieHorse(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createTropicalFish(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new TropicalFish(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createCod(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Cod(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPufferFish(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new PufferFish(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSalmon(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Salmon(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createDolphin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Dolphin(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSeaTurtle(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new SeaTurtle(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPanda(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Panda(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createFox(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Fox(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createCreeper(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Creeper(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createEnderman(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Enderman(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSilverFish(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new SilverFish(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSkeleton(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Skeleton(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createWitherSkeleton(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new WitherSkeleton(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createStray(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Stray(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSlime(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Slime(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSpider(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Spider(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createZombie(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Zombie(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createZombifiedPiglin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new ZombifiedPiglin(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createHusk(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Husk(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createDrowned(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Drowned(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createSquid(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Squid(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createGlowSquid(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new GlowSquid(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createCaveSpider(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new CaveSpider(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createWitch(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Witch(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createGuardian(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Guardian(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createElderGuardian(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new ElderGuardian(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createEndermite(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Endermite(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createMagmaCube(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new MagmaCube(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createStrider(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Strider(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createHoglin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Hoglin(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPiglin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Piglin(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createZoglin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Zoglin(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPiglinBrute(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new PiglinBrute(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createGoat(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Goat(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createAxolotl(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Axolotl(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createWarden(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Warden(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createAllay(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Allay(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createFrog(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Frog(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createTadpole(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Tadpole(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createTraderLlama(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new TraderLlama(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createGhast(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Ghast(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createBlaze(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Blaze(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createShulker(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Shulker(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createVindicator(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Vindicator(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createEvoker(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Evoker(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createVex(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Vex(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createVillager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Villager(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createWanderingTrader(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new WanderingTrader(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createZombieVillager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new ZombieVillager(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPhantom(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Phantom(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createPillager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Pillager(Location::fromObject($pos, $world, $yaw, $pitch));
	}
	public function createRavager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
		return new Ravager(Location::fromObject($pos, $world, $yaw, $pitch));
	}
}