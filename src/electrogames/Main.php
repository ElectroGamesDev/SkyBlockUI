<?php

namespace electrogames;

use pocketmine\plugin\PluginBase;
use pocketmine\Player; 
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\level\particle\DestroyBlockParticle;
use pocketmine\level\particle\{DustParticle, FlameParticle, FloatingTextParticle, EntityFlameParticle, CriticalParticle, ExplodeParticle, HeartParticle, LavaParticle, MobSpawnParticle, SplashParticle};
use pocketmine\event\player\PlayerMoveEvent;

class Main extends PluginBase implements Listener {
	
	public $plugin;

	public function onEnable(){
		$this->getLogger()->info("SkyBlockUI by Electro Games");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");	
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "skyblockui":
            $this->FormClan($sender);
            return true;
        }
        return true;
	}
	
	 public function FormClan($sender){
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function(Player $sender, $data){
          $result = $data;
          if($result === null){
          }
          switch($result){
              case 0:
              $sender->addTitle("§b§lSkyBlockUI");
              case 1:
			  $this->Create($sender);
              break;
              case 2:
              $command = "is go";
              $this->getServer()->getCommandMap()->dispatch($sender, $command);
              break;
              case 3:
              $command = "f del";
              $this->getServer()->getCommandMap()->dispatch($sender, $command);
              break;
              case 4:
              $command = "is leave";
              $this->getServer()->getCommandMap()->dispatch($sender, $command);
              break;
              case 5:
              $this->Invite($sender);
              break;
              case 6:
              $command = "is lock";
              $this->getServer()->getCommandMap()->dispatch($sender, $command);
              break;
              case 7:
              $this->Kick($sender);
              break;
              case 8:
              $command = "is help";
              $this->getServer()->getCommandMap()->dispatch($sender, $command);
              break;
          }
        });
        $config = $this->getConfig();
        $name = $sender->getName();
        $form->setTitle("§b§lSkyBlock UI");
		$form->addButton("§cBack");
		$form->addButton("§cCreate Island");
		$form->addButton("§cTeleport To Island");
		$form->addButton("§6Delete Island");
		$form->addButton("§eLeave Island");
        $form->addButton("§aInvite");
		$form->addButton("§bLock Island");
		$form->addButton("§dKick");
		$form->addButton("§cHelp");
        $form->sendToPlayer($sender);
	}

	public function Kick($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function(Player $player, $data){
			$result = $data[0];
			if($result === null){
				return true;
			}
			$cmd = "is kick $data[0]";
			$this->getServer()->getCommandMap()->dispatch($player, $cmd);
		});
		$form->setTitle("§b§lSkyBlockUI");
		$form->addInput("§bKick Player");
		$form->sendToPlayer($player);
	}

	
	public function Invite($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function(Player $player, $data){
			$result = $data[0];
			if($result === null){
				return true;
			}
			$cmd = "f invite $data[0]";
			$this->getServer()->getCommandMap()->dispatch($player, $cmd);
		});
		$form->setTitle("§b§lSkyBlockUI");
		$form->addInput("§eInvite Player");
		$form->sendToPlayer($player);
	}
}
