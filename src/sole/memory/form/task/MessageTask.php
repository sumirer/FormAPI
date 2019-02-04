<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/14
 * Time: 15:54
 */

namespace sole\memory\EPMemory\task;


use pocketmine\scheduler\Task;
use sole\memory\form\Main;

class MessageTask extends Task
{

    public $plugin;

    public function __construct(Main $main)
    {
        $this->plugin = $main;
    }

    /**
     * Actions to execute when run
     *
     * @param int $currentTick
     *
     * @return void
     */
    public function onRun(int $currentTick)
    {
        $this->plugin->getMessageHandler()->sendMessage();
    }
}
