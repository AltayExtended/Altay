<?php

namespace pocketmine\altay;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class Session{

	public static function playSound(Player|Vector3 $player, string $sound, float $pitch = 1, float $volume = 1, bool $packet = false): ?DataPacket{
		$pos = $player instanceof Player ? $player->getPosition() : $player;
		$pk = new PlaySoundPacket();
		$pk->soundName = $sound;
		$pk->x = $pos->x;
		$pk->y = $pos->y;
		$pk->z = $pos->z;
		$pk->pitch = $pitch;
		$pk->volume = $volume;
		if($packet){
			return $pk;
		}elseif($player instanceof Player){
			$player->getNetworkSession()->sendDataPacket($pk);
		}
		return null;
	}
}