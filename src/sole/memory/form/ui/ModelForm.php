<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:14
 */

namespace sole\memory\form\ui;


class ModelForm extends MainUI
{
    /** @var string */
    private $content;
    /** @var string */
    private $button1;
    /** @var string */
    private $button2;
    /** @var bool|null */
    private $choice;
    /**
     * @param string $title Text to put on the title of the dialog.
     * @param string $text Text to put in the body.
     * @param string $yesButtonText Text to show on the "Yes" button. Defaults to client-translated "Yes" string.
     * @param string $noButtonText Text to show on the "No" button. Defaults to client-translated "No" string.
     */
    public function __construct(string $title, string $text, string $yesButtonText = "gui.yes", string $noButtonText = "gui.no"){
        parent::__construct($title);
        $this->content = $text;
        $this->button1 = $yesButtonText;
        $this->button2 = $noButtonText;
    }

    public function getType()
    {
        return MainUI::TYPE_MODAL;
    }



    /**
     * @return bool|null
     */
    public function getChoice(): ?bool
    {
        return $this->choice;
    }

    /**
     * get choice button text
     * @return string
     */
    public function getChoiceButtonText():string {
        if ($this->choice == null){
            new \RuntimeException('this function only use of choice');
        }
        return $this->getChoice()?$this->button1:$this->button2;
    }

    /**
     * @return string
     */
    public function getButtonYesText():string {
        return $this->button1;
    }

    /**
     * @return string
     */
    public function getButtonNoText():string {
        return $this->button2;
    }

    /**
     * @param bool|null $choice
     */
    public function setChoice(?bool $choice): void
    {
        $this->choice = $choice;
    }

    public function serializeFormData() : array{
        return [
            "content" => $this->content,
            "button1" => $this->button1,
            "button2" => $this->button2
        ];
    }
}
