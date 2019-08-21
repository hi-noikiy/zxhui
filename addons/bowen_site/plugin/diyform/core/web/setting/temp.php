<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/20 14:45:10] -->
 */
defined('IN_IA') or exit('Access Denied');

class Temp_Page extends PluginWebPage
{
	public function main()
	{
       global $_W,$_GPC,$_B;
        
        if($_W['isajax'] && $_W['ispost']){
            $table = $_B['current_plugin_config']['table'];
            $commoncondition = " uniacid = {$_W['uniacid']} ";
            
            if (!empty($_GPC['id'])) {
                $commoncondition .= " AND id = " . intval($_GPC['id']) . " ";
            }
            
            if (!empty($_GPC['title'])) {
                $commoncondition .= " AND title LIKE '%{$_GPC['title']}%' ";
            }
            
            if (!empty($_GPC['status'])) {
                $commoncondition .= " AND status = " . intval($_GPC['status']) . " ";
            }
            
            $pindex = max(1, intval($_GPC['page']));
            $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
            $count = $this->countAll($table['temp'], $commoncondition);
            $list = $this->getAll($table['temp'], $commoncondition, array('createtime DESC'), array($pindex, $psize));
            
            $this->result(0, 'success', $list, array('count' => $count));
        }
        
        $_W['page']['title'] = "模板管理";
        
		include $this->mytemplate();
	}

    public function changeStatus(){
       global $_GPC, $_B, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $id = intval($_GPC['id']);
        $table = $_B['current_plugin_config']['table'];
        $status = intval($_GPC['status']);
        $status = empty($status)?1:0;
        $change_data = array(
            'status' => $status
        );
        $result = pdo_update($table['temp'], $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '状态切换成功', array('status' => $status));
        }
    }

    public function post()
	{
	   global $_W, $_B, $_GPC;
        $table = $_B['current_plugin_config']['table'];
		$globalData = $this->model->globalData();
		extract($globalData);
		
        $id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename($table['temp']) . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$dfields = iunserializer($item['fields']);
		}

		if ($_W['isajax'] && $_W['ispost']) {
            if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
			$data = $this->model->getInsertDataByAdmin();
			$update_data = array(
                'cid' => 0
                ,'title' => trim($_GPC['tp_title'])
                ,'description' => trim($_GPC['description'])
                ,'fields' => iserializer($data)
                ,'iscache' => intval($_GPC['tp_iscache'])
                ,'status' => intval($_GPC['tp_status'])
                ,'updatetime' => TIMESTAMP
            );

			if (empty($id)) {
                $insert_data = array(
                    'uniacid' => $_W['uniacid']
                    ,'createtime' => TIMESTAMP
                );
                $insert = array_merge($insert_data, $update_data);
				pdo_insert($table['temp'], $insert);
                $id = pdo_insertid();
			}else {
				pdo_update($table['temp'], $update_data, array('id' => $id));
			}

			$this->result(0, '操作成功', array('re_id' => $id));
		}
        $_W['page']['title'] = '编辑模板';
		include $this->mytemplate();
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
			$this->result(2, "参数错误，无效的模板ID");
		}
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
		$temps = pdo_fetchall('SELECT id,title  FROM ' . tablename($_B['current_plugin_config']['table']['temp']) . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($temps as $temp) {
			pdo_delete($_B['current_plugin_config']['table']['temp'], array('id' => $temp['id']));
			pdo_delete($_B['current_plugin_config']['table']['data'], array('dfid' => $temp['id']));
		}

		$this->result(0, "操作成功");
	}
    
    public function dataList()
    {
       global $_W, $_GPC, $_B;
       
        $dfid = intval($_GPC['dfid']);
        
        if(empty($dfid)){
            exit($this->result(-1, "缺少有效参数"));
        }
        
        $table = $_B['current_plugin_config']['table'];
        
        $globalData = $this->model->globalData();
		extract($globalData);
        
        $item = pdo_fetch('SELECT * FROM ' . tablename($table['data']) . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $dfid, ':uniacid' => $_W['uniacid']));
        $fields = iunserializer($item['fields']);
        
        if($_W['isajax'] && $_W['ispost']){
            
            $commoncondition = " dfid = {$dfid} AND uniacid = {$_W['uniacid']} ";
            
            if (!empty($_GPC['id'])) {
                $commoncondition .= " AND id = " . intval($_GPC['id']) . " ";
            }
            
            if (!empty($_GPC['kw'])) {
                $commoncondition .= " AND data LIKE '%{$_GPC['kw']}%' ";
            }
            
            if (!empty($_GPC['filed']) && !empty($_GPC['fvalue'])) {
                
                //$commoncondition .= " AND data LIKE '%{$_GPC['kw']}%' ";
            }
            
            $pindex = max(1, intval($_GPC['page']));
            $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
            $count = $this->countAll($table['data'], $commoncondition);
            $list = $this->getAll($table['data'], $commoncondition, array('createtime DESC'), array($pindex, $psize));
            
            if(!empty($list)){
                for($i=0;$i<count($list);$i++){
                    $dfields = iunserializer($list[$i]['fields']);
                    if(!empty($dfields)){
                        $pinyinToText = array();
                        foreach($dfields as $k1 => $v1){
                            $pinyinToText['/'.$k1.'/'] = $v1['tp_name'];
                        }
                    }
                    $pattern = array_keys($pinyinToText);
                    $replace = array_values($pinyinToText);
                    $list[$i]['data'] = preg_replace($pattern, $replace, $list[$i]['data']);
                }
            }
            
            $this->result(0, 'success', $list, array('count' => $count));
        }
        $_W['page']['title'] = '表单记录';
        include $this->mytemplate();
    }

    public function detail()
    {
       global $_W,$_GPC,$_B;
        $id = intval($_GET['id']);
        if(empty($id)){
            exit($this->result(-1, "缺少有效参数"));
        }
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $table = $_B['current_plugin_config']['table'];
        $item = pdo_fetch('SELECT * FROM ' . tablename($table['data']) . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
        $dfields = iunserializer($item['fields']);
        $data = json_decode($item['data'], true);
        
        $_W['page']['title'] = '查看详情';
        
        include $this->mytemplate();
        
    }

	public function deleteData()
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
			$this->result(2, "参数错误，无效的模板ID");
		}
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
		$datas = pdo_fetchall('SELECT id,dfid  FROM ' . tablename($_B['current_plugin_config']['table']['data']) . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);
        if(!empty($datas)){
            foreach ($datas as $data) {
    			pdo_delete($_B['current_plugin_config']['table']['data'], array('id' => $data['id']));
    		}
    
    		$this->result(0, "操作成功");
        }
		$this->result(2, "未知错误", $id);
	}

	public function tpl()
	{
		global $_W, $_GPC;
		$globalData = $this->model->globalData();
		extract($globalData);
		$addt = $_GPC['addt'];
		$kw = $_GPC['kw'];
		$flag = intval($_GPC['flag']);
		$data_type = $_GPC['data_type'];
		$tmp_key = $kw;
		include $this->mytemplate();
	}
}
