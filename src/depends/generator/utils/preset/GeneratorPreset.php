<?php

declare(strict_types=1);

namespace pocketmine\depends\generator\utils\preset;

interface GeneratorPreset{

	public function exists(string $property) : bool;

	public function get(string $property) : mixed;

	public function getInt(string $property) : int;

	public function getFloat(string $property) : float;

	public function getString(string $property) : string;

	public function toString() : string;
}