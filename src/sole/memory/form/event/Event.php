<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:20
 */

namespace sole\memory\form\event;


use pocketmine\Player;

class Event extends \pocketmine\event\Event
{

    public $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }
}