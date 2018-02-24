<?php
/**
 * Created by PhpStorm.
 * User: yilun
 * Date: 2018/2/24
 * Time: 17:29
 */

namespace app\api\service;


use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

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
        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_ id'] = -1;
            return $status;
        }

        // 开始创建订单
        $orderSnap = $this->snapOrder($status);

    }

    // 生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => '',
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress(), JSON_UNESCAPED_UNICODE);
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if (count($this->products) > 1) {
            $snap['snapName'] . '等';
        }
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在, 下单失败',
                'errorCode' => '60001'
            ]);
        }

        return $userAddress->toArray();
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => false,
            'orderPrice' => 0,
            'totalCount' => 0,
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
            $status['totalCount'] += $pStatus['count'];
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