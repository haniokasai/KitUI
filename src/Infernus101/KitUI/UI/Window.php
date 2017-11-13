<?php

namespace Infernus101\KitUI\UI;

use Infernus101\KitUI\Main;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;

abstract class Window {

	protected $pl;
	protected $player;
	public static $kit;
	public static $error;
	public static $id = array();
	
	protected $data = [];

	public function __construct(Main $pl, Player $player) {
		$this->pl = $pl;
		$this->player = $player;
		$this->process();
	}

	public function getJson(){
		return json_encode($this->data);
	}

	public function getLoader(){
		return $this->pl;
	}

	public function getPlayer(){
		return $this->player;
	}
	
	public function navigate($menu, Player $player, Handler $windowHandler){
		$packet = new ModalFormRequestPacket();
		$packet->formId = $windowHandler->getWindowIdFor($menu);
		$packet->formData = $windowHandler->getWindowJson($menu, $this->pl, $player);
		$player->dataPacket($packet);
	}
	
	public function navigateKit($menu, Player $player, Handler $windowHandler, $kit){
		self::$kit = $kit;
		$packet = new ModalFormRequestPacket();
		$packet->formId = $windowHandler->getWindowIdFor($menu);
		$packet->formData = $windowHandler->getWindowJson($menu, $this->pl, $player);
		$player->dataPacket($packet);
	}
	
	public function navigateError($menu, Player $player, Handler $windowHandler, $error){
		self::$error = $error;
		$packet = new ModalFormRequestPacket();
		$packet->formId = $windowHandler->getWindowIdFor($menu);
		$packet->formData = $windowHandler->getWindowJson($menu, $this->pl, $player);
		$player->dataPacket($packet);
	}

	protected abstract function process();

	public abstract function handle(ModalFormResponsePacket $packet);
}
