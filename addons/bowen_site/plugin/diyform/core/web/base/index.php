<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:41:59] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{   
    public function info()
    {
       global $_W, $_GPC;
        mychecklogin();
        $_W['page']['title'] = '自定义表单';
        
        include $this->mytemplate();
    }
}