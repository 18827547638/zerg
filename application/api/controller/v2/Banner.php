<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/1/27
 * Time: 15:42
 */

namespace app\api\controller\v2;


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
        return 'this is v2 version';
    }
}