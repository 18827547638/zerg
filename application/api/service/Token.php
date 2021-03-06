<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/12
 * Time: 22:20
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        // 32 个字符串组成一组随机字符串
        $randChars = getRandChar(32);
        // 用三组字符串, 进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt 盐
        $salt = config('secret.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }

            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的 Token 变量并不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        // token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    // 需要用户和CMS 管理员都可以访问的权限
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    // 只有用户才能访问的接口权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID)
        {
            throw new Exception('检测 UID 时必须传入一个被检测的 UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID === $checkedUID)
        {
            return true;
        }
        return false;
    }
}