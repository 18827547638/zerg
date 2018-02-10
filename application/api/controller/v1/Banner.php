<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 15:42
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定 id 的 banner 信息
     * @url /banner/:id
     * @http GET
     * @id
     */
    public function getBanner($id)
    {
        // 面向切面编程
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new \Exception('内部错误');
        }
        return $banner;
    }
}