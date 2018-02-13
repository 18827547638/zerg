<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/12
 * Time: 21:09
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}