<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:37:30] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{   
    public function info()
    {
       global $_W, $_GPC;
        mychecklogin();
        $_W['page']['title'] = '数据操作';
        
        include $this->mytemplate();
    }
    
}