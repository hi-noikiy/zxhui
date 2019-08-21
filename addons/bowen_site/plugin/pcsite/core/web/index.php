<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/20 23:31:05] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{
    public function main()
    {
        itoast('', webUrl('pcsite/base/info'));
    }
    
    public function getConfig(){
       global $_W, $_B;
        mychecklogin();
        if(!$_W['isajax']){
            $this->result(2, '非法访问');
        }
        $this->result(0, 'success', $_B['current_plugin_config']);
    }
}