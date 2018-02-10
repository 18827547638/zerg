<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 16:11
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取 http 传入的参数
        // 对参数校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $exception = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $exception;
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $filed = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }
}