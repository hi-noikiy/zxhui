<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:58:36] -->
 */
defined('IN_IA') or exit('Access Denied');
require_once M_PLUGIN . 'pcsite/core/page_admin.php';

class Index_Page extends PcsiteAdminPage
{
    public function main()
    {
       global $_W, $_GPC;
        $_W['page']['title'] = '注册设置-独立后台';
        
        $register_setting = m('common')->getModuleSetting(0, 'pcsite', 'register');
        include $this->mytemplate();
    }
    
    public function postSetBase(){
       global $_W, $_GPC;
        if($_W['isajax'] && $_W['ispost']){
            $isthirdlogin = !empty($_GPC['isthirdlogin'])?1:0;
            $isopen = !empty($_GPC['isopen'])?1:0;
            
            $data = array();
            $data['value'] = array(
                'register' => array(
                    'title' => trim($_GPC['title'])
                    ,'title_vice' => trim($_GPC['title_vice'])
                    ,'isopen' => $isopen
                    ,'register_open_type' => intval($_GPC['register_open_type'])
                    ,'register_default_type' => trim($_GPC['register_default_type'])
                    ,'isthirdlogin' => $isthirdlogin
                    ,'smstype' => intval($_GPC['smstype'])
                )
            );
            
            $result = m('common')->saveModuleSetting($data, 0, 'pcsite');
            if(!empty($result)){
                $this->result(0, '操作成功');
            }
            $this->result(1, '未知错误');
        }
    }
    
    public function  getDomainVicefounder(){
       global $_GPC,$_W;
        $table = $_W['current_plugin_config']['table'];
        $commoncondition = '';
        
        if (!empty($_GPC['id'])) {
            $commoncondition .= " AND id = " . intval($_GPC['id']) . " ";
        }
        
        if (!empty($_GPC['domain'])) {
            $commoncondition .= " AND domain LIKE '%{$_GPC['domain']}%' ";
        }
        
        if (!empty($_GPC['owner_uid'])) {
            $commoncondition .= " AND owner_uid = " . intval($_GPC['owner_uid']) . " ";
        }
        
        if (!empty($_GPC['status'])) {
            $commoncondition .= " AND status = " . intval($_GPC['status']) . " ";
        }
        
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
        $count = $this->countAll($table['pcsite_domain'], $commoncondition);
        $list = $this->getAll($table['pcsite_domain'], $commoncondition, array('createtime DESC'), array($pindex, $psize));
        $groups = user_founder_group();
        if(!empty($list)){
            for($i = 0; $i < $count; $i++){
                $user = user_single($list[$i]['owner_uid']);
                $list[$i]['username'] = $user['username'];
                $list[$i]['group'] = $groups[$user['groupid']]['name'];
            }
        }
        $this->result(0, 'success', $list, array('count' => $count));
    }
    
    public function  postDomainVicefounder(){
       global $_GPC,$_W;
        if($_W['isajax'] && $_W['ispost']){
            $id = intval($_GPC['id']);
            if((stripos($_GPC['domain'], '/') !== false)){
                $this->result(1, '域名格式不正确');
            }
            $owner_uid = intval($_GPC['owner_uid']);
            $user = user_single($owner_uid);
            if($user['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER){
                $this->result(1, '您添加的用户不是副站长！');
            }
            $table = $_W['current_plugin_config']['table'];
            $data = array(
                'domain' => trim($_GPC['domain'])
                ,'owner_uid' => $owner_uid
                ,'status' => !empty($_GPC['status'])?1:0
                ,'remark' => trim($_GPC['remark'])
                ,'displayorder' => intval($_GPC['displayorder'])
            );
            if(!empty($id)){
                $result = pdo_update($table['pcsite_domain'], $data, array('id' => $id));
            }else{
                $data['createtime'] = TIMESTAMP;
                $result = pdo_insert($table['pcsite_domain'], $data);
            }
            $this->result(0, '操作成功');
        }
        exit($this->result(1, '未知错误'));
    }
    
    public function  changeDomainVicefounderStatus(){
       global $_GPC,$_W;
        if($_W['isajax'] && $_W['ispost']){
            $id = intval($_GPC['id']);
            $table = $_W['current_plugin_config']['table'];
            $status = intval($_GPC['status']);
            $status = empty($status)?1:0;
            $change_data = array(
                'status' => $status
            );
            $result = pdo_update($table['pcsite_domain'], $change_data, array('id' => $id));
            if(!empty($result)){
                $this->result(0, '状态切换成功', '', array('status' => $status));
            }
        }
        exit($this->result(1, '未知错误'));
    }
    
    public function  delDomainVicefounder(){
       global $_GPC,$_W;
        if($_W['isajax'] && $_W['ispost']){
            $id = intval($_GPC['id']);
            $table = $_W['current_plugin_config']['table'];
            if(empty($id)){
                $this->result(1, '参数错误');
            }
            $result = pdo_delete($table['pcsite_domain'], array('id' => $id));
            if(!empty($result)){
                $this->result(0, '删除成功');
            }
        }
        exit($this->result(1, '未知错误'));
    }
}