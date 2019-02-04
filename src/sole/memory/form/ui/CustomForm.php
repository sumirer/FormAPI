<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:07
 */

namespace sole\memory\form\ui;


use sole\memory\form\ui\elements\CustomElement;

class CustomForm extends MainUI
{

    /**@var CustomElement[]*/
    private $elements;

    public function __construct(string $title, array $elements){
        parent::__construct($title);
        $this->title = $title;
        $this->elements = array_values($elements);
    }
    /**
     * @return string
     */
    public function getType() : string{
        return MainUI::TYPE_CUSTOM_FORM;
    }

    /**
     * @return array|CustomElement[]
     */
    public function getElementList(){
        return $this->elements;
    }

    public function setElementList(array $list){
        $this->elements = $list;
    }

    /**
     * @param int $index
     * @return CustomElement
     */
    public function getElementByIndex(int $index){
        return $this->elements[$index];
    }


    public function serializeFormData() : array{
        return [
            "content" => $this->elements
        ];
    }
}
