<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:52
 */

namespace sole\memory\form\message;


use pocketmine\Player;

class Message
{


    const SEND_ALL = 1;
    const SEND_ONE = 2;
    const SEND_RANGE = 3;


    public $msg;


    public $player;

    public $hash;
    public $type;

    public $wait = false;

    public $needBack = false;

    public function __construct($player)
    {
        if ($player instanceof Player){
            $player = $player->getName();
        }
        $this->player = $player;
        $this->hash = md5(time().$player);
    }

    public function getType(){
        return $this->type;
    }

    public function updateHash($player){
        $this->hash = md5(time().$player);
        $this->player = $player;
    }
    public function getMessage(){
        return $this->msg;
    }


    public function getPlayer(){
        return strtolower($this->player);
    }


    public function getHash(){
        return $this->hash;
    }

    public function getArray(){
        return [
            'player'=>$this->getPlayer(),
            'type'=>$this->type,
            'msg'=>$this->msg,
            'needBack'=>$this->needBack,
            'hash'=>md5(time().$this->player),
            'clear'=>time()+7*24*60*60
        ];
    }

    public function putArray($a){
        $this->msg = $a['msg'];
        $this->type = $a['type'];
        $this->player = $a['player'];
        $this->needBack = $a['needBack'];
        $this->hash = $a['hash'];
        return $this;
    }
}