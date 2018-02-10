<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/7
 * Time: 16:01
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs',
    ];

    protected $message = [
        'ids' => 'ids 参数必须是以逗号分隔的多个正整数',
    ];

    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($value)) {
            return falase;
        }

        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }

        return true;
    }
}