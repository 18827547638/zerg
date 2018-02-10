<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/10
 * Time: 15:51
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];
}