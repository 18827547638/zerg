<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/12
 * Time: 23:09
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token 已过期或无效 Token';
    public $errorCode = 10001;
}