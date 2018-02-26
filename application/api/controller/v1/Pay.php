<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/25
 * Time: 13:53
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Pay as PayService;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify()
    {
        // 通知频率 15 15 30 180 1800 1800 1800 1800 3600, 单位: 秒
    }
}