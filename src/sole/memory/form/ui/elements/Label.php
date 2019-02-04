<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:00
 */

namespace sole\memory\form\ui\elements;


class Label extends CustomElement
{
    public function getType() : string{
        return "label";
    }
    public function getValue(){
        return null;
    }
    public function setValue($value) : void{
        assert($value === null);
    }
    public function serializeElementData() : array{
        return [];
    }
}
