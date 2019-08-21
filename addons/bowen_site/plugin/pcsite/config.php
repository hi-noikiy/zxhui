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
            'url' => webUrl('pcsite/base/info', '', true)
        )
    )
);
$menus['setting'] = array(
    'title' => '独立后台',
    'sign'  => 'setting',
    'default' => '1',
    'content' => array(
        'login' => array(
            'sign' => 'login',
            'title' => '登录设置',
            'icon' => '',
            'url' => webUrl('pcsite/setting/login')
        ),
        'register' => array(
            'sign' => 'register',
            'title' => '注册设置',
            'icon' => '',
            'url' => webUrl('pcsite/setting/register')
        ),
        'copyright' => array(
            'sign' => 'copyright',
            'title' => '版权设置',
            'icon' => '',
            'url' => webUrl('pcsite/setting/copyright')
        ),
    )
);

$menu_v2 = array(
    "info" => array(
        "name" => "info"
        ,"title" => "应用说明"
        ,"icon" => "layui-icon layui-icon-tips"
        ,"jump" => "pcsite.base.info"
    )
    
    ,'login' => array(
        'name' => 'login',
        'title' => '登录设置',
        'icon' => '',
        'jump' => 'pcsite.setting.login'
    )
    ,'register' => array(
        'name' => 'register',
        'title' => '注册设置',
        'icon' => '',
        'jump' => 'pcsite.setting.register'
    )
    ,'copyright' => array(
        'name' => 'copyright',
        'title' => '版权设置',
        'icon' => '',
        'jump' => 'pcsite.setting.copyright'
    )
);

$table = array();
$table['pcsite_domain'] = 'bowen_site_pcsite_domain';

return array(
	'version' => '0.0.1',
	'id'      => 'pcsite',
    'name'    => 'pcsite',
	'title'    => '独立后台',
    'category'=> 'sys',
    'table' => $table,
	'menu'    => $menus
    ,'menu_v2' => $menu_v2
);
