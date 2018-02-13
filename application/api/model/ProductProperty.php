<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/13
 * Time: 13:33
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'id'];
}