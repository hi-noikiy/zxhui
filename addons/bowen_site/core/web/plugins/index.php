<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/21 15:30:07] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC;
        $_W['page']['title'] = '应用中心';
        
        include $this->mytemplate();
	}
}
