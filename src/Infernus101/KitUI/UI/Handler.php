<?php

namespace Infernus101\KitUI\UI;

use Infernus101\KitUI\Main;
use Infernus101\KitUI\UI\windows\KitMainMenu;
use Infernus101\KitUI\UI\windows\KitInfo;
use Infernus101\KitUI\UI\windows\KitError;
use pocketmine\Player;

class Handler {

	const KIT_MAIN_MENU = 0;
	const KIT_INFO = 1;
	const KIT_ERROR = 2;

	private $types = [
		KitMainMenu::class,
		KitInfo::class,
		KitError::class
	];

	public function getWindowJson($windowId, Main $loader, Player $player){
		return $this->getWindow($windowId, $loader, $player)->getJson();
	}

	public function getWindow($windowId, Main $loader, Player $player){
		if(!isset($this->types[$windowId])) {
			throw new \OutOfBoundsException("Tried to get window of non-existing window ID.");
		}
		return new $this->types[$windowId]($loader, $player);
	}

	public function isInRange($windowId) {
		if(isset($this->types[$windowId]) || isset($this->types[$windowId + 3200])) {
			return true;
		}
		return false;
	}

	public function getWindowIdFor($windowId){
		if($windowId >= 3200) {
			return $windowId - 3200;
		}
		return 3200 + $windowId;
	}
}