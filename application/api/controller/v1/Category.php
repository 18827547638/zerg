<?php

namespace app\api\controller\v1;

use app\api\model\Category as CaregoryModel;
use app\lib\exception\CategoryException;
use think\Controller;

class Category extends Controller
{
    public function getAllCategories()
    {
        $categories = CaregoryModel::all([], 'img');
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}
