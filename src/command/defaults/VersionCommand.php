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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\VersionInfo;
use function count;
use function implode;
use function sprintf;
use function stripos;
use function strtolower;
use const PHP_VERSION;

class VersionCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			KnownTranslationFactory::pocketmine_command_version_description(),
			KnownTranslationFactory::pocketmine_command_version_usage(),
			["ver", "about"]
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_VERSION);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			$versionw = VersionInfo::ALTAY_VERSION;
			$sender->sendMessage("§f*** §cAltay§c v{$versionw} §f***");
			$sender->sendMessage("§c* §fSupported Minecraft Bedrock Edition Versions: §c". ProtocolInfo::MINECRAFT_VERSION . "");
			$sender->sendMessage("§c* §fOS: §c".Utils::getOS()."");
			$sender->sendMessage("§c* §f@Altay Team");
			$sender->sendMessage("§f*** §cAltay§c v{$versionw} §f***");

			$jitMode = Utils::getOpcacheJitMode();
			if($jitMode !== null){
				if($jitMode !== 0){
					$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitEnabled(sprintf("CRTO: %d", $jitMode));
				}else{
					$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitDisabled();
				}
			}else{
				$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitNotSupported();
			}
			
		}else{
			$pluginName = implode(" ", $args);
			$exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);

			if($exactPlugin instanceof Plugin){
				

				return true;
			}

			$found = false;
			$pluginName = strtolower($pluginName);
			foreach($sender->getServer()->getPluginManager()->getPlugins() as $plugin){
				if(stripos($plugin->getName(), $pluginName) !== false){
					$found = true;
				}
			}

			if(!$found){
				
			}
		}

		return true;
	}
}
