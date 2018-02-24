<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/20
 * Time: 17:52
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = '10001';
}