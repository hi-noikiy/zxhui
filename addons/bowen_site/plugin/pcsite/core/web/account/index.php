<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/23 0:10:43] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{
    public function main()
    {
        header('location: ' . webUrl('pcsite/account/display'));
    }

    public function display()
    {
        global $_W, $_GPC;
        load()->model('wxapp');
        load()->model('phoneapp');

        $_W['page']['title'] = '站点列表';

        $pindex = max(1, intval($_GPC['page']));
    	$psize = 10;
    
    	$type = safe_gpc_string($_GPC['type']);
    	$type = in_array($type, array('all', ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN)) ? $type : 'all';
        
    	if ($type == 'all') {
    		$tableName = ACCOUNT_TYPE_SIGN;
    		//$condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL, ACCOUNT_TYPE_PHONEAPP_NORMAL);
            $condition = array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL);
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
    		switch ($account['type']) {
    			case ACCOUNT_TYPE_OFFCIAL_NORMAL :
    			case ACCOUNT_TYPE_OFFCIAL_AUTH :
    				$account['role'] = permission_account_user_role($_W['uid'], $account['uniacid']);
    				break;
    			case ACCOUNT_TYPE_APP_NORMAL :
    			case ACCOUNT_TYPE_APP_AUTH :
    				$account['versions'] = wxapp_get_some_lastversions($account['uniacid']);
    				if (!empty($account['versions'])) {
    					foreach ($account['versions'] as $version) {
    						if (!empty($version['current'])) {
    							$account['current_version'] = $version;
    						}
    					}
    				}
    				break;
    			case ACCOUNT_TYPE_WEBAPP_NORMAL :
    				$account['switchurl'] = webUrl('pcsite/account/doswitch', array('uniacid' => $account['uniacid']));
    				break;
    			case ACCOUNT_TYPE_PHONEAPP_NORMAL :
    				$account['versions'] = phoneapp_get_some_lastversions($account['uniacid']);
    				if (!empty($account['versions'])) {
    					foreach ($account['versions'] as $version) {
    						if (!empty($version['current'])) {
    							$account['current_version'] = $version;
    						}
    					}
    				}
    				break;
    		}
    	}
    
    	if ($_W['ispost']) {
    		iajax(0, $list);
    	} 
        
        include $this->mytemplate();
    }

    public function doswitch()
    {
        load()->model('wxapp');
        load()->model('phoneapp');
        global $_W, $_GPC;
        $account_info = permission_user_account_num();
        $uniacid = intval($_GPC['uniacid']);
    	if (!empty($uniacid)) {
    		$account_info = uni_fetch($uniacid);
    		$type = $account_info['type'];
    		if ($type == ACCOUNT_TYPE_OFFCIAL_NORMAL || $type == ACCOUNT_TYPE_OFFCIAL_AUTH) {
    			$role = permission_account_user_role($_W['uid'], $uniacid);
    			if(empty($role)) {
    				itoast('操作失败, 非法访问.', '', 'error');
    			}
    			if (empty($_W['isfounder'])) {
    				$account_endtime = uni_fetch($uniacid);
    				$account_endtime = $account_endtime['endtime'];
    				if ($account_endtime > 0 && TIMESTAMP > $account_endtime) {
    					itoast('公众号已到期。', '', 'error');
    				}
    			}
    			uni_account_save_switch($uniacid);
    			//$module_name = trim($_GPC['module_name']);
                $module_name = MODULE_NAME;
    			$version_id = intval($_GPC['version_id']);
    			
                $url = url('home/welcome/ext', array('m' => $module_name, 'version_id' => $version_id, 's' => $_GPC['s']));
                
                if(!file_exists(MODULE_ROOT . '/map.json')){
                    if($uniacid == '76'){
                        $url = url('site/entry', array('m' => 'ewei_shopv2', 'do' => 'web'));
                    }
                }
                
    			uni_account_switch($uniacid, $url);
    		}
    
    		if ($type == ACCOUNT_TYPE_WEBAPP_NORMAL) {
    			$uniacid = intval($_GPC['uniacid']);
    			if (empty($uniacid)) {
    				itoast('', webUrl('pcsite/account/display', array('type' => WEBAPP_TYPE_SIGN)), 'info');
    			}
    			uni_account_save_switch($uniacid, WEBAPP_TYPE_SIGN);
    			itoast('', url('home/welcome/ext', array('m'=>MODULE_NAME, 's' => $_GPC['s'])));
    		}
    
    		if ($type == ACCOUNT_TYPE_APP_NORMAL || $type == ACCOUNT_TYPE_APP_AUTH || $type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
    			if ($type == ACCOUNT_TYPE_APP_NORMAL || $type == ACCOUNT_TYPE_APP_AUTH) {
    				$info = wxapp_fetch($uniacid);
    			} elseif ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
    				$info = phoneapp_fetch($uniacid);
    			}
    
    			if (!empty($info)) {
    				$module_name = safe_gpc_string($_GPC['module']);
    				$version_id = !empty($_GPC['version_id']) ? intval($_GPC['version_id']) : $info['version_id'];
    				if (!empty($module_name) && !empty($version_id)) {
    					$version_info = wxapp_version($version_id);
    					$module_info = array();
    					if (!empty($version_info['modules'])) {
    						foreach ($version_info['modules'] as $key => $module_val) {
    							if ($module_val['name'] == $module_name) {
    								$module_info = $module_val;
    							}
    						}
    					}
    					if (empty($version_id) || empty($module_info)) {
    						itoast('版本信息错误');
    					}
                        $url = url('home/welcome/ext', array('m' => $module_name, 's' => $_GPC['s']));
    					if (!empty($module_info['account']['uniacid'])) {
    						uni_account_switch($module_info['account']['uniacid'], $url);
    					} else {
    						$url .= '&version_id=' . $version_id;
    						if ($type == ACCOUNT_TYPE_APP_NORMAL || $type == ACCOUNT_TYPE_APP_AUTH) {
    							uni_account_switch($version_info['uniacid'], $url, WXAPP_TYPE_SIGN);
    						} elseif ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
    							uni_account_switch($version_info['uniacid'], $url, PHONEAPP_TYPE_SIGN);
    						}
    					}
    				}
    
    				if ($type == ACCOUNT_TYPE_APP_NORMAL || $type == ACCOUNT_TYPE_APP_AUTH) {
    					wxapp_update_last_use_version($uniacid, $version_id);
    					uni_account_switch($uniacid, url('wxapp/version/home', array('version_id' => $version_id)), WXAPP_TYPE_SIGN);
    				} elseif ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
    					phoneapp_update_last_use_version($uniacid, $version_id);
    					uni_account_switch($uniacid, url('phoneapp/version/home', array('version_id' => $version_id)), PHONEAPP_TYPE_SIGN);
    				}
    			} else {
    				if ($type == ACCOUNT_TYPE_APP_NORMAL || $type == ACCOUNT_TYPE_APP_AUTH) {
    					itoast('小程序不存在', referer(), 'error');
    				} elseif ($type == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
    					itoast('APP不存在', referer(), 'error');
    				}
    			}
    		}
    	}
        
    }

    public function rank()
    {
        global $_W, $_GPC;
        if ($_W['isajax'] && $_W['ispost']) {
            load()->model('wxapp');
            load()->model('phoneapp');
            
            $uniacid = intval($_GPC['uniacid']);
        	$type = intval($_GPC['type']);
        	if (!empty($uniacid)) {
        		$exist = uni_fetch($uniacid);
        		if (!$exist) {
        			iajax(1, '账号信息不存在', '');
        		}
        	}
        	uni_account_rank_top($uniacid);
        	iajax(0, '更新成功！', '');
        }
    }

}
