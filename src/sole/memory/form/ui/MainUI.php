<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 15:50
 */

namespace sole\memory\form\ui;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;

class MainUI implements Form
{

    public const TYPE_MODAL = "modal";
    public const TYPE_SIMPLE = "form";
    public const TYPE_CUSTOM_FORM = "custom_form";
    protected $type;

    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Handles a form response from a player.
     *
     * @param Player $player
     * @param mixed $data
     *
     * @throws FormValidationException if the data could not be processed
     */
    public function handleResponse(Player $player, $data): void
    {

        // TODO: Implement handleResponse() method.
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $jsonBase = [
            "type" => $this->getType(),
            "title" => $this->title
        ];
        return array_merge($jsonBase, $this->serializeFormData());
    }


    public function getType(){
        return $this->type;
    }


    public function serializeFormData(): array
    {
        return [];
        // TODO: Implement serializeFormData() method.
    }
}
