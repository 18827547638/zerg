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
use app\api\service\WxNotify;
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

    public function redirectNotify()
    {
        // 通知频率 15 15 30 180 1800 1800 1800 1800 3600, 单位: 秒

        // 1. 检测库存量, 超卖
        // 2. 更新订单状态
        // 3. 减库存
        // 如果成功处理, 返回微信成功处理的信息, 否则, 返回没有成功处理
        // 特点: post; xml格式: 不会携带参数

        $notify = new WxNotify();
        $notify->Handle();
    }

    public function receiveNotify()
    {
        // 通知频率 15 15 30 180 1800 1800 1800 1800 3600, 单位: 秒

        // 1. 检测库存量, 超卖
        // 2. 更新订单状态
        // 3. 减库存
        // 如果成功处理, 返回微信成功处理的信息, 否则, 返回没有成功处理
        // 特点: post; xml格式: 不会携带参数

//        $notify = new WxNotify();
//        $notify->Handle();
        $xmlData = file_get_contents('php://input');
        $result = curl_post_raw('http://z.cn/api/v1/pay/re_notify?XDEBUG_SESSION=123', $xmlData);
    }
}