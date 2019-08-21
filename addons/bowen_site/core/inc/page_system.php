<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/20 11:23:45] -->
 */
defined('IN_IA') or exit('Access Denied');

class SystemPage extends WebPage
{
	public function __construct()
	{
	   parent::__construct(false);
       global $_W;
		define('IS_M_SYSTEM', true);
        mychecklogin(false);
        
		$routes = explode('.', $_W['routes']);
		$_W['current_menu'] = isset($routes[1]) ? $routes[1] : '';
        
        if ($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER) {
			mymessage('权限不足，禁止访问', 'referer', 'error');
		}
	}
}

