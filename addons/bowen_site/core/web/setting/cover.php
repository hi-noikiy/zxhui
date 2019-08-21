<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:09:11] -->
 */
defined('IN_IA') or exit('Access Denied');

class Cover_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $_W['page']['title'] = '入口';
        
        include $this->mytemplate('setting/cover/list');
        //header('location: ' . webUrl('setting/cover/foreg'));
	}
    
    public function foreg() 
	{
	   global $_W,$_GPC,$_B;
        
        include $this->mytemplate('setting/cover/foreg');
	}
    
    public function listinfo(){
       global $_W;
        $data = array(
            array(
                'id' => 1
                ,'title' => '网站首页'
                ,'url' => foregUrl('', '', true)
            ),
            
            array(
                'id' => 2
                ,'title' => '后台登录地址'
                ,'url' => webUrl('pcsite/user/login', '', true)
            ),
        );
        exit($this->result(0, 'success', $data));
    }
}
