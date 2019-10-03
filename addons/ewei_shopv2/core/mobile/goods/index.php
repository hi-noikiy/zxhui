<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage {

	function main() {
		global $_W, $_GPC;

		$allcategory = m('shop')->getCategory();
		$catlevel = intval($_W['shopset']['category']['level']);
		$opencategory = true; //是否自己商品不同步分类
		$plugin_commission = p('commission');
		if ($plugin_commission && intval($_W['shopset']['commission']['level']) > 0) {
			$mid = intval($_GPC['mid']);
			if (!empty($mid) && empty($_W['shopset']['commission']['closemyshop']) && !empty($_W['shopset']['commission']['select_goods'])) {
				$shop = p('commission')->getShop($mid);
				if (empty($shop['selectcategory']) && !empty($shop['selectgoods'])) {
					$opencategory = false;
				}
			}
		}

		include $this->template();
	}
	function gift(){
		global $_W,$_GPC;
		$uniacid = $_W['uniacid'];
		$giftid = intval($_GPC['id']);

		$gift = pdo_fetch("select * from ".tablename('ewei_shop_gift')." where uniacid = ".$uniacid." and id = ".$giftid." and starttime <= ".time()." and endtime >= ".time()." and status = 1 ");
		$giftgoodsid = explode(",",$gift['giftgoodsid']);
		$giftgoods = array();
		if(!empty($giftgoodsid)){
			foreach($giftgoodsid as $key => $value){
				$giftgoods[$key] = pdo_fetch("select id,status,title,thumb,marketprice,total from ".tablename('ewei_shop_goods')." where uniacid = ".$uniacid." and deleted = 0  and id = ".$value." and status = 2 ");
			}
			$giftgoods = array_filter($giftgoods);
		}

		include $this->template();
	}

	// 超级赠品
    function gift_plus()
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);

        $gift_plus = pdo_fetch("select * from " . tablename('ewei_shop_gift_plus') . " where uniacid = " . $uniacid . " and id = " . $id . " and starttime <= " . time() . " and endtime >= " . time() . " and status = 1");
        $gift_goods_id = explode(",", $gift_plus['giftgoodsid']);
        $goods_id = explode(',', $gift_plus['goodsid']);
        $gift_goods = array();

        // 赠品规则
        $gift_rule = m('gift_plus')->getGiftRule($id, false, false, 'gift');

        if (!empty($gift_goods_id)) {
            foreach ($gift_goods_id as $key => $value) {
                $item = pdo_fetch("select id,status,title,thumb,marketprice,total from " . tablename('ewei_shop_goods') . " where uniacid = " . $uniacid . " and deleted = 0  and id = " . $value);
                $item['amount'] = intval($gift_rule[$value]['gift_goods_amount']);
                if ($item['amount'] === 0) {
                    $item['amount'] = 1;
                }
                // $item['marketprice'] = number_format($item['marketprice'] * $item['amount'], 2);
                $gift_goods[$key] = $item;
            }
            $giftgoods = array_filter($gift_goods);
        }

        include $this->template();
    }

	function get_list() {


		global $_GPC, $_W;

		$args = array(
			'pagesize' => 10,
			'page' => intval($_GPC['page']),
			'isnew' => trim($_GPC['isnew']),
			'ishot' => trim($_GPC['ishot']),
			'isrecommand' => trim($_GPC['isrecommand']),
			'isdiscount' => trim($_GPC['isdiscount']),
			'istime' => trim($_GPC['istime']),
			'issendfree' => trim($_GPC['issendfree']),
			'keywords' => trim($_GPC['keywords']),
			'cate' => trim($_GPC['cate']),
			'order' => trim($_GPC['order']),
			'by' => trim($_GPC['by'])
		);
		
		//判断是否开启自选商品
		$plugin_commission = p('commission');
		if ($plugin_commission && intval($_W['shopset']['commission']['level'])>0 && empty($_W['shopset']['commission']['closemyshop']) && !empty($_W['shopset']['commission']['select_goods'])) {
            $frommyshop = intval($_GPC['frommyshop']);
			$mid = intval($_GPC['mid']);
			if (!empty($mid) && !empty($frommyshop)) {
				$shop = p('commission')->getShop($mid);
				if (!empty($shop['selectgoods'])) {
					$args['ids'] = $shop['goodsids'];
				}
			}
		}
		$this->_condition($args);
	}

	function query() {
		global $_GPC, $_W;
		$args = array(
			'pagesize' => 10,
			'page' => intval($_GPC['page']),
			'isnew' => trim($_GPC['isnew']),
			'ishot' => trim($_GPC['ishot']),
			'isrecommand' => trim($_GPC['isrecommand']),
			'isdiscount' => trim($_GPC['isdiscount']),
			'istime' => trim($_GPC['istime']),
			'keywords' => trim($_GPC['keywords']),
			'cate' => trim($_GPC['cate']),
			'order' => trim($_GPC['order']),
			'by' => trim($_GPC['by'])
		);
		$this->_condition($args);
	}

	private function _condition($args)
	{
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$args['merchid'] = intval($_GPC['merchid']);
		}

		if (isset($_GPC['nocommission'])) {
			$args['nocommission'] = intval($_GPC['nocommission']);
		}

		$goods = m('goods')->getList($args);

		show_json(1, array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}

}
