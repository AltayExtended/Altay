<?php

namespace pocketmine\entity\projectile\Fireworks;

use pocketmine\entity\Location;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SendFireworks{

    public function RandomColorToPlayer(Player $player)
    {
            $firework = ItemFactory::getInstance()->get(ItemIds::FIREWORKS);
            $firework->addExplosion(Fireworks::TYPE_HUGE_SPHERE, $this->RandomColor());
            $firework->setFlightDuration(1);
            $entity = new FireworksRocket(Location::fromObject($player->getPosition()->add(0.5, 0, 0.5), $player->getWorld(), lcg_value() * 360, 90), $firework);
            $entity->setMotion(new Vector3(0.001, 0.05, 0.001));
            $entity->spawnToAll();
    }
    public function RandomColor(){
        $rand = rand(1, 10);
        switch ($rand){
            case 1:
                return Fireworks::COLOR_LIGHT_AQUA;
                break;
            case 2:
                return Fireworks::COLOR_RED;
                break;
            case 3:
                return Fireworks::COLOR_YELLOW;
                break;
            case 4:
                return Fireworks::COLOR_DARK_PURPLE;
                break;
            case 5:
                return Fireworks::COLOR_BLUE;
                break;
            case 6:
                return Fireworks::COLOR_BROWN;
                break;
            case 7:
                return Fireworks::COLOR_BLACK;
                break;
            case 8:
                return Fireworks::COLOR_PINK;
                break;
            case 9:
                return Fireworks::COLOR_GOLD;
                breaK;
            case 10:
                return Fireworks::COLOR_GREEN;
                break;
        }
    }
}