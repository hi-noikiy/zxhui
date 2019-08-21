<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:19:56] -->
 */
defined('IN_IA') or exit('Access Denied');

class Banner_Page extends WebPage 
{
	public function main() 
	{
	   global $_W,$_GPC;

        include $this->mytemplate('tpl/banner');
        die;
	}
}
