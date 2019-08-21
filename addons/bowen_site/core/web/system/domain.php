<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/04 23:15:31] -->
 */
defined('IN_IA') or exit('Access Denied');

class Domain_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W, $_GPC, $_B;
        
        $_W['page']['title'] = '域名管理';
        $_B['siteroot'] = $_W['siteroot'];
        include $this->mytemplate('system/domain');
	}
    
    public function getDomains()
    {
       global $_W, $_GPC, $_B;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "非法访问"));
        }
        
        $commoncondition = "";
        
        if (!empty($_GPC['domain'])) {
            $commoncondition .= " AND domain LIKE '%{$_GPC['domain']}%' ";
        }
        
        if ($_GPC['status'] != '') {
            $commoncondition .= " AND status LIKE {$_GPC['status']} ";
        }
        
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $commoncondition .= " AND uniacid LIKE {$_W['uniacid']} ";
        }
          
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
        $count = $this->countAll($this->table_domain, $commoncondition);
        $list = $this->getAll($this->table_domain, $commoncondition, array('displayorder DESC'), array($pindex, $psize));
        
        if(!empty($list)){
            for($i=0;$i<count($list);$i++){
                if(!empty($list[$i]['uniacid'])){
                    $list[$i]['account'] = uni_account_default($list[$i]['uniacid']);
                    $list[$i]['account_name'] = $list[$i]['account']['name'];
                }
                $list[$i]['createtime'] = date('Y-m-d H:i:s', $list[$i]['createtime']);
            }
        }
        
        $this->result(0, 'success', $list, array('count' => $count));
    }
    
    public function post()
    {
       global $_W,$_GPC, $_B;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        
        /** 非站长 */
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $_GPC['uniacid'] = $_W['uniacid'];
            $_GPC['tourl'] = '';
            $_GPC['status'] = 0;
        }
        
        $id = intval($_GPC['id']);
        $data = array(
            'type' => intval($_GPC['type']),
            'uniacid' => intval($_GPC['uniacid']),
            'tourl' => trim($_GPC['tourl']),
            'compatible_site_welcome_module' => trim($_GPC['compatible_site_welcome_module']),
            'displayorder' => intval($_GPC['displayorder']),
            'ishttps' => !empty($_GPC['ishttps'])?1:0,
            'remark' => $_GPC['remark'],
            'status' => intval($_GPC['status'])
        );
        
        $domain = trim($_GPC['domain']);
        
        /** 检查是否已经存在域名 */
        $check = pdo_fetch('SELECT id FROM ' . tablename($this->table_domain) . ' WHERE domain=:domain LIMIT 1', array(':domain' => $domain));
        
        if(empty($id)){
            $data['domain'] = $domain;
            $data['createtime'] = TIMESTAMP;
            if(!empty($check)){
                $this->result(2, '当前域名在系统中已经存在记录，如需修改，请联系管理员');
            }
            $result = pdo_insert($this->table_domain, $data);
        }else{
            if(empty($check)){
                $data['domain'] = $domain;
            }elseif($check['id'] != $id){
                $this->result(2, '当前域名在系统中已经存在记录，如需修改，请联系管理员');
            }
            $result = pdo_update($this->table_domain, $data, array('id'=>$id));
        }
        if(!empty($result)){
            m('cache')->del('webpage_domain', $_W['uniacid']);
            if(!empty($data['uniacid']))m('cache')->del('webpage_domains', $data['uniacid']);
            if($data['status'] == 0){
                m('notice')->taskNotice('domain_add');
            }
        }
        $this->result(0, '操作成功');
    }
    
    public function delete()
    {
       global $_W,$_GPC,$_B;
        
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        
		$id = intval($_GPC['id']);

        if (empty($id) && is_array($_GPC['checkData'])) {
            $ids = array();
            foreach($_GPC['checkData'] as $info){
                foreach($info as $k => $v){
                    if($k == 'id'){
                        $ids[] = $v;
                    }
                }
            }
			$id = (!empty($ids) && is_array($ids)) ? implode(',', $ids) : 0;
		}
        if (empty($id)) {
			$this->result(2, "参数错误，无效的ID");
		}
        
		$domains = pdo_fetchall('SELECT id,domain,uniacid FROM ' . tablename($this->table_domain) . ' WHERE id in( ' . $id . ' )');
        
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
		
        if($domains){
            m('cache')->del('webpage_domain', $_W['uniacid']);
        }
        
        foreach ($domains as $domain) {
            /** 非站长 */
            if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
                if((!empty($domain['uniacid']) && $domain['uniacid'] != $_W['uniacid']) || empty($domain['uniacid'])){
                    $this->result(1, "权限不足！如需操作，请联系管理员", $domains);
                }
            }
			pdo_delete($this->table_domain, array('id' => $domain['id']));
		}
        
		$this->result(0, "操作成功", $domains);
    }
    
    public function changeStatus(){
       global $_GPC, $_B, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $status = intval($_GPC['status']);
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $this->result(2, '如需操作，请联系客服');
        }
        $status = empty($status)?1:0;
        $change_data = array(
            'status' => $status
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_domain, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '状态切换成功', array('status' => $status));
        }
        $this->result(2, '未知错误');
    }
}
