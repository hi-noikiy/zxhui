<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/04 16:00:42] -->
 */
defined('IN_IA') or exit('Access Denied');

class Account_Page extends WebPage 
{
	public function main() 
	{
	   global $_GPC;
        load()->model('wxapp');
        load()->model('phoneapp');

        $pindex = max(1, intval($_GPC['page']));
    	$psize = 12;
    
    	$type = safe_gpc_string($_GPC['type']);
    	$type = in_array($type, array('all', ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN)) ? $type : 'all';
        
    	if ($type == 'all') {
    		$tableName = ACCOUNT_TYPE_SIGN;
    		$condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL, ACCOUNT_TYPE_PHONEAPP_NORMAL);
    		$fields = 'a.uniacid,b.type';
    	} elseif ($type == ACCOUNT_TYPE_SIGN) {
    		$tableName = ACCOUNT_TYPE_SIGN;
    		$condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH);
    	} elseif ($type == WXAPP_TYPE_SIGN) {
    		$tableName = WXAPP_TYPE_SIGN;
    		$condition = array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH);
    	} elseif ($type == WEBAPP_TYPE_SIGN) {
    		$tableName = WEBAPP_TYPE_SIGN;
    		$condition = array(ACCOUNT_TYPE_WEBAPP_NORMAL);
    	} elseif ($type == PHONEAPP_TYPE_SIGN) {
    		$tableName = PHONEAPP_TYPE_SIGN;
    		$condition = array(ACCOUNT_TYPE_PHONEAPP_NORMAL);
    	}
    
    	$table = table($tableName);
    	$table->searchWithType($condition);
    
    	$keyword = safe_gpc_string($_GPC['keyword']);
    	if (!empty($keyword)) {
    		$table->searchWithKeyword($keyword);
    	}
    
    	$letter = safe_gpc_string($_GPC['letter']);
    	if (isset($letter) && strlen($letter) == 1) {
    		$table->searchWithLetter($letter);
    	}
    
    	$table->accountRankOrder();
    	$table->searchWithPage($pindex, $psize);
    	$list = $table->searchAccountListFields($fields);
    	$total = $table->getLastQueryTotal();
    	$list = array_values($list);
        
        foreach($list as &$account) {
    		$account = uni_fetch($account['uniacid']);
    	}
        
        $result = $list;
        
        if(!empty($result)){
            $this->result('0', 'success', $result);
        }else{
            $this->result('1', '未搜索到结果', array('keyword'=>$keyword));
        }
	}
}
