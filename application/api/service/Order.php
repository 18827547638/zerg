<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/24
 * Time: 17:29
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    // 客户端传递过来的 products 参数
    protected $oProducts;
    // 真是的商品信息(库存)
    protected $products;
    protected $uid;

    public function place($uid, $oProducts)
    {
        // oProducts 和 products 做对比
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => false,
            'orderPrice' => 0,
            'pStatusArray' => [],
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'], $oProduct['count'], $this->products
            );

            if ($pStatus['haveStock']) {
                $status['pass'] = true;
            }

            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }

        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0,
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的product_id 有可能是不存在的
            throw new OrderException([
                'msg' => 'id 为' . $oPID . '商品不存在, 创建订单失败',
            ]);
        } else {
            $products = $products[$pIndex];
            $pStatus['id'] = $products['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $products['name'];
            $pStatus['totalPrice'] = $products['price'] * $oCount;
            if ($products['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    // 根据订单信息查询这是的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }

        $products = Product::all($oPIDs)
            ->visiable(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }
}