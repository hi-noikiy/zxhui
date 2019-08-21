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
            'url' => webUrl('tools/base/info', '', true)
        )
    )
);
$menus['fix'] = array(
    'title' => '修复工具',
    'sign' => 'fix',
    'default' => '1',
    'content' => array(
        'statvisit' => array(
            'sign' => 'statvisit',
            'title' => '清空最后访问',
            'icon' => '',
            'target' => '',
            'url' => webUrl('tools/fix/statvisit')
        ),
        'cache_clean' => array(
            'sign' => 'cache_clean',
            'title' => '清空所有缓存',
            'icon' => '',
            'target' => '',
            'url' => webUrl('tools/fix/cache_clean')
        ),
    )
);

$menu_v2 = array();
$menu_v2["info"] = array(
    "name" => "info"
    ,"title" => "应用说明"
    ,"icon" => "layui-icon layui-icon-tips"
    ,"jump" => "tools.base.info"
);
$menu_v2["statvisit"] = array(
    "name" => "statvisit"
    ,"title" => "清空最后访问"
    ,"icon" => ""
    ,"jump" => "tools.fix.statvisit"
);
$menu_v2["cache_clean"] = array(
    "name" => "cache_clean"
    ,"title" => "清空所有缓存"
    ,"icon" => ""
    ,"jump" => "tools.fix.cache_clean"
);

return array(
    'version' => '0.0.1',
    'id' => 'tools',
    'name' => 'tools',
    'title' => '工具箱',
    'category' => 'sys',
    'menu' => $menus
    ,'menu_v2'=> $menu_v2
);
