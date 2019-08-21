<?php
/**
 * 玖祺企业官网模块Phoneapp接口定义
 *
 * @author 开吧源码社区
 * @url http://www.kai8.top/
 * <!-- phpDesigner :: Timestamp [2018/8/11 9:48:09] -->
 */
defined('IN_IA') or exit('Access Denied');
define('IN_PHONEAPP', true);
define('MODULE_NAME', 'bowen_site');

require_once IA_ROOT . '/addons/'.MODULE_NAME.'/defines.php';
require_once M_ROOT.'/version.php';
include_once M_INC . 'functions.php';

class Bowen_siteModulePhoneapp extends WeModulePhoneapp {
    public function doPageForeg(){
        m('route')->run('phoneapp');
    }
    public function doPageTest() {
        
	}
}