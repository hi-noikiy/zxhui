<?php
/**
 * 超级赠品模块
 *
 * 微信开发 && 小程序开发 && 移动应用开发 && 电商平台开发及运营
 *
 * @copyright Changzhou Hao Gu Network Technology Co., Ltd.
 * @license http://www.haogu.co/
 */
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Gift_plus_EweiShopV2Model
{
    /**
     * 检查价格风险
     * @param $goods_id mixed 商品ID 可批量
     * @param $gift_goods_id mixed 支持多赠品
     * @return bool
     */
    public function checkPriceRisk($goods_id, $gift_goods_id)
    {
        // 商品售价
        $product_price = 0;
        // 单商品
        if (!is_array($goods_id)) {
            $goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id', ['id' => $goods_id]);
            $product_price = $goods['marketprice'];
        } else {
            foreach ($goods_id as $key => $val) {
                $goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id', ['id' => $val]);
                $product_price += $goods['marketprice'];
            }
        }

        // 赠品结算价
        $gift_price = 0;
        if (!is_array($gift_goods_id)) {
            $gift_goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id', ['id' => $gift_goods_id]);
            $gift_price = $gift_goods['gift_price'];
        } else {
            foreach ($gift_goods_id as $key => $val) {
                $gift_goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id', ['id' => $val]);
                echo '<pre>';
                print_r($gift_goods);
                echo '</pre>';
                die;
                $gift_price += $gift_goods['gift_price'];
            }
        }

        return $product_price < $gift_price;
    }
}
