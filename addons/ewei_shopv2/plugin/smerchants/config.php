<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'smerchants',
	'name'    => '子商户',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
		    
            //array('title' => '加盟品牌', 'route' => 'category'),
            array('title' => '订单管理', 'route' => 'order'),
            array('title' => '商品审核', 'route' => 'verify'),
            //array('title' => '收银配置', 'route' => 'cash'),
            //array('title' => '全局设置', 'route' => 'situation')  
			)
		)
	);

?>
