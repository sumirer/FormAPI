<?php
/**
 * Created by PhpStorm.
 * User: SoleMemory
 * Date: 2019/1/13
 * Time: 16:52
 */

namespace sole\memory\form\ui\elements;


class CustomElement implements \JsonSerializable
{


    private $text;
    public function __construct(string $text){
        $this->text = $text;
    }

    /**
     * Returns the element's label. Usually this is used to explain to the user what a control does.
     * @return string
     */
    public function getText() : string{
        return $this->text;
    }

    public function jsonSerialize() : array{
        $data = [
            "type" => $this->getType(),
            "text" => $this->getText()
        ];
        return array_merge($data, $this->serializeElementData());
    }
    /**
     * Returns an array of extra data needed to serialize this element to JSON for showing to a player on a form.
     * @return array
     */


    /**
     * Returns the type of element.
     * @return string
     */
    public function getType(): string
    {
        // TODO: Implement getType() method.
    }

    /**
     * Returns the value of the component after it's been set by a form response from a player.
     * @return mixed
     */
    public function getValue()
    {
        // TODO: Implement getValue() method.
    }

    /**
     * Sets the component's value to the specified argument. This function should do appropriate type checking and throw
     * whatever errors necessary if the type of value is not as expected.
     *
     * @param mixed $value
     * @throws \TypeError
     */
    public function setValue($value): void
    {
        // TODO: Implement setValue() method.
    }

    /**
     * Returns an array of extra data needed to serialize this element to JSON for showing to a player on a form.
     * @return array
     */
    public function serializeElementData(): array
    {
        // TODO: Implement serializeElementData() method.
    }
}
