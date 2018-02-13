<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/12
 * Time: 20:34
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有 code 还想获取 Token, 做梦哦'
    ];
}