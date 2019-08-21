<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/21 1:11:06] -->
 */
defined('IN_IA') or exit('Access Denied');
require_once M_PLUGIN . 'pcsite/core/page_admin.php';

class Index_Page extends PcsiteAdminPage
{
    public function login()
    {
       global $_W, $_GPC;
        
        $_W['page']['title'] = '登录设置-独立后台';
        if($_W['isajax'] && $_W['ispost']){
            $isthirdlogin = !empty($_GPC['isthirdlogin'])?1:0;
            
            if(!empty($isthirdlogin) && empty($_GPC['redirect_uri'])){
                $this->result(1, '回调域名不能为空！');
            }
            
            $data = array();
            $data['value'] = array(
                'login' => array(
                    'title' => trim($_GPC['title'])
                    ,'title_vice' => trim($_GPC['title_vice'])
                    ,'isthirdlogin' => $isthirdlogin
                    ,'redirect_uri' => trim($_GPC['redirect_uri'])
                    ,'aft_action' => intval($_GPC['aft_action'])
                    ,'allow_to_we7' => intval($_GPC['allow_to_we7'])
                )
            );
            
            $result = m('common')->saveModuleSetting($data, 0, 'pcsite');
            if(!empty($result)){
                $this->result(0, '操作成功');
            }
            $this->result(1, '未知错误');
        }
        $login_setting = m('common')->getModuleSetting(0, 'pcsite', 'login');
        include $this->mytemplate();
    }
    
    public function copyright()
    {
       global $_W, $_GPC;
        $_W['page']['title'] = '版权设置-独立后台';
        if($_W['isajax'] && $_W['ispost']){
            
            $data = array(
                'copyright' => array(
                    'backgroundImages' => iserializer($_GPC['backgroundImages'])
                    ,'backgroundImages_showType' => intval($_GPC['backgroundImages_showType'])
                )
            );
            
            $result = m('common')->saveModuleSetting($data, 0, 'pcsite');
            if(!empty($result)){
                $this->result(0, '操作成功');
            }
            $this->result(1, '未知错误');
        }
        $copyright_setting = m('common')->getModuleSetting(0, 'pcsite', 'copyright');
        $copyright_setting['backgroundImages'] = iunserializer($copyright_setting['backgroundImages']);
        include $this->mytemplate();
    }
    
    public function getPcsiteSet(){
        global $_W, $_GPC;
        if($_W['ispost'] && $_W['isajax']){
            $set_pcsite = m('common')->getModuleSetting(0, 'pcsite');
            if(!empty($set_pcsite)){
                $this->result(0, 'success', $set_pcsite);
            }
            $this->result(-1, 'Data Is Empty.');
        }
    }

}