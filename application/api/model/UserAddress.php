<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/13
 * Time: 16:38
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}