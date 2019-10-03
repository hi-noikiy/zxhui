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
     * @param $gift_goods_id mixed 赠品商品ID
     * @param array $gift_rule 赠品规则
     * @return bool
     */
    public function checkPriceRisk($goods_id, $gift_goods_id, $gift_rule = [])
    {
        // 商品价格
        $goods_id_price = [];

        // 赠品价格
        $gift_goods_id_price = [];

        $goods_ids = [];
        if (!is_array($goods_id)) {
            $goods_ids[] = $goods_id;
        } else {
            $goods_ids = array_merge($goods_ids, $goods_id);
        }

        $gift_goods_ids = [];
        if (!is_array($gift_goods_id)) {
            $gift_goods_ids[] = $gift_goods_id;
        } else {
            $gift_goods_ids = array_merge($gift_goods_ids, $gift_goods_id);
        }

        $all_ids = array_merge($goods_ids, $gift_goods_ids);
        sort($all_ids);
        $price_list = pdo_fetchall('SELECT id,marketprice,gift_price FROM ' . tablename('ewei_shop_goods') . ' WHERE id IN(' . implode(',', $all_ids) . ')');

        foreach ($price_list as $key => $value) {
            foreach ($goods_ids as $k => $v) {
                if ($v === $value['id']) {
                    $goods_id_price[$v] = $value['marketprice'];
                }
            }
            foreach ($gift_goods_ids as $kk => $vv) {
                if ($vv === $value['id']) {
                    $gift_goods_id_price[$vv] = $value['gift_price'];
                }
            }
        }

        // 商品售价
        $product_price = 0;
        // 赠品结算价
        $gift_price = 0;

        if ($gift_rule) {
            // 购买数量目前统一设置
            $buy = 1;

            // 分开计算价格
            foreach ($gift_rule as $k => $v) {
                $gift_price += $gift_goods_id_price[$k] * $v['free'];
                $buy = $v['buy'];
            }

            foreach ($goods_id_price as $k => $v) {
                // 价格要乘以数量
                $product_price = $v * $buy;

                if ($product_price < $gift_price) {

                    return true;
                }
            }
        } else {
            // 计算赠品总价
            foreach ($gift_goods_id_price as $k => $v) {
                $gift_price += $v;
            }

            foreach ($goods_id_price as $k => $v) {
                $product_price = $v;

                if ($product_price < $gift_price) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 赠品规则
     * @param $data
     * @return array
     */
    public function parseGiftRule($data)
    {

        if (!empty($data)) {
            $return = [];
            foreach ($data['buy'] as $id => $rule) {
                foreach ($rule as $k => $v) {
                    $return[$id]['goods_id'] = $v;
                    $return[$id]['buy'] = $v;
                    $return[$id]['free'] = $data['free'][$id][$k];
                }
            }

            return $return;
        } else {
            return [];
        }
    }


    /**
     * 更新赠品规则
     * @param $gift_plus_id
     * @param $rule
     * @param $merchant_id
     * @param $uniacid
     */
    public function updateGiftRule($gift_plus_id, $rule, $merchant_id, $uniacid)
    {
        $condition = [];
        if ($gift_plus_id) {
            $condition['gift_plus_id'] = $gift_plus_id;
        }
        if ($merchant_id) {
            $condition['merchant_id'] = $merchant_id;
        }
        if ($uniacid) {
            $condition['uniacid'] = $uniacid;
        }

        foreach ($rule as $k => $v) {
            $condition['gift_goods_id'] = $k;

            pdo_update('ewei_shop_gift_plus_rule', [
                'gift_goods_amount' => $k['free']
            ], $condition);
        }
    }

    /**
     * 添加赠品规则
     * @param $gift_plus_id
     * @param $rule
     * @param $merchant_id
     * @param $uniacid
     * @param array $goods_ids
     */
    public function addGiftRule($gift_plus_id, $rule, $merchant_id, $uniacid, $goods_ids = [])
    {
        if ($gift_plus_id) {
            if (!is_array($goods_ids)) {
                $goods_ids = [$goods_ids];
            }

            foreach ($goods_ids as $goods_id) {
                foreach ($rule as $k => $v) {
                    pdo_insert('ewei_shop_gift_plus_rule', [
                        'uniacid' => $uniacid,
                        'gift_plus_id' => $gift_plus_id,
                        'goods_id' => $goods_id,
                        'goods_amount' => $v['buy'],
                        'gift_goods_id' => $k,
                        'gift_goods_amount' => $v['free'],
                        'merchant_id' => $merchant_id
                    ]);
                }
            }
        }
    }

    /**
     * 获取赠品规则
     * @param $gift_plus_id
     * @param $uniacid
     * @param $merchant_id
     * @return mixed
     */
    public function getGiftRule($gift_plus_id, $uniacid = false, $merchant_id = false)
    {
        $sql = 'SELECT r.*,g.title,g.marketprice,g.costprice,g.gift_price FROM ' . tablename('ewei_shop_gift_plus_rule') . ' AS r LEFT JOIN ' . tablename('ewei_shop_goods') . ' g ON g.id = r.gift_goods_id WHERE r.gift_plus_id = :gift_plus_id';

        if ($uniacid) {
            $sql .= ' AND r.uniacid = ' . $uniacid;
        }

        if ($merchant_id) {
            $sql .= ' AND r.merchant_id = ' . $merchant_id;
        }

        $gift_plus_rule = pdo_fetchall($sql, [':gift_plus_id' => $gift_plus_id]);

        return $gift_plus_rule;
    }
}
