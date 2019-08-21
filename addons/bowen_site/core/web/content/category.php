<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/26 10:42:11] -->
 */
defined('IN_IA') or exit('Access Denied');

class Category_Page extends ComWebPage 
{
    public function getList(){
       global $_W;
        $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE uniacid LIKE :uniacid ORDER BY displayorder DESC,id ", array(':uniacid' => $_W['uniacid']));
        if(!empty($list)){
            for($i=0;$i<count($list);$i++){
                $class_themes = $this->getThemes_mobile_config('class');
                $list[$i]['themes_title'] = !empty($list[$i]['themes'])?$class_themes[$list[$i]['themes']]['title']:'文章页面';
            }
        }
        $this->result(0, 'ok', $list);
    }
    
    public function updateField(){
        global $_GPC, $_B, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $field = trim($_GPC['field']);
        $value = trim($_GPC['value']);
        if(empty($id) || empty($field) || ($value == '' && $field != 'tourl') || !in_array($field, array('displayorder', 'title', 'tourl', 'sign'))){
            $this->result(2, "参数错误，无效的参数");
        }
        if($field == 'displayorder')$value=intval($value);
        $change_data = array(
            $field => $value
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_classes, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '编辑成功', array($field => $value));
        }
        $this->result(2, '未知错误');
        
    }
    
    public function  changeStatus(){
       global $_GPC, $_B, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $status = intval($_GPC['status']);
        $status = empty($status)?1:0;
        $change_data = array(
            'status' => $status
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_classes, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '分类状态切换成功', array('status' => $status));
        }
        $this->result(2, '未知错误');
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
        
		$items = pdo_fetchall('SELECT id,title FROM ' . tablename($this->table_classes) . ' WHERE id in( ' . $id . ' )');
        
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
		
        foreach ($items as $item) {
            pdo_delete($this->table_classes, array('parid' => $item['id']));
			pdo_delete($this->table_classes, array('id' => $item['id']));
		}
        
		$this->result(0, "操作成功", $items);
    }
}
