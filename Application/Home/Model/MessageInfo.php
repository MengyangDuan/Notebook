<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/11/19
 * Time: 下午12:13
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