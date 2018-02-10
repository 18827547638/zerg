<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 15:56
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id 必须是正整数',
    ];
}