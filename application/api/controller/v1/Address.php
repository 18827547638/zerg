<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/13
 * Time: 14:06
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        // 根据 Token 获取 uid
        // 根据 uid 来查找用户数据, 判断用户是否存在, 如果不存在 抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在, 从而判断是添加还是更新地址

        $uid = TokenService::getCurrentTokenVar('uid');
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }

        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if (!$userAddress) {
            // 新增
            $user->address()->save($dataArray);
        } else {
            // 修改
            $user->address->save($dataArray);
        }
//        return $user;
        return json(new SuccessMessage(), 201);
    }
}