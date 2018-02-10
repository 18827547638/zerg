<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/7
 * Time: 16:18
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '指定主题不存在, 请检查主题 ID';
    public $errorCode = 300000;
}