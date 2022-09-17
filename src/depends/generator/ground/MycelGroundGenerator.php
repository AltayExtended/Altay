<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\ground;

use pocketmine\block\VanillaBlocks;

class MycelGroundGenerator extends GroundGenerator{

	public function __construct(){
		parent::__construct(VanillaBlocks::MYCELIUM());
	}
}