<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:58
 */

namespace sole\memory\form\message;


use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use sole\memory\EPMemory\task\MessageTask;
use sole\memory\form\listener\EventListener;
use sole\memory\form\Main;
use sole\memory\form\ui\ModelForm;

class MessageHandler
{

    /**@var Message[]*/
    public $messageList = [];
    public $plugin;
    public static $waitList = [];

    public static $isSend = [];
    private static $self;


    public function __construct(Main $main)
    {
        $this->plugin = $main;
        self::$self = $this;
        //start message send task
        $main->getScheduler()->scheduleRepeatingTask(new MessageTask($main),5);
    }

    public static function getInstance(){
        return self::$self;
    }

    public function init(){
        $cfg = (new Config($this->plugin->getDataFolder().'/data/MessageData.yml',Config::YAML))->getAll();
        foreach ($cfg as $item){
            $this->addToList((new Message($item['player']))->putArray($item),true);

        }
    }

    public function createMessage(Message $message,$range,$data){
        switch ($message->getType()){
            case Message::SEND_ALL:
                foreach (Server::getInstance()->getOnlinePlayers() as $player){
                    $message->updateHash($player->getName());
                    if ($message->needBack){
                        $this->addToWaitList($player,$message->getHash());
                        $this->saveWait($player,$data);
                    }
                    $this->addToList($message);
                }
                break;
            case Message::SEND_ONE:
                if ($message->needBack){
                    $this->addToWaitList($message->getPlayer(),$message->getHash());
                    $this->saveWait($message->getPlayer(),$data);
                }
                $this->addToList($message);
                break;
            case Message::SEND_RANGE:
                foreach ($range as $k){
                    $message->updateHash($k);
                    if ($message->needBack){
                        $this->addToWaitList($k,$message->getHash());
                        $this->saveWait($k,$data);
                    }
                    $this->addToList($message);
                }
                break;
            default:
                new \TypeError('type: '.$message->getType().' not found');
        }
    }

    public function addToList(Message $message,$init = false){
        if (!$init) {
            $this->saveToFile($message);
        }
        $this->messageList[] = $message;
    }

    public function saveToFile(Message $message){
        $c = new Config($this->plugin->getDataFolder().'/data/MessageData.yml',Config::YAML);
        $cfg = $c->getAll();
        $cfg[] = $message->getArray();
        $c->setAll($cfg);
        $c->save();
        unset($c,$cfg);
    }

    public function delMessage($hash){
        foreach ($this->messageList as $ks=>$value){
            if ($value->getHash() == $hash){
                unset($this->messageList[$ks]);
                break;
            }
        }
        $c = new Config($this->plugin->getDataFolder().'/data/MessageData.yml',Config::YAML);
        $cfg = $c->getAll();
        foreach ($cfg as $k=>$item){
            if ($item['hash'] == $hash){
                unset($cfg[$k]);
                break;
            }
        }
        $c->setAll($cfg);
        $c->save();
        unset($c,$cfg);
    }

    public function sendMessage()
    {
        foreach ($this->messageList as $key => $message) {
            /**@var Player */
            $player = Server::getInstance()->getPlayer($message->getPlayer());
            if ($player == null) continue;

            if (!$this->checkPlayerOpenWindow($player)) {
                if (self::isSend($player)) return;
                self::$isSend[$player->getName()] = true;
                if ($message->needBack and !$message->wait) {
                    $message->wait = true;
                    $this->addToWaitList($player, $message->getHash());
                } else {
                    //msg is send,wait player check
                    return;
                }
                $player->sendForm(new ModelForm('MSG', $message->msg, "确定", '取消'));
            } else {
                //player open window ,now can't send form
                return;
            }
            //is not wait message,send and del it
            if (!self::inWaitFile($player->getName()) and !$message->needBack) {
                $this->delMessage($message->getHash());
            }
        }

    }

    public function checkPlayerOpenWindow(Player $player){
        return Main::getInstance()->inUse($player);
    }

    public static function isSend($player){
        if ($player instanceof Player){
            $player = $player->getName();
        }
        return isset(self::$isSend[$player]);
    }

    public static function noSend($player){
        if ($player instanceof Player){
            $player = $player->getName();
        }
        unset(self::$isSend[$player]);
    }

    public static function inWaitFile($player){
        $cfg = new Config(Main::getInstance()->getDataFolder().'/data/WaitData.yml',Config::YAML);
        return $cfg->exists($player,true);
    }

    public static function setNoWait($player){
        if ($player instanceof Player){
            $player = $player->getName();
        }
        $cfg = new Config(Main::getInstance()->getDataFolder().'/data/WaitData.yml',Config::YAML);
        $cfg->remove(strtolower($player));
        $cfg->save();
        unset(self::$isSend[$player]);
    }



    //存入要处理的数组，事件会返回data
    public function addToWaitList($player,$hash){
        if ($player instanceof Player){
            $player = $player->getName();
        }
        $player = strtolower($player);
        self::$waitList[$player] = $hash;
         //$this->saveWait($player,$data);
    }


    public function saveWait($player,$data){
        $cfg = new Config(Main::getInstance()->getDataFolder().'/data/WaitData.yml',Config::YAML);
        $cfg->set(strtolower($player),$data);
        $cfg->save();
    }

    public static function getWaitData($player){
        if ($player instanceof Player){
            $player = $player->getName();
        }
        $cfg = new Config(Main::getInstance()->getDataFolder().'/data/WaitData.yml',Config::YAML);
        return $cfg->get(strtolower($player),null);
    }

    public function getMessageList(){
        return $this->messageList;
    }

    public function reSetNeedBackMessage(Player $player){
        foreach ($this->messageList as $k=>$value){
            if ($value->getHash() == self::$waitList[$player->getName()]){
                $this->messageList[$k]->wait = false;
                break;
            }
        }
    }

    public static function clearWait(Player $player){
        unset(self::$waitList[$player->getName()]);
    }
}