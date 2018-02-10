<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 16:26
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }
}
