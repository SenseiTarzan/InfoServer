<?php


namespace Tarzan\Command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Tarzan\Main;

class InfoServerCommand extends Command
{
    public function __construct()
    {
        parent::__construct("infoserver", "permet de Voir les information Des Serveru saisi");
    }

    /**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            Main::getInfoServer()->getUiIndexIfoServer($sender->getPlayer());
        } else {
            $sender->sendMessage("You must be in Games");
        }
    }
}