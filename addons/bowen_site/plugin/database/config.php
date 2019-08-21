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
            'url' => webUrl('database/base/info', '', true)
        )
    )
);
$menus['demodb'] = array(
    'title' => '演示数据',
    'sign'  => 'demodb',
    'default' => '1',
    'content' => array(
    
        'import' => array(
            'sign' => 'import',
            'title' => '数据导入',
            'icon' => '',
            'url' => webUrl('database/demodb/import')
        ),
        
    )
);
if(file_exists(M_PLUGIN."database/core/web/demodb/export.php")){
    $menus['demodb']['content']['export'] = array(
        'sign' => 'export',
        'title' => '数据导出',
        'icon' => '',
        'url' => webUrl('database/demodb/export')
        
    );
}

if($_W['isfounder'] || $_W['role'] == ACCOUNT_MANAGE_NAME_OWNER || $_W['role'] == ACCOUNT_MANAGE_NAME_MANAGER){
    $menus['admin'] = array(
        'title' => '数据管理',
        'sign'  => 'admin',
        'default' => '1',
        'content' => array(
            'del' => array(
                'sign' => 'del',
                'title' => '数据清理',
                'icon' => '',
                'url' => webUrl('database/admin/del')
            ),
            /**
            'transfer' => array(
                'sign' => 'transfer',
                'title' => '数据转移',
                'icon' => '',
                'url' => webUrl('database/admin/transfer')
            ),
            'backup' => array(
                'sign' => 'backup',
                'title' => '数据备份',
                'icon' => '',
                'url' => webUrl('database/admin/backup')
            ),
            */
        )
    );
}

$menu_v2 = array();
$menu_v2["info"] = array(
    "name" => "info"
    ,"title" => "应用说明"
    ,"icon" => "layui-icon layui-icon-tips"
    ,"jump" => "database.base.info"
);
$menu_v2["import"] = array(
    "name" => "import"
    ,"title" => "数据导入"
    ,"icon" => ""
    ,"jump" => "database.demodb.import"
);
if(file_exists(M_PLUGIN."database/core/web/demodb/export.php")){
$menu_v2["export"] = array(
    "name" => "export"
    ,"title" => "数据导出"
    ,"icon" => ""
    ,"jump" => "database.demodb.export"
);
}
if($_W['isfounder'] || $_W['role'] == ACCOUNT_MANAGE_NAME_OWNER || $_W['role'] == ACCOUNT_MANAGE_NAME_MANAGER){
$menu_v2["del"] = array(
    "name" => "del"
    ,"title" => "数据清理"
    ,"icon" => ""
    ,"jump" => "database.admin.del"
);
}


$table = array();

return array(
	'version' => '0.0.1',
	'id'      => 'database',
	'name'    => 'database',
    'title'    => '数据操作',
    'category'=> 'sys',
    'table'   => $table,
	'menu'    => $menus
    ,'menu_v2'=> $menu_v2
);
