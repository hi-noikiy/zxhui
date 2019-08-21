<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/25 23:24:51] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{   
    public function info()
    {
       global $_W, $_GPC;
        mychecklogin();
        if ($_W['role'] != 'founder') {
			itoast('权限不足，禁止访问', 'referer', 'error');
		}
        $_W['page']['title'] = '独立后台';
        
        include $this->mytemplate();
    }
    
    public function cover(){
        global $_W, $_GPC;
        unset($_GPC['s']);
        $data = array(
            array(
                'id' => 1
                ,'title' => '独立登录'
                ,'url' => webUrl('pcsite/user/login', '',true)
            ),
            array(
                'id' => 2
                ,'title' => '独立注册'
                ,'url' => webUrl('pcsite/user/register', '', true)
            ),
            /**
            array(
                'id' => "&nbsp;"
                ,'title' => '&nbsp;'
                ,'url' => "&nbsp;"
            ),
            array(
                'id' => 3
                ,'title' => '用户名登录'
                ,'url' => webUrl('pcsite/user/login', array('login_type' => 'system'),true)
            ),
            array(
                'id' => 4
                ,'title' => '手机登录'
                ,'url' => webUrl('pcsite/user/login', array('login_type' => 'mobile'),true)
            ),
            array(
                'id' => "&nbsp;"
                ,'title' => '&nbsp;'
                ,'url' => "&nbsp;"
            ),
            array(
                'id' => 5
                ,'title' => '用户名注册'
                ,'url' => webUrl('pcsite/user/register', array('register_type' => 'system'), true)
            ),
            array(
                'id' => 6
                ,'title' => '手机注册'
                ,'url' => webUrl('pcsite/user/register', array('register_type' => 'mobile'), true)
            ),
            */
        );
        exit($this->result(0, 'success', $data));
    }
}