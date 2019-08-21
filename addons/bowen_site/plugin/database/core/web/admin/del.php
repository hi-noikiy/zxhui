<?php
/**
 * 玖祺企业官网模块
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/28 0:09:47] -->
 */
defined('IN_IA') or exit('Access Denied');

class Del_Page extends PluginWebPage
{
    public function main()
    {
       global $_W;
        $_W['page']['title'] = "数据清理";
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER && $_W['role'] != ACCOUNT_MANAGE_NAME_OWNER && $_W['role'] != ACCOUNT_MANAGE_NAME_MANAGER){
            mymessage('权限不足！', '', 'error');
        }
        include $this->mytemplate();
    }
    
    public function run(){
        global $_W, $_GPC;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result('2', '参数错误'));
        }
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER && $_W['role'] != ACCOUNT_MANAGE_NAME_OWNER && $_W['role'] != ACCOUNT_MANAGE_NAME_MANAGER){
            $this->result('2', '权限不足');
        }
        if(TEST_SITE){$this->result(5, '测试站禁止操作数据');}
        $uniacid = $_W['uniacid'];
        $op = trim($_GPC['op']);
        if(empty($op) || !in_array($op, array('nav', 'article', 'category', 'setting', 'all'))){
            $this->result('2', '参数错误');
        }
        /**
        elseif($op == 'nav'){
            $this->D_Nav($uniacid);
        }elseif($op == 'article'){
            $this->D_Article($uniacid);
        }elseif($op == 'category'){
            $this->D_Article($uniacid);
            $this->D_Category($uniacid);
        }elseif($op == 'setting'){
            $this->D_Setting($uniacid);
        }elseif($op == 'all'){
            $this->D_Nav($uniacid);
            $this->D_Article($uniacid);
            $this->D_Category($uniacid);
            $this->D_Setting($uniacid);
        }*/
        switch($op){
            case 'nav':
                $this->D_Nav($uniacid);
                break;
            case 'article':
                $this->D_Article($uniacid);
                break;
            case 'category':
                $this->D_Article($uniacid);
                $this->D_Category($uniacid);
                break;
            case 'setting':
                $this->D_Setting($uniacid);
                break;
            case 'all':
                $this->D_Nav($uniacid);
                $this->D_Article($uniacid);
                $this->D_Category($uniacid);
                $this->D_Setting($uniacid);
                break;
        }
        
        $this->result(0, '清理成功');
    }
    
    private function D_Category($uniacid){
        $result = pdo_delete($this->table_classes, array('uniacid' => $uniacid));
        return $result;
    }
    
    private function D_Article($uniacid){
        $result = pdo_delete($this->table_articles, array('uniacid' => $uniacid));
        return $result;
    }
    
    private function D_Nav($uniacid){
        $result = pdo_delete($this->table_navs, array('uniacid' => $uniacid));
        return $result;
    }
    
    private function D_Setting($uniacid){
        global $_W;
        $old_setting = m('common')->getModuleSetting($uniacid, 'setting');
        $result1 = m('common')->delModuleSetting($uniacid, 'setting');
        $data = array(
            'global' => array(
                'mobilethemes' => $old_setting['global']['mobilethemes']
            ),
        );
        $result2 = m('common')->saveModuleSetting($data, $uniacid, 'setting', true);
        $result = empty($result1)?$result1:$result2;
        
        return $result;
    }
    
    
    
}