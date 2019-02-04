<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:17
 */

namespace sole\memory\form\ui;


use sole\memory\form\ui\elements\ElementButton;

class SimpleForm extends MainUI
{


    /** @var string */
    protected $content;

    private $options;

    /**@var ElementButton*/
    private $choice;



    public function __construct(string $title, string $text, array $options){
        parent::__construct($title);
        $this->content = $text;
        $this->options = array_values($options);
    }
    public function getType() : string{
        return MainUI::TYPE_SIMPLE;
    }

    public function setChoice($index){
        $this->choice = $this->content[$index];
    }

    /**
     * @return ElementButton
     */
    public function getChoice(): ElementButton
    {
        return $this->choice;
    }

    public function serializeFormData() : array{
        return [
            "content" => $this->content,
            "buttons" => $this->options //yes, this is intended (MCPE calls them buttons)
        ];
    }
}
