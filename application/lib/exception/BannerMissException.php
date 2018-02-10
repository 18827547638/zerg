<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/29
 * Time: 8:40
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的 Banner 不存在';
    public $errorCode = '40000';
}