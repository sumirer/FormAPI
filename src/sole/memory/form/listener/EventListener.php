<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:03
 */

namespace sole\memory\form\listener;


use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;
use sole\memory\EPMemory\event\PlayerCheckWaitEvent;
use sole\memory\form\event\PlayerResponseFormEvent;
use sole\memory\form\Main;
use sole\memory\form\message\MessageHandler;
use sole\memory\form\utils\Utils;

class EventListener implements Listener
{

    public $formData = [];
    private $compulsory;

    public function __construct(bool $compulsory)
    {
        $this->compulsory = $compulsory;
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event){
        $data = $event->getPacket();
        $player = $event->getPlayer();
        if ($data instanceof ModalFormResponsePacket) {
            //because back form data is null,but string length is 5,
            if (strstr($data->formData, 'null') !== false && strlen($data->formData) == 5) {
                //when form data is null,clare save form data
                $this->close($event->getPlayer());
                return;
            }
            //not send form,and not set in use,run handler make
            if (!isset($this->formData[$player->getName()]) and !Main::getInstance()->inUse($player)){
                $this->handler($event->getPlayer(),$data->formData);
                return;
            }
            //if compulsory use this plugin,maybe can't use other form plugin
            if ($this->compulsory) {
                if (!isset($this->formData[$player->getName()])) {
                    $event->setCancelled();
                    return;
                }
            }
            $elementData = Utils::updateElementAction($this->formData[$player->getName()],$data->formData);
            $ev = new PlayerResponseFormEvent($player,$elementData['type'],$elementData['content']);
            $this->close($player);
            try {
                $ev->call();
            } catch (\ReflectionException $e) {
            }
            if ($ev->isCancelled()){
                $event->isCancelled();
            }
        }
    }

    public function onDataPacketSend(DataPacketSendEvent $event){
        $data = $event->getPacket();
        if ($event->getPlayer() == null){
            return;
        }
        //save send form
        if ($data instanceof ModalFormRequestPacket){
            $this->formData[$event->getPlayer()->getName()] = Utils::arrayToStdClassArray(json_decode($data->formData,true));
        }
    }

    private function close(Player $player){
        unset($this->formData[$player->getName()]);
    }

    public function handler(Player $player,$data)
    {
        if (MessageHandler::$waitList[$player->getName()]) {
            if (strstr($data, 'null') !== false) {
                $event = new PlayerCheckWaitEvent($player, (boolean)$data, MessageHandler::getWaitData($player));
                Main::getInstance()->getMessageHandler()->delMessage(MessageHandler::$waitList[$player->getName()]);
                MessageHandler::setNoWait($player);
                try {
                    $event->call();
                } catch (\ReflectionException $e) {
                }
            } else {
                //reSend message,and set message's wait on false
                Main::getInstance()->getMessageHandler()->reSetNeedBackMessage($player);
                MessageHandler::noSend($player);
            }
            return;
        }
    }
}