<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午3:19
 */

namespace sole\memory\form\event;


use pocketmine\Player;
use sole\memory\form\ui\CustomForm;
use sole\memory\form\ui\MainUI;
use sole\memory\form\ui\ModelForm;
use sole\memory\form\ui\SimpleForm;

class PlayerResponseFormEvent extends Event
{

    private $formData;
    private $backData;

    public function __construct(Player $player,MainUI $formData,array $backData)
    {
        parent::__construct($player);
        $this->formData = $formData;
        $this->backData = $backData;
    }

    /**
     * @return SimpleForm|CustomForm|ModelForm
     */
    public function getFormData(): MainUI
    {
        return $this->formData;
    }

    /**
     * this is player chick form ui back data
     * @return array
     */
    public function getBackData(): array
    {
        return $this->backData;
    }
}