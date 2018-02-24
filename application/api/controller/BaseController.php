<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/24
 * Time: 16:55
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}