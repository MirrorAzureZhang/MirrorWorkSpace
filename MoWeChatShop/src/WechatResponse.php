<?php
/**
 * Created by PhpStorm.
 * User: duoyi
 * Date: 18-3-15
 * Time: 下午12:00
 */
/**
 * 用于回复的基本消息类型
 */
abstract class WechatResponse {

    protected $toUserName;
    protected $fromUserName;
    protected $funcFlag;
    protected $template;

    public function __construct($toUserName, $fromUserName, $funcFlag) {
        $this->toUserName = $toUserName;
        $this->fromUserName = $fromUserName;
        $this->funcFlag = $funcFlag;
    }

    abstract public function __toString();

}