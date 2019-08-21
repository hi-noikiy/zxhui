<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:12:52] -->
 */
defined('IN_IA') or exit('Access Denied');

class Navs_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W, $_GPC, $_B;
        $_W['page']['title'] = '导航设置';
        $settings = m('common')->getModuleSetting($_W['uniacid']);
        $id = intval($_GPC['id']);
        $op = trim($_GPC['op']);
        
        if($op == ''){
            $children = array();
    		$topnavs = pdo_fetchall('SELECT * FROM ' . tablename($this->table_navs) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
    		foreach ($topnavs as $index => $row) {
    			if (!empty($row['parid'])) {
    				$children[$row['parid']][] = $row;
    				unset($topnavs[$index]);
    			}
    		}
            
            include $this->mytemplate();
        }
        
        if($op == 'add' || $op == 'edit'){
            if($op == 'edit'){
                $nav = $this->getForegNavInfo($id);
                if(!empty($nav['parid'])){
                    $lastnav = $this->getForegNavInfo($nav['parid']);
                    if($nav['topid'] != $nav['parid'] && $nav['level'] == 3){
                        $topnav = $this->getForegNavInfo($nav['topid']);
                    }
                }
            }else{
                $level = 1;
                $lastnav = $this->getForegNavInfo($id);
                if(!empty($lastnav)){
                    $level = 2;
                    $topid = $parid = $lastnav['id'];
                    if(!empty($lastnav['parid'])){
                        $level = 3;
                        $topid = $lastnav['parid'];
                        $topnav = $this->getForegNavInfo($lastnav['parid']);
                    }
                }
            }
            
            if(checksubmit('submit')){
                $url = !empty($_GPC['url'])?trim($_GPC['url']):"#";
                $data = array(
                    'type' => 'topnav',
                    'title' => trim($_GPC['title']),
                    'sign' => trim($_GPC['sign']),
                    'url' => $url,
                    'target' => trim($_GPC['target']),
                    'status' => intval($_GPC['status']),
                    'displayorder' => intval($_GPC['displayorder'])
                );
                
                if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
                
                if($op == 'add'){
                    $data['topid'] = intval($topid);
                    $data['parid'] = intval($parid);
                    $data['level'] = intval($level);
                    $data['uniacid'] = $_W['uniacid'];
                    $result = pdo_insert($this->table_navs, $data);
                    $new_nav = pdo_insertid();
                }else{
                    $result = pdo_update($this->table_navs, $data, array('id'=>$id));
                }
                
                if($new_nav){
                    mymessage('新增导航成功', webUrl('setting/navs', array('op' => 'edit', 'id' => $new_nav)), 'success');
                    //mymessage('新增导航成功', webUrl('setting/navs'), 'success');
                }
                mymessage('操作成功', webUrl('setting/navs', array('op' => 'edit', 'id' => $id)), 'success');
            }
            
            include $this->mytemplate('setting/navs/post');
        }
        
        if($op == 'delete'){
            if(empty($id)){
                mymessage('参数错误', 'refresh', 'error');
            }
            
            if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
            $result = pdo_delete($this->table_navs, array('id'=>$id));
            if(!empty($result)){
                mymessage('删除成功', webUrl('setting/navs'),'success');
            }
        }
	}
    
    public function  changeStatus(){
       global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        //初始数据
        $errno = '0';
        $mymessage = '未知错误';
        $content['status'] = $data;
        
        empty($data)?($data = 1):$data = 0;
        if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_navs, array('status' => $data), array("id" => $id));
        if(!empty($result)){
            $errno = '0';
            $mymessage = 'ok';
            $content['status'] = $data;
        }
        
        $this->result($errno, $mymessage, $content);
    }
    
    public function upgradeNavs(){
        global $_W;
        $navs = pdo_fetchall('SELECT * FROM ' . tablename($this->table_navs));
        $i = 0;
        foreach($navs as $n){
            if(empty($n['level'])){
                $level = !empty($n['topid'])?2:1;
                $result = pdo_update($this->table_navs, array('parid' => $n['topid'], 'level' => $level), array('id'=>$n['id']));
                if(!empty($result)){
                    $i++;
                }
            }
        }
        if($i == 0){
            mymessage('导航数据已是最新，无需修复', 'referer','success');
        }
        mymessage('修复 ' . $i . '条 数据成功', 'referer','success');
    }
}
