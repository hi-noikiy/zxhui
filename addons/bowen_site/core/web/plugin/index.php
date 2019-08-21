<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/20 22:12:29] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends ComWebPage 
{
    public function __construct()
	{
	   global $_W, $_B;
		parent::__construct();
        
        if(!$_W['isajax']){
            mymessage('非法访问', '', 'error');
        }
	}
    
    public function getList()
    {
        $list = m('plugin')->getList(1, true);
        $this->result(0, 'success', $list);
    }
    
    public function getConfig_currentPlugin(){
        global $_B, $_GPC;
        $_B['current_plugin'] = safe_gpc_string(trim($_GPC['current_plugin']));
        $current_plugin_config = m('plugin')->getConfig($_B['current_plugin']);;
        $this->result(0, 'success', $current_plugin_config);
    }
}
