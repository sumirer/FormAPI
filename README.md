#FormApi
****
##Info
 This plugin is base on pmmp Project\
 you can use this plugin send Form(GUI)\
 to player,and you can use Event listener to\
 handle event
##How To Use
Fast,you can download zip source file,load this plugin
```php
use sole\memory\form\Main;
```
and you can use API
```php
  /**
     * send message to player
     * @param Message $message
     * @param int $type see @Message
     * @param array $range if type is SEND_RANGE,need put player name(string)
     * @param array $backData  this array can get in see @PlayerCheckWaitEvent,if not needback,not use this value
     */
    public function handler(Message $message, $type, array $range=[],$backData = []){
        $this->handler->createMessage($message,$type,$range,$backData);
    }

    /**
     * @return MessageHandler
     */
    public function getMessageHandler(){
        return $this->handler;
    }

    /**
     * use this plugin please set this value
     * this can stop message handler send message
     * @param Player $player
     * @return bool
     */
    public function inUse(Player $player){
        return $this->inUse[$player->getName()];
    }

    /**
     * on not use other,please set $inUse is false
     * @param Player $player
     * @param bool $use
     */
    public function setUse(Player $player,bool $use){
        $this->inUse[$player->getName()] = $use;
    }
```
##How To Use Form(UI)
****
This is an example.
###CustomForm
```php
        $list = [];
        $list[] = new Label('test_text');
        $list[] = new Input('input','placeholder','def');
        $list[] = new DorpDown(['A','B'],1);
        $list[] = new Toggle('text',false);
        $list[] = new Slider($text, float $min, $max, $step, $default)
        $player->sendForm(new CustomForm('test',$list));
```
###SimpleForm
```php
       $list = [
           'A','B','C','D'
       ];
       $row = [];
       foreach ($list as $v){
           $row[] = new ElementButton($v,false);
       }
       return new SimpleForm('title','content_text',$row);
```
###ModelForm
```php
       $player->sendForm(new ModelForm('title',$text,'yes','no'));
```
****
#How to Handle Event
****
listener this event
```php
use sole\memory\form\event\PlayerResponseFormEvent;
```
this event back this value
```php
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
```
`getFormData()` is back handle Form
`getBackData()` is back data

#Message Server
****
this system can do something in UI
for example
```php
        $msg = new Message('player_name or Other string');
        $msg->type = Message::SEND_RANGE;
        $msg->msg = 'test';
        $msg->needBack = true;
        Main::getInstance()->handler($msg,['A','B'],['type'=>1,'msg'=>'hello']);
```
can send ui for A and B,`needBack`is back msg,if set this`true`,you can do
```php

    public function onPlayerCheckWait(PlayerCheckWaitEvent $event){
        $data = $event->getData();
        $chick = $event->getChick();
        if ($chick){
            $event->getPlayer()->sendMessage($data['msg']);
        }
    }
```
A and B chick yes button ,sendMessage 'hello' to A and B
#Problem
****
this plugin is not test,if you find bugs\
you can Email:1668961992@qq.com\
or push issues
