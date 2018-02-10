<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/29
 * Time: 10:42
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = '10000';
}