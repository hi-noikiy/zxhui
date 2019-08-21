<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 17:00:51] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{
    public function main()
    {
        header('location: ' . webUrl('pcsite/webapp/display'));
    }

    public function display()
    {
        global $_W, $_GPC;
        load()->model('webapp');
         $_W['page']['title'] = 'PC建站列表';
        $account_info = permission_user_account_num();
        
        $pindex = max(1, intval($_GPC['page']));
    	$psize = 15;
    
    	$account_table = table('webapp');
    	$account_table->searchWithType(array(ACCOUNT_TYPE_WEBAPP_NORMAL));
    
    	$keyword = trim($_GPC['keyword']);
    	if (!empty($keyword)) {
    		$account_table->searchWithKeyword($keyword);
    	}
    
    	$account_table->accountRankOrder();
    	$account_table->searchWithPage($pindex, $psize);
    	$list = $account_table->searchAccountList();
    	$total = $account_table->getLastQueryTotal();
    
    	$pager = pagination($total, $pindex, $psize);
    
    	if (!empty($list)) {
    		foreach ($list as &$account) {
    			$account = uni_fetch($account['uniacid']);
    			$account['switchurl'] = webUrl('pcsite/webapp/doswitch', array('uniacid' => $account['uniacid']));
    		}
    	}
        include $this->mytemplate();
    }
    
    public function doswitch()
    {
        global $_W, $_GPC;
        load()->model('webapp');
        load()->model('account');
        
        $uniacid = intval($_GPC['uniacid']);
       	if (empty($uniacid)) {
  		    itoast('', webUrl('pcsite/webapp/display'), 'info');
       	}
       	uni_account_save_switch($uniacid, WEBAPP_TYPE_SIGN);
       	itoast('', webUrl());
    }

}
