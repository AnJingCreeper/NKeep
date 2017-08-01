namespace Nkeep;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
class Main extends PluginBase implements Listener
{
	public function onEnable(){
		$this->getLogger()->info(TextFormat::LIGHT_PURPLE."新版死亡不掉落插件");
		$this->getLogger()->info(TextFormat::GREEN."作者：安静");
		$this->getLogger()->info(TextFormat::GOLD."该插件为最新版死亡不掉落插件，插件加载成功后，默认自动开启物品不掉落和经验不掉落，该插件由DBRT成员安静制作，未经允许不得转载！");
		$this->getLogger()->info(TextFormat::LIGHT_PURPLE."插件加载中！");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getLogger()->info(TextFormat::BLUE."插件加载完毕！");
		if(!is_dir($this->getDataFolder()))
		{
			mkdir($this->getDataFolder());
		}
		$this->saveDefaultConfig();
		$this->cfg=$this->getConfig();
		$this->reloadConfig();
		if($this->getConfig()->get("keep-experience")==true)
		{
			$this->getLogger()->info(TextFormat::GREEN."已开启死亡经验不掉落！");
		}
		else
		{
			$this->getLogger()->info(TextFormat::RED."已关闭死亡经验不掉落！");

		}
		if($this->getConfig()->get("keep-inventory")==true)
		{
			$this->getLogger()->info(TextFormat::GREEN."已开启死亡物品不掉落！");
		}
		else
		{
			$this->getLogger()->info(TextFormat::RED."已关闭死亡物品不掉落！");

		}
		
	}
	public function onCommand(CommandSender $sender,Command $cmd,$label,array $args)
	{
		switch($cmd->getName())
		{
			case "keepinventory":
			if(isset($args[0]))
			{
				if($args[0]=="true")
				{
					$this->getConfig()->set("keep-inventory",true);
					$this->getConfig()->save();
					$this->getConfig()->reload();
					$this->getServer()->broadcastMessage(TextFormat::GREEN."[Nkeep]已开启死亡物品不掉落！");


				}
				elseif($args[0]=="false")
				{
					$this->getConfig()->set("keep-inventory",false);
					$this->getConfig()->save();
					$this->getConfig()->reload();
					$this->getServer()->broadcastMessage(TextFormat::RED."[Nkeep]已关闭死亡物品不掉落！");

				}
				else
				{
					$sender->sendMessage(TextFormat::RED."[Nkeep]指令输入错误！");
				}
			}
			break;
			case "keepexperience":
			if(isset($args[0]))
			{
				if($args[0]=="true")
				{
					$this->getConfig()->set("keep-experience",true);
					$this->getConfig()->save();
					$this->getConfig()->reload();
					$this->getServer()->broadcastMessage(TextFormat::GREEN."[Nkeep]已开启死亡经验不掉落！");

				}
				elseif($args[0]=="false")
				{
					$this->getConfig()->set("keep-experience",false);
					$this->getConfig()->save();
					$this->getConfig()->reload();
					$this->getServer()->broadcastMessage(TextFormat::RED."[Nkeep]已关闭死亡经验不掉落！");
				}
				else
				{
					$sender->sendMessage(TextFormat::RED."[Nkeep]指令输入错误！");
				}
			}
		}
	}
	public function KeepInventory(PlayerDeathEvent $event){
		$c=$this->getConfig()->get("keep-experience");
		$d=$this->getConfig()->get("keep-inventory");
		$event->setKeepInventory("$d");
		$event->setKeepExperience("$c");
	}
		
}
?>
