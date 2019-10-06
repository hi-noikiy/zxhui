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
     * @param bool $is_merchant 是否为多商户
     * @return bool
     */
    public function checkPriceRisk($goods_id, $gift_goods_id, $gift_rule = [], $is_merchant = false)
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
        $price_list = pdo_fetchall('SELECT id,marketprice,gift_price,costprice FROM ' . tablename('ewei_shop_goods') . ' WHERE id IN(' . implode(',', $all_ids) . ')');

        foreach ($price_list as $key => $value) {
            foreach ($goods_ids as $k => $v) {
                if ($v === $value['id']) {
                    // 成本价
                    if ($is_merchant) {
                        $goods_id_price[$v] = $value['costprice'];
                    } else {
                        $goods_id_price[$v] = $value['marketprice'];
                    }
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
                $gift_price = 0;
                foreach ($v as $kk => $vv) {
                    $gift_price += $gift_goods_id_price[$kk] * $vv['free'];
                    // $buy = $vv['buy'];
                }

                // 价格要乘以数量
                $product_price = $goods_id_price[$k] * $buy;
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
     * @param $goods_ids
     * @return array
     */
    public function parseGiftRule($data, $goods_ids)
    {

        if (!empty($data) && !empty($goods_ids)) {
            $return = [];
            foreach ($goods_ids as $key => $goods_id) {
                foreach ($data['buy'] as $id => $rule) {
                    foreach ($rule as $k => $v) {
                        $return[$goods_id][$id]['goods_id'] = $goods_id;
                        $return[$goods_id][$id]['buy'] = $v;
                        $return[$goods_id][$id]['free'] = $data['free'][$id][$k];
                    }
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
        $sql = 'SELECT id FROM ' . tablename('ewei_shop_gift_plus_rule') . ' WHERE 1';
        $condition = [];
        $map = [];
        if ($gift_plus_id) {
            $condition['gift_plus_id'] = $gift_plus_id;
            $sql .= ' AND gift_plus_id = :gift_plus_id';
            $map[':gift_plus_id'] = $gift_plus_id;
        }
        if ($merchant_id) {
            $condition['merchant_id'] = $merchant_id;
            $sql .= ' AND merchant_id = :merchant_id';
            $map[':merchant_id'] = $merchant_id;
        }
        if ($uniacid) {
            $condition['uniacid'] = $uniacid;
            $sql .= ' AND uniacid = :uniacid';
            $map[':uniacid'] = $uniacid;
        }

        // 删除已经失效的规则
        $gift_plus_info = pdo_fetch('SELECT * FROM '. tablename('ewei_shop_gift_plus') . ' WHERE id = ' . $gift_plus_id);
        $gift_plus_rule_list = pdo_fetchall('SELECT r.* FROM ' . tablename('ewei_shop_gift_plus_rule') . ' AS r WHERE r.gift_plus_id = :gift_plus_id', [':gift_plus_id' => $gift_plus_id]);
        $gift_goods_id = explode(',', $gift_plus_info['giftgoodsid']);
        $goods_id = explode(',', $gift_plus_info['goodsid']);
        foreach ($gift_plus_rule_list as $key => $val) {
            if (!in_array($val['gift_goods_id'], $gift_goods_id) || !in_array($val['goods_id'], $goods_id)) {
                pdo_delete('ewei_shop_gift_plus_rule', ['id' => $val['id']]);
            }
        }

        foreach ($rule as $goods_id => $item) {
            $condition['goods_id'] = $goods_id;
            $sql = $sql . ' AND goods_id = :goods_id';
            $map[':goods_id'] = $goods_id;

            foreach ($item as $gift_goods_id => $v) {
                $condition['gift_goods_id'] = $gift_goods_id;
                $new_sql = $sql . ' AND gift_goods_id = :gift_goods_id';
                $map[':gift_goods_id'] = $gift_goods_id;

                $check = pdo_fetch($new_sql, $map);
                if ($check) {
                    pdo_update('ewei_shop_gift_plus_rule', [
                        'gift_goods_amount' => $v['free']
                    ], $condition);
                } else {
                    pdo_insert('ewei_shop_gift_plus_rule', [
                        'uniacid' => $uniacid,
                        'gift_plus_id' => $gift_plus_id,
                        'goods_id' => $goods_id,
                        'goods_amount' => $v['buy'],
                        'gift_goods_id' => $gift_goods_id,
                        'gift_goods_amount' => $v['free'],
                        'merchant_id' => $merchant_id
                    ]);
                }
            }
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
                    if ($k === intval($goods_id)) {
                        foreach ($v as $kk => $vv) {
                            pdo_insert('ewei_shop_gift_plus_rule', [
                                'uniacid' => $uniacid,
                                'gift_plus_id' => $gift_plus_id,
                                'goods_id' => $goods_id,
                                'goods_amount' => $vv['buy'],
                                'gift_goods_id' => $kk,
                                'gift_goods_amount' => $vv['free'],
                                'merchant_id' => $merchant_id
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * 获取赠品规则
     * @param $gift_plus_id
     * @param bool $uniacid
     * @param bool $merchant_id
     * @param string $group
     * @return mixed
     */
    public function getGiftRule($gift_plus_id, $uniacid = false, $merchant_id = false, $group = 'gift')
    {
        $sql = 'SELECT r.*,g.title,g.marketprice,g.costprice,g.gift_price FROM ' . tablename('ewei_shop_gift_plus_rule') . ' AS r LEFT JOIN ' . tablename('ewei_shop_goods') . ' g ON g.id = r.gift_goods_id WHERE r.gift_plus_id = :gift_plus_id';

        if ($uniacid) {
            $sql .= ' AND r.uniacid = ' . $uniacid;
        }

        if ($merchant_id) {
            $sql .= ' AND r.merchant_id = ' . $merchant_id;
        }

        $gift_plus = pdo_fetch('SELECT * FROM '. tablename('ewei_shop_gift_plus') . ' WHERE id = ' . $gift_plus_id);
        $gift_goods_id = explode(',', $gift_plus['giftgoodsid']);
        $gift_plus_rule = pdo_fetchall($sql, [':gift_plus_id' => $gift_plus_id]);

        if ($group === 'gift') {
            $new_rule = [];
            foreach ($gift_plus_rule as $key => $value) {
                if (intval($value['gift_goods_amount']) === 0) {
                    continue;
                }
                if (in_array($value['gift_goods_id'], $gift_goods_id)) {
                    $new_rule[$value['goods_id']][$value['gift_goods_id']] = $value;
                }
            }

            sort($new_rule);

            return $new_rule[0];
        }

        return $gift_plus_rule;
    }
}
