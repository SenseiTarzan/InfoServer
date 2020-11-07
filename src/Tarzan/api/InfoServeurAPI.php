<?php


namespace Tarzan\api;

use pocketmine\Player;
use pocketmine\Server;
use Tarzan\api\FormAPI\CustomForm;
use Tarzan\api\FormAPI\SimpleForm;

class InfoServeurAPI
{

    public function getUiIndexIfoServer(Player $player)
    {
        $ui = new CustomForm(function (Player $player, $data) {
            if ($data === null) {
                return;
            }
            $ip = !is_null($data[0]) ? $data[0] : Server::getInstance()->getIp();
            $port = !is_null($data[1]) ? $data[1] : Server::getInstance()->getPort();
            $merge = $ip . ":" . $port;
            $this->getUiInfoServer($player, $merge);
        });

        $ui->setTitle("InfoServeur Index");
        $ui->addInput("ip:", Server::getInstance()->getIp(), Server::getInstance()->getIp());
        $ui->addInput("port:", Server::getInstance()->getPort(), Server::getInstance()->getPort());
        $player->sendForm($ui);

    }

    public function getUiInfoServer(Player $player, string $address)
    {
        $ssl = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $mcapi = json_decode(file_get_contents("https://api.mcsrvstat.us/2/{$address}", false, stream_context_create($ssl)),JSON_OBJECT_AS_ARRAY);
        $ui = new SimpleForm(function (Player $player, $data) use ($mcapi) {
            if ($data === null) {
                return;
            }
        });
        $ui->setTitle("InfoServeur of " . $mcapi["hostname"]);
        $playerlist = isset($mcapi["players"]["list"]) ? count($mcapi["players"]["list"]) === 0 ? "" : implode("\n§f-§4",$mcapi["players"]["list"]) : "";
        $pluginlist =  isset($mcapi["plugins"]["raw"]) ? count($mcapi["plugins"]["raw"]) === 0 ? "" : implode("\n§f-§4",$mcapi["plugins"]["raw"]) : "";
        $plugincount =  isset($mcapi["plugins"]["raw"]) ? count($mcapi["plugins"]["raw"]): "cache";
        $ui->setContent($mcapi["online"] ? "Info: " . $mcapi["hostname"] . "\nPlayer Online: " . $mcapi["players"]["online"] . "/" . $mcapi["players"]["max"] . "\nMOTD: " . implode("\n§f-§4", $mcapi["motd"]["clean"]) . "\nVersion: " . $mcapi["version"] . "\nOnline: " . $mcapi["online"] . "\nSoftware: " . $mcapi["software"] . "\nPlayer List:\n§f-§4" . $playerlist. "\n§rPlugin({$plugincount}):\n§f-§4" . $pluginlist: "\nServer Close !!");
        $ui->addButton("Return");
        $player->sendForm($ui);

    }
}
