<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/13
 * Time: 15:31
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 400;
    public $msg = '用户不存在';
    public $errorCode = 600000;
}