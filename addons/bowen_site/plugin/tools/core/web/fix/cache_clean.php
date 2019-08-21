<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:43:13] -->
 */
defined('IN_IA') or exit('Access Denied');

class Cache_clean_Page extends PluginWebPage
{
    public function main()
    {
        global $_W, $_GPC;
        $uniacid = intval($_W['uniacid']);
        
        /** we7 */
        load()->model('cache');
        load()->model('setting');
        load()->object('cloudapi');
        
        $account_ticket_cache = cache_read(cache_system_key('account_ticket'));
        pdo_delete('core_cache');
        cache_clean();
        cache_write(cache_system_key('account_ticket'), $account_ticket_cache);
        unset($account_ticket_cache);

    	cache_build_template();
    	cache_build_users_struct();
    	cache_build_setting();
    	cache_build_frame_menu();
    	cache_build_module_subscribe_type();
    	cache_build_cloud_ad();
		pdo_delete('modules_cloud');
        
        /** 删除本模块的模板缓存 */
        rmdirs(IA_ROOT.'/data/tpl/bowen_site');
        /** 重新写入当前公众号 */
        uni_account_save_switch($uniacid);
       	uni_account_switch($uniacid);
        
        //itoast("操作成功！", '', 'success');
        include $this->mytemplate();
    }
    
}


