<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:39
 */

namespace sole\memory\form;


use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use sole\memory\form\listener\EventListener;
use sole\memory\form\message\Message;
use sole\memory\form\message\MessageHandler;

class Main extends PluginBase
{

    private $compulsory = false;
    private static $self;
    /**@var MessageHandler*/
    private $handler;
    private $inUse = [];

    /**
     * @return Main
     */
    public static function getInstance(){
        return self::$self;
    }

    public function onEnable()
    {
        parent::onEnable();
        self::$self = $this;
        @mkdir($this->getDataFolder(),0777);
        @mkdir($this->getDataFolder().'/data/');
        $this->saveResource('/config.yml',false);
        $this->initModel();
        $this->handler = new MessageHandler($this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this->compulsory),$this);
        $this->getLogger()->info('Form API plugin is enable..');
        if ($this->compulsory){
            $this->getLogger()->warning('This plugin run in Compulsory Mode..');
        }
    }

    private function initModel(){
        $cfg = new Config($this->getDataFolder().'/config.yml',Config::YAML);
        $this->compulsory = (boolean)$cfg->get('Compulsory',false);
        unset($cfg);
    }


    /**
     * send message to player
     * @param Message $message
     * @param array $range if type is SEND_RANGE,need put player name(string)
     * @param array $backData this array can get in see @PlayerCheckWaitEvent,if not needback,not use this value
     */
    public function handler(Message $message,  array $range=[],$backData = []){
        $this->handler->createMessage($message,$range,$backData);
    }

    /**
     * @return MessageHandler
     */
    public function getMessageHandler(){
        return $this->handler;
    }

    /**
     * use this plugin please set this value
     * this can stop message handler send message
     * @param Player $player
     * @return bool
     */
    public function inUse(Player $player){
        return $this->inUse[$player->getName()];
    }

    /**
     * on not use other,please set $inUse is false
     * @param Player $player
     * @param bool $use
     */
    public function setUse(Player $player,bool $use){
        $this->inUse[$player->getName()] = $use;

    }
}