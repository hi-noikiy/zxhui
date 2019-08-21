<?php
/**
 * 企业官网
 *
 * @author 开吧源码社区
 * @url http://www.kai8.top/
 * <!-- phpDesigner :: Timestamp [2018/8/11 11:16:08] -->
 */
defined('IN_IA') or exit('Access Denied');

require_once IA_ROOT . '/addons/bowen_site/defines.php';
require_once M_ROOT.'/version.php';
include_once M_INC . 'functions.php';
	
class Bowen_siteModuleSystemWelcome extends WeModuleSystemWelcome {
    
    public function systemWelcomeDisplay() {
	  global $_GPC, $_W;
	   bowen_site_welcome(true);
	}
    
	public function doPageSystemwelcome(){
       global $_GPC, $_W;
       
        if($_W['uniacid']){
            header("location: " . webUrl());
        }else{
            header("location: " . webUrl('pcsite/account/display'));
        }
	}
}