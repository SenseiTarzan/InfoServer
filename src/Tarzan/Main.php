<?php


namespace Tarzan;


use pocketmine\plugin\PluginBase;
use Tarzan\api\InfoServeurAPI;
use Tarzan\Command\InfoServerCommand;

class Main extends PluginBase
{

    public static $info_api;

    public function onEnable()
    {
        parent::onEnable();
        $this->getLogger()->info("[InfoServeur] Enable");
        $this->loadCommand();
        self::$info_api = new InfoServeurAPI();
    }


    public function onDisable()
    {
        parent::onEnable();
        $this->getLogger()->info("[InfoServeur] Disable");
    }

    public function loadCommand()
    {
        $this->getServer()->getCommandMap()->register("", new InfoServerCommand());
    }

    public static function getInfoServer(): InfoServeurAPI
    {
        return self::$info_api;
    }
}