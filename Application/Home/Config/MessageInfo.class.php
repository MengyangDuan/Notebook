<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/12/8
 * Time: 上午1:27
 */

class MessageInfo
{
    var $state;
    var $object;
    var $message;

    public function __construct($state,$object,$message)
    {
        $this->state = $state;
        $this->object= $object;
        $this->message = $message;
    }
}