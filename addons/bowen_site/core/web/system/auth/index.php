<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:13:52] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends SystemPage 
{
	public function main() 
	{
	   global $_W,$_GPC;
        $_W['page']['title'] = '授权维护';
        $sign = 'pc_auth';
        
        $oauth = array();
        $oauth['domain'] = $_SERVER['HTTP_HOST'];
        $oauth['ip'] = gethostbyname($_SERVER['HTTP_HOST']);
        $setting = setting_load('site');
        $copysite = m('common')->getModuleSetting(0);
        $oauth['oauth_code'] = $copysite['oauth_info']['oauth_code'];
        $oauth['id'] =isset($setting['site']['key'])? $setting['site']['key'] : '1';
        $oauth['module']= MODULE_NAME;
        
        if(checksubmit('check')){
            $copysite_data = array(
                'obj' => 0,
                'setkey' => 'core',
                'value' => array(
                    'oauth_info' => array(
                        'oauth_code' => trim($_GPC['oauth_code'])
                    ),
                ),
                'updatetime' => TIMESTAMP
            );
            $result = m('common')->saveModuleSetting($copysite_data,'0');
            itoast('操作成功', 'refresh', 'success');
        }
        
        include $this->mytemplate("system/auth/index{$_GPC['v']}");
	}
}
