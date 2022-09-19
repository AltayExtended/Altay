<?php

namespace Altay\AltayDepends;

use Altay\AltayDepends\loader\BlockTileLoader;
use Altay\AltayDepends\loader\BlockLoader;
use Altay\AltayDepends\loader\ItemBlockLoader;

use Altay\AltayDepends\loader\Loader;
use Altay\AltayDepends\block\BlockTable;
use Altay\AltayDepends\block\BlockIds;
use Altay\AltayDepends\item\LegacyItemIds;

use pocketmine\block\Stair;
use pocketmine\block\Slab;
use pocketmine\block\Wall;

use pocketmine\block\Block;
use pocketmine\block\BlockTypeInfo as Info;
use pocketmine\block\BlockBreakInfo as BreakInfo;

use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockIdentifierFlattened;
use pocketmine\block\BlockLegacyIds as Ids;

use pocketmine\block\BlockToolType as ToolType;
use pocketmine\block\Opaque;
use pocketmine\inventory\CreativeInventory;

use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemFactory;

use pocketmine\item\ToolTier;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\scheduler\AsyncTask;
use ReflectionMethod;
use Closure;

use pocketmine\block\DeepslateDiamondOre;
use pocketmine\block\DeepslateIronOre;
use pocketmine\block\DeepslateRedstoneOre;
use pocketmine\block\DeepslateGoldOre;
use pocketmine\block\DeepslateEmeraldOre;
use pocketmine\block\DeepslateCoalOre;
use pocketmine\block\DeepslateLapisOre;
use pocketmine\block\DeepslateCopperOre;

class Main extends PluginBase implements Listener
{

	private static bool $callEvent = false;

	private array $loader = [];

	public function onLoad(): void
	{

		$this->getLogger()->info("§cAltay is being established..");

		$this->save();
		$this->load();
		self::registerMappings();

		$this->getServer()->getAsyncPool()->addWorkerStartHook(function (int $worker): void {
			$this->getServer()->getAsyncPool()->submitTaskToWorker(new class extends AsyncTask {
				public function onRun(): void
				{
					Main::registerMappings();
				}
			}, $worker);
		});

	}

	public function onEnable(): void
	{

		$this->getLogger()->info("§cAltay installation completed successfully!");

	}

	private function addBlock(string $name, Block $block, bool $addCreative = false): void
	{
		$this->loader[] = new BlockLoader($name, $block, $addCreative);
	}

	private function addItemBlock(string $name, int $blockId, ItemIdentifier $identifier): void
	{
		$this->loader[] = new ItemBlockLoader($name, $blockId, $identifier);
	}

	private function addBlockTile(string $name, string $className, array $saveNames): void
	{
		$this->loader[] = new BlockTileLoader($name, $className, $saveNames);
	}

	private function load(): void
	{
		$config = $this->getConfig();
		for ($i = 0; $i < count($this->loader); $i++) {
			$loader = $this->loader[$i];
			if ($config->getNested("k." . $loader->getName(), true)) $loader->load();
		}
	}

	public static function registerMappings(): void
	{
		$mapping = RuntimeBlockMapping::getInstance();
		$update = $mapping->toRuntimeId(Ids::INFO_UPDATE << Block::INTERNAL_METADATA_BITS);
		$table = BlockTable::getInstance();
		$method = new ReflectionMethod(RuntimeBlockMapping::class, "registerMapping");
		$method->setAccessible(true);
		foreach ($mapping->getBedrockKnownStates() as $runtimeId => $tag) {
			$name = $tag->getString("name");
			if (!$table->existsId($name)) continue;

			$id = $table->getId($name);
			$states = $tag->getCompoundTag("states");
			$damage = $table->getDamage($id, $states);
			if ($mapping->toRuntimeId(($id << Block::INTERNAL_METADATA_BITS) | $damage) !== $update) continue;

			$method->invoke($mapping, $runtimeId, $id, $damage);
		}
	}

	public static function isCallEvent(): bool
	{
		return self::$callEvent;
	}

	public function save()
	{

		$this->addBlock("deepslate_diamond_ore", new DeepslateDiamondOre(new BlockIdentifier(560, 0, -405), "Deepslate Diamond Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::IRON()->getHarvestLevel())));
		$this->addItemBlock("deepslate_diamond_ore", 560, new ItemIdentifier(-405, 0));


		$this->addBlock("deepslate_iron_ore", new DeepslateIronOre(new BlockIdentifier(561, 0, -401), "Deepslate Iron Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel())));
		$this->addItemBlock("deepslate_iron_ore", 561, new ItemIdentifier(-401, 0));

		$this->addBlock("deepslate_redstone_ore", new DeepslateRedstoneOre(new BlockIdentifier(562, 0, -403), "Deepslate Redstone Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::IRON()->getHarvestLevel())));
		$this->addItemBlock("deepslate_redstone_ore", 562, new ItemIdentifier(-403, 0));

		$this->addBlock("deepslate_gold_ore", new DeepslateGoldOre(new BlockIdentifier(563, 0, -402), "Deepslate Gold Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::IRON()->getHarvestLevel())));
		$this->addItemBlock("deepslate_gold_ore", 563, new ItemIdentifier(-402, 0));

		$this->addBlock("deepslate_emerald_ore", new DeepslateEmeraldOre(new BlockIdentifier(564, 0, -407), "Deepslate Emerald Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::IRON()->getHarvestLevel())));
		$this->addItemBlock("deepslate_emerald_ore", 564, new ItemIdentifier(-407, 0));

		$this->addBlock("deepslate_lapis_ore", new DeepslateLapisOre(new BlockIdentifier(565, 0, -400), "Deepslate Lapis Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::IRON()->getHarvestLevel())));
		$this->addItemBlock("deepslate_lapis_ore", 565, new ItemIdentifier(-400, 0));

		$this->addBlock("deepslate_copper_ore", new DeepslateCopperOre(new BlockIdentifier(566, 0, -408), "Deepslate Copper Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::STONE()->getHarvestLevel())));
		$this->addItemBlock("deepslate_copper_ore", 566, new ItemIdentifier(-408, 0));

		$this->addBlock("deepslate_coal_ore", new DeepslateCoalOre(new BlockIdentifier(567, 0, -406), "Deepslate Coal Ore", new BreakInfo(4.5, ToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel())));
		$this->addItemBlock("deepslate_coal_ore", 567, new ItemIdentifier(-406, 0));


	}
}