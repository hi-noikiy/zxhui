<?php
/**
 * 超级赠品
 *
 * 微信开发 && 小程序开发 && 移动应用开发 && 电商平台开发及运营
 *
 * @copyright Changzhou Hao Gu Network Technology Co., Ltd.
 * @license http://www.haogu.co/
 */

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function __construct()
    {
        global $_W;

        if (!$_W['isfounder']) {
            exit('Access Denied');
        }

        parent::__construct();
    }

    public function main()
    {
        global $_W, $_GPC;

        $uniacid = intval($_W['uniacid']);
        $merchant_id = intval($_W['merchid']);
        $page_index = max(1, intval($_GPC['page']));
        $page_size = 20;
        $condition = ' and uniacid=:uniacid and merchant_id = :merchant_id';
        $params = array(':uniacid' => $uniacid, ':merchant_id' => $merchant_id);
        $type = trim($_GPC['type']);

        if ($type == 'ing') {
            $condition .= ' and starttime <= ' . time() . ' and endtime >= ' . time() . ' and status = 1 ';
        } else if ($type == 'none') {
            $condition .= ' and starttime > ' . time() . ' and status = 1 ';
        } else {
            if ($type == 'end') {
                $condition .= ' and (endtime < ' . time() . ' or status = 0) ';
            }
        }

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' AND title LIKE :title';
            $params[':title'] = '%' . trim($_GPC['keyword']) . '%';
        }

        $gifts = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_gift_plus') . " WHERE 1 " . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ' . ($page_index - 1) * $page_size . ',' . $page_size, $params);
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_gift_plus') . ' WHERE 1 ' . $condition, $params);
        $pager = pagination2($total, $page_index, $page_size);

        include $this->template();
    }

    public function add()
    {
        $this->post();
    }

    public function edit()
    {
        $this->post();
    }

    protected function post()
    {
        global $_W, $_GPC;

        $merchant_id = intval($_W['merchid']);
        $uniacid = intval($_W['uniacid']);
        $type = trim($_GPC['type']);
        $id = intval($_GPC['id']);

        $item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_gift_plus') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $id . ' AND merchant_id = ' . $merchant_id);

        if (!empty($item['thumb'])) {
            $item = set_medias($item, array('thumb'));
        }

        $goods = array();
        if (!empty($item['goodsid'])) {
            $goods_id = explode(',', $item['goodsid']);

            if ($goods_id) {
                foreach ($goods_id as $key => $value) {
                    $goods[$key] = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 1 and id = ' . $value . ' and deleted = 0 ');
                }
            }
        }

        $gift = array();
        if (!empty($item['giftgoodsid'])) {
            $gift_id = explode(',', $item['giftgoodsid']);

            if ($gift_id) {
                foreach ($gift_id as $key => $value) {
                    $gift[$key] = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and id = ' . $value . ' and deleted = 0 and total > 0 ');
                }
            }

            $gift = array_filter($gift);
        }

        $gift_rule = false;
        if ($item) {
            $gift_rule = m('gift_plus')->getGiftRule($id, $uniacid);
            $gift_goods = json_encode($gift);
        }

        $gift_rule_init = false;
        if (!$gift_rule) {
            $gift_rule_init = true;
        }

        if ($_W['ispost']) {
            // 赠品规则
            $gift_rule = m('gift_plus')->parseGiftRule($_GPC['gift_rule'], $_GPC['goodsid']);

            if (empty($id)) {
                $activity = intval($_GPC['activity']);
            } else {
                $activity = intval($_GPC['activitytype']);
            }

            $data = array(
                'uniacid' => $uniacid,
                'displayorder' => intval($_GPC['displayorder']),
                'title' => trim($_GPC['title']),
                'activity' => $activity,
                'thumb' => trim($_GPC['thumb']),
                'orderprice' => floatval($_GPC['orderprice']),
                'goodsid' => $_GPC['goodsid'],
                'giftgoodsid' => $_GPC['giftgoodsid'],
                'starttime' => strtotime($_GPC['starttime']),
                'endtime' => strtotime($_GPC['endtime']),
                'status' => intval($_GPC['status']),
                'share_title' => trim($_GPC['share_title']),
                'share_icon' => trim($_GPC['share_icon']),
                'share_desc' => trim($_GPC['share_desc']),
                'merchant_id' => $merchant_id
            );

            // 价格风控
            if (m('gift_plus')->checkPriceRisk($data['goodsid'], $data['giftgoodsid'], $gift_rule)) {
                show_json(0, '赠品价格高于商品售价！添加失败！');
            }

            if ($activity == 1 && empty($data['orderprice'])) {
                show_json(0, '订单金额不能为空！');
            }

            if ($activity == 2 && empty($data['goodsid'])) {
                show_json(0, '指定商品不能为空！');
            }

            if (!empty($data['goodsid'])) {
                $goodsid = $data['goodsid'];
                $data['goodsid'] = is_array($data['goodsid']) ? implode(',', $data['goodsid']) : 0;
            }

            if (!empty($data['goodsid'])) {
                $goodsArr = explode(',', $data['goodsid']);

                foreach ($goodsArr as $k => $v) {
                    $temp = pdo_fetch('select isverify from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 1 and id = ' . $v . ' and deleted = 0 ');

                    if ($temp['isverify'] == 2) {
                        // show_json(0, '指定商品存在核销商品不允许添加赠品');
                    }
                }
            }

            if (empty($data['giftgoodsid'])) {
                show_json(0, '请选择赠品！');
            } else {
                $giftgoodsid = $data['giftgoodsid'];
                $data['giftgoodsid'] = is_array($data['giftgoodsid']) ? implode(',', $data['giftgoodsid']) : 0;
            }

            if (empty($data['thumb'])) {
                foreach ($_GPC['giftgoodsid'] as $key => $value) {
                    $giftgood = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2 and deleted = 0 limit 1 ');
                }

                $data['thumb'] = $giftgood['thumb'];
            }

            if ($data['thumb'] || $data['share_icon']) {
                $data['thumb'] = save_media($data['thumb']);
                $data['share_icon'] = save_media($data['share_icon']);
            }

            if (!empty($id)) {
                pdo_update('ewei_shop_gift_plus', $data, array('id' => $id));
                // 更新赠品规则
                if ($gift_rule_init) {
                    m('gift_plus')->addGiftRule($id, $gift_rule, $merchant_id, $uniacid, $data['goodsid']);
                } else {
                    m('gift_plus')->updateGiftRule($id, $gift_rule, $merchant_id, $uniacid);
                }

                plog('sale.gift_plus.edit', '编辑超级赠品 ID: ' . $id . ' <br/>赠品名称: ' . $data['title']);
            } else {
                pdo_insert('ewei_shop_gift_plus', $data);
                $id = pdo_insertid();

                // 插入赠品规则
                m('gift_plus')->addGiftRule($id, $gift_rule, $merchant_id, $uniacid, $data['goodsid']);

                plog('sale.gift_plus.add', '添加超级赠品 ID: ' . $id . '  <br/>赠品名称: ' . $data['title']);
            }

            show_json(1, array('url' => webUrl('sale/gift_plus/edit', array('type' => $type, 'id' => $id))));
        }

        include $this->template();
    }

    public function delete()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_gift_plus') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_gift_plus', array('deleted' => 1, 'status' => 0), array('id' => $item['id']));
            plog('sale.gift_plus.delete', '删除超级赠品 ID: ' . $item['id'] . ' 赠品名称: ' . $item['title'] . ' ');
        }

        show_json(1, array('url' => referer()));
    }

    public function status()
    {
        global $_W, $_GPC;

        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_gift_plus') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_gift_plus', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
            plog('sale.gift_plus.edit', '修改超级赠品状态<br/>ID: ' . $item['id'] . '<br/>赠品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '上架' : '下架');
        }

        show_json(1, array('url' => referer()));
    }

    public function remove()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_gift_plus') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_delete('ewei_shop_gift_plus', array('id' => $item['id']));
            plog('sale.gift_plus.edit', '彻底删除超级赠品<br/>ID: ' . $item['id'] . '<br/>赠品名称: ' . $item['title']);
        }

        show_json(1, array('url' => referer()));
    }

    public function restore()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }

        $items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_gift_plus') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_gift_plus', array('deleted' => 0), array('id' => $item['id']));
            plog('sale.gift_plus.edit', '恢复超级赠品<br/>ID: ' . $item['id'] . '<br/>赠品名称: ' . $item['title']);
        }

        show_json(1, array('url' => referer()));
    }

    public function change()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);

        if (empty($id)) {
            show_json(0, array('message' => '参数错误'));
        }

        $type = trim($_GPC['typechange']);
        $value = trim($_GPC['value']);

        if (!in_array($type, array('title', 'displayorder'))) {
            show_json(0, array('message' => '参数错误'));
        }

        $gift = pdo_fetch('select id from ' . tablename('ewei_shop_gift_plus') . ' where id=:id and uniacid=:uniacid limit 1', array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $id
        ));

        if (empty($gift)) {
            show_json(0, array('message' => '参数错误'));
        }

        pdo_update('ewei_shop_gift_plus', array($type => $value), array('id' => $id));
        show_json(1);
    }

    public function querygoods()
    {
        global $_W;
        global $_GPC;
        $uniacid = intval($_W['uniacid']);
        $kwd = trim($_GPC['keyword']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 8;
        $params = array();
        $params[':uniacid'] = $uniacid;
        $condition = ' and status=1 and deleted=0 and uniacid=:uniacid';

        if (!empty($kwd)) {
            $condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
            $params[':keywords'] = '%' . $kwd . '%';
        }

        $ds = pdo_fetchall("SELECT id,title,thumb,marketprice,total,goodssn,productsn,`type`,isdiscount,istime,isverify,share_title,share_icon,description,hasoption,nocommission,groupstype FROM " . tablename('ewei_shop_goods') . (" WHERE 1 " . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
        $pager = pagination($total, $pindex, $psize, '', array(
            'before' => 5,
            'after' => 4,
            'ajaxcallback' => 'select_page',
            'callbackfuncname' => 'select_page'
        ));
        $ds = set_medias($ds, array('thumb'));
        include $this->template();
    }

    public function querygift()
    {
        global $_W;
        global $_GPC;
        $uniacid = intval($_W['uniacid']);
        $kwd = trim($_GPC['keyword']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 8;
        $params = array();
        $params[':uniacid'] = $uniacid;
        $condition = ' and g.status=1 and g.deleted=0 and g.uniacid=:uniacid';

        if (!empty($kwd)) {
            $condition .= ' AND (g.`title` LIKE :keywords OR g.`keywords` LIKE :keywords)';
            $params[':keywords'] = '%' . $kwd . '%';
        }

        $ds = pdo_fetchall("SELECT g.id,g.title,g.thumb,g.marketprice,g.gift_price,g.total,s.sets FROM " . tablename('ewei_shop_goods') . (" AS g LEFT JOIN " . tablename('ewei_shop_sysset') . " AS s ON s.uniacid = g.uniacid  WHERE 1 " . $condition . ' ORDER BY g.displayorder DESC,g.id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

        foreach ($ds as $key => &$value) {
            $value['shop'] = unserialize($value['sets'])['shop'];
            $value['shop_logo'] = $value['shop']['logo'];
            $value['shop_name'] = $value['shop']['name'];
            unset($value['sets']);
            unset($value['shop']);
        }

        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
        $pager = pagination($total, $pindex, $psize, '', array(
            'before' => 5,
            'after' => 4,
            'ajaxcallback' => 'select_page',
            'callbackfuncname' => 'select_page'
        ));
        $ds = set_medias($ds, array('thumb', 'shop_logo'));

        include $this->template();
    }
}