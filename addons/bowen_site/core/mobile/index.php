<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/27 15:09:15] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends MobilePage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $settings = $_B['setting'];
        $_W['page']['title'] = $settings['global']['title'];
        $sign = 'home';
        $settings['home']['banner'] = iunserializer($_B['setting']['home']['banner']);
        $settings['home']['advantages']['content'] = iunserializer($_B['setting']['home']['advantages']['content']);

        $page_title = $_B['setting']['global']['title'];
        $template = 'index';
        include $this->mytemplate();
	}
}