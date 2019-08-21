<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/20 22:12:28] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W;
        $_W['page']['title'] = '模板切换';

        include $this->mytemplate('setting/themes');
	}
    
    public function getThemes() 
	{
	   global $_W,$_B;
        if($_W['isajax']){
            $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
            $mobilethemes = $this->getThemes_mobile();
            if(!empty($_B['core_settings']['is_open_perm']))$uni_perm = m('common')->getModuleSetting($_W['uniacid'], 'uni_perm');
            $themes = array();
            if(!empty($mobilethemes)){
                for($i = 0;$i < count($mobilethemes); $i++){
                    if(!empty($_B['core_settings']['is_open_perm']) && !in_array($mobilethemes[$i], $uni_perm['themes'])){
                        continue;
                    }
                    $themes[$i] = $this->getThemes_mobile_config(array('name', 'title', 'tag'), $mobilethemes[$i]);
                    $themes[$themes[$i]['name']] = $themes[$i];
                    $themes[$themes[$i]['name']]['tag'] = explode('|', $themes[$i]['tag']);
                    $preview = ($themes[$i]['name'] == 'advertising_design')?"../addons/bowen_site/template/mobile/t2static/preview":"../addons/bowen_site/template/mobile/" . $themes[$i]['name'] . "/preview";
                    $preview = is_file($preview.'-custom.jpg')?$preview.'-custom.jpg':$preview.'.jpg';
                    $preview = is_file($preview)?$preview:"../addons/bowen_site/template/mobile/default/preview.jpg";
                    $themes[$themes[$i]['name']]['preview'] = $preview;
                    unset($themes[$i],$preview);
                    if(empty($themes[$themes[$i]['name']])){
                        unset($themes[$themes[$i]['name']]);
                    }
                }
            }
            $themes = sortArrByManyField($themes);
            $this->result(0, 'success', $themes, array('pages' => 1, 'current' => $_B['setting']['global']['mobilethemes']));
        }
        exit($this->result(1, 'Access Denied'));
	}
    
    public function changeMobileTheme()
    {
       global $_W,$_GPC,$_B;
        if($_W['isajax'] && $_W['ispost']){
            if(TEST_SITE){$this->result(5, '测试站禁止操作数据');}
            $uniacid = intval($_W['uniacid']);
            $mobilethemes = trim($_GPC['mobilethemes']);
            $_B['setting'] = m('common')->getModuleSetting($_W['uniacid'], 'setting');
            
            if($mobilethemes != $_B['setting']['global']['mobilethemes']){
                $_B['setting']['global']['mobilethemes'] = $mobilethemes;
                $data = array(
                    'setkey' => 'setting',
                    'value' => array(
                        'global' => $_B['setting']['global'],
                    )
                );
                $result = m('common')->saveModuleSetting($data, $_W['uniacid'], 'setting');
                
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
            }
            $this->result(0, '操作成功');
        }
        $this->result(1, 'Access Denied');
    }
}
