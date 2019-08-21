<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/22 17:41:50] -->
 */
defined('IN_IA') or exit('Access Denied');
global $_W;

$menus = array();
$menus['base'] = array(
    'title' => '基础信息',
    'sign' => 'base',
    'default' => '1',
    'content' => array(
        'info' => array(
            'sign' => 'info',
            'title' => '应用说明',
            'icon' => 'wi wi-account',
            'target' => '',
            'url' => webUrl('diyform/base/info', '', true)
        )
    )
);
$menus['setting'] = array(
    'title' => '自定义表单',
    'sign'  => 'setting',
    'default' => '1',
    'content' => array(
        'temp' => array(
            'sign' => 'temp',
            'title' => '模板管理',
            'icon' => '',
            'url' => webUrl('diyform/setting/temp')
        ),
        /**
        'category' => array(
            'sign' => 'category',
            'title' => '分类管理',
            'icon' => '',
            'url' => webUrl('diyform/setting/category')
        ),
        'base' => array(
            'sign' => 'base',
            'title' => '基础设置',
            'icon' => '',
            'url' => webUrl('diyform/setting/base')
        ),*/
    )
);

$menu_v2 = array();
$menu_v2["info"] = array(
    "name" => "info"
    ,"title" => "应用说明"
    ,"icon" => "layui-icon layui-icon-tips"
    ,"jump" => "diyform.base.info"
);
$menu_v2["temp"] = array(
    "name" => "temp"
    ,"title" => "模板管理"
    ,"icon" => ""
    ,"jump" => "diyform.setting.temp"
);

$table = array(
    'temp' => 'bowen_site_diyform_template',
    'data' => 'bowen_site_diyform_data'
);

return array(
	'version' => '0.0.1',
	'id'      => 'diyform',
	'name'    => 'diyform',
    'title'    => '自定义表单',
    'category'=> 'biz',
    'table'   => $table,
	'menu'    => $menus
    ,'menu_v2'=> $menu_v2
);
