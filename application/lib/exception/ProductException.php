<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/10
 * Time: 15:59
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定的商品不存在, 请检查参数';
    public $errorCode = '20000';
}