<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:42:26] -->
 */
defined('IN_IA') or exit('Access Denied');

class PcsiteAdminPage extends PluginWebPage
{
    public function __construct()
	{
	   global $_W;
        parent::__construct();
        mychecklogin();
        if ($_W['role'] != 'founder') {
			itoast('权限不足，禁止访问', 'referer', 'error');
		}
	}
}