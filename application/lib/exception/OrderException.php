<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/24
 * Time: 17:48
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在, 请检查 ID';
    public $errorCode = '80000';
}