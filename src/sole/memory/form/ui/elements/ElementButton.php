<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 17:41
 */

namespace sole\memory\form\ui\elements;


class ElementButton implements \JsonSerializable
{
    private $text = '';
    private $hasImg = false;
    private $url = '';

    public function __construct($text,$hasImg,$url='')
    {
        $this->text = $text;
        $this->hasImg = $hasImg;
        $this->url = $url;
    }


    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isHasImg(): bool
    {
        return $this->hasImg;
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
        $data =  [
            'text'=>$this->text
        ];
        if ($this->hasImg){
            $data['image'] = $this->url;
        }
        return $data;
    }
}
