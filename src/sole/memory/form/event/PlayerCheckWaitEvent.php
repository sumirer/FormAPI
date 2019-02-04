<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/15
 * Time: 14:41
 */

namespace sole\memory\EPMemory\event;


use pocketmine\Player;
use sole\memory\form\event\Event;

class PlayerCheckWaitEvent extends Event
{

    private $chick = false;
    private $data;
    public function __construct(Player $player,$chickButton,$data)
    {
        $this->chick = $chickButton;
        $this->data = $data;
        parent::__construct($player);
    }



    /**@return boolean*/
    public function getChick(){
        return $this->chick;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
