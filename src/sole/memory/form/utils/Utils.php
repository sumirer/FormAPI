<?php
/**
 * Created by PhpStorm.
 * User: solememory
 * Date: 19-2-4
 * Time: 下午12:51
 */

namespace sole\memory\form\utils;


use sole\memory\form\ui\CustomForm;
use sole\memory\form\ui\elements\CustomElement;
use sole\memory\form\ui\elements\DropDown;
use sole\memory\form\ui\elements\ElementButton;
use sole\memory\form\ui\elements\Input;
use sole\memory\form\ui\elements\Label;
use sole\memory\form\ui\elements\Slider;
use sole\memory\form\ui\elements\StepSlider;
use sole\memory\form\ui\elements\Toggle;
use sole\memory\form\ui\MainUI;
use sole\memory\form\ui\ModelForm;
use sole\memory\form\ui\SimpleForm;

class Utils
{

    /**
     * form data to class
     * @param array $ary
     * @return array
     */
    public static function arrayToStdClassArray(array $ary){
        $contentArray = [];
        $contentArray['type'] = $ary['type'];
        switch ($ary['type']){
            case MainUI::TYPE_SIMPLE:
                //ElementButton
                $list = [];
                foreach ($ary as $k=>$item){
                    $list[$k] = new ElementButton($item,isset($item['image']),isset($item['image'])?$item['image']:null);
                }
                $contentArray['content'] = new SimpleForm($ary['title'],$ary['text'],$list);
                break;
            case MainUI::TYPE_CUSTOM_FORM:
                $content = [];
                foreach ($ary['content'] as $k=>$value){
                    switch ($value['type']){
                        case 'dropdown':
                            $content[$k] = new DropDown($value['text'],$value['options'],$value['default']);
                            break;
                        case 'input':
                            $content[$k] = new Input($value['text'],$value['placeholder'],$value['default']);
                            break;
                        case 'label':
                            $content[$k] = new Label($value['text']);
                            break;
                        case 'slider':
                            $content[$k] = new Slider($value['text'],$value['mim'],$value['max'],$value['step'],$value['default']);
                            break;
                        case 'step_slider':
                            $content[$k] = new StepSlider($value['text'],$value['steps'],$value['default']);
                            break;
                        case 'toggle':
                            $content[$k] = new Toggle($value['text'],$value['default']);
                            break;
                        default:
                            new \RuntimeException('Content type not found on '.$value['type']);
                    }
                }
                $contentArray['content'] = new CustomForm($ary['title'],$content);
                break;
            case MainUI::TYPE_MODAL:
                $contentArray = new ModelForm($ary['title'],$ary['content'],$ary['button1'],$ary['button2']);
                break;
        }
        return $contentArray;
    }

    /**
     * update form data on choice,and back new form list
     * @param array $needArray is save form class list
     * @param array|int|boolean $update is form back data
     * @return array
     */
    public static function updateElementAction(array $needArray, $update){
        switch ($needArray['type']){
            //set content tp chick button element,$update is int type
            case MainUI::TYPE_SIMPLE:
                /**@var SimpleForm $simple*/
                $simple = $needArray['content'];
                $simple->setChoice($update);
                $needArray['content'] = $simple;
                break;
            case MainUI::TYPE_CUSTOM_FORM:
                /**@var CustomForm $custom*/
                $custom = $needArray['content'];
                $list = $custom->getElementList();
                /**@var CustomElement $value*/
                foreach ($list as $k=>$value){
                    $value->setValue($update[$k]);
                    $list[$k] = $value;
                }
                $custom->setElementList($list);
                $needArray['content'] = $custom;
                break;
            case MainUI::TYPE_MODAL:
                /**@var ModelForm $model*/
                $model = $needArray['content'];
                $model->setChoice((boolean)$update);
                $needArray['content'] = $model;
                break;

        }
        return $needArray;
    }
}