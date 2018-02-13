<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/13
 * Time: 13:31
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}