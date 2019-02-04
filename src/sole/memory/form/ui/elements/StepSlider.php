<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:02
 */

namespace sole\memory\form\ui\elements;


class StepSlider extends DropDown
{
    public function getType() : string{
        return "step_slider";
    }
    public function serializeElementData() : array{
        return [
            "steps" => $this->options,
            "default" => $this->defaultOptionIndex
        ];
    }
}
