<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:42:40] -->
 */
defined('IN_IA') or exit('Access Denied');

class Logout_Page extends PluginWebPage
{
    public function main()
    {
        global $_W, $_GPC;
        
        $url = webUrl('pcsite/user/login');
        if(!$_GPC['__ispcsite']){
            $url = url('user/login');
        }
        isetcookie('__session', '', -10000);
        isetcookie('__switch', '', -10000);
        isetcookie('__ispcsite', '', -10000);
        if(!$_W['isajax']){
            header('Location:' . $url);
        }
        $this->result(0, '退出成功', array('re_url' => $url));
    }
}
