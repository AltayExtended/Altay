<?php

declare(strict_types=1);

namespace pocketmine\depends\FolderPluginLoader;

use Webmozart\PathUtil\Path;
use pocketmine\Server;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;
use function file_exists;
use function file_get_contents;
use function is_dir;
use function realpath;

class LoadAltayPlugin implements PluginLoader
{

	/** @var \DynamicClassLoader */
	private $loader;

	public function __construct(\DynamicClassLoader $loader)
	{
		$this->loader = $loader;
	}

	public function canLoadPlugin(string $path): bool
	{
		$path2 = Server::getInstance()->getFilePath() . "src/depends/plugins/Altay";
		if (Server::getInstance()->getPluginManager()->getPlugin("Altay") === null) {


			return is_dir($path2) and file_exists($path2 . "/plugin.yml") and file_exists($path2 . "/src/");
		}
	}

	/**
	 * Loads the plugin contained in $file
	 */
	public function loadPlugin(string $file): void
	{
		$file2 = Server::getInstance()->getFilePath() . "src/depends/plugins/Altay";
		$description = $this->getPluginDescription($file2);
		if ($description !== null) {
			if (Server::getInstance()->getPluginManager()->getPlugin("Altay") === null) {
				$this->loader->addPath($description->getSrcNamespacePrefix(), "$file2/src");
			}
		}
	}

	/**
	 * Gets the PluginDescription from the file
	 */
	public function getPluginDescription(string $file): ?PluginDescription
	{
		$file2 = Server::getInstance()->getFilePath() . "src/depends/plugins/Altay";
		if (is_dir($file2) and file_exists($file2 . "/plugin.yml")) {
			$yaml = @file_get_contents($file2 . "/plugin.yml");
			if ($yaml != "") {
				return new PluginDescription($yaml);
			}
		}

		return null;
	}

	public function getAccessProtocol(): string
	{
		return "";
	}
}