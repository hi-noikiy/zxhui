<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:43:08] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{   
    public function info()
    {
       global $_W, $_GPC;
        mychecklogin();
        $_W['page']['title'] = '工具箱';
        
        include $this->mytemplate();
    }
}