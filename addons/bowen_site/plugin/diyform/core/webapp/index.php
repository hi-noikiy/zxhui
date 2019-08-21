<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/08 17:17:32] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebappPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $id = intval($_GET['id']);
        if(empty($id)){
            mymessage('参数错误，表单ID为空', '', 'error');
        }
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $table = $_B['current_plugin_config']['table'];
        $item = pdo_fetch('SELECT * FROM ' . tablename($table['temp']) . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
        $dfields = iunserializer($item['fields']);
        $item['title'] = !empty($item['title'])?$item['title']:'自定义表单';
        $_W['page']['title'] = $item['title']."-".$_B['setting']['global']['title'];
        
        if(empty($item['status'])){
            mymessage('当前表单不存在或已停止收集', '', 'error');
        }
        include $this->mytemplate();
	}
    
    public function post()
    {
       global $_W,$_GPC,$_B;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, '无效的访问方式'));
        }
        $table = $_B['current_plugin_config']['table'];
        $dfid = intval($_GPC['dfid']);
        $item = pdo_fetch('SELECT * FROM ' . tablename($table['temp']) . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $dfid, ':uniacid' => $_W['uniacid']));
        if(empty($item)){
            exit($this->result(-1, '参数错误，无效的表单'));
        }
        $dfields = iunserializer($item['fields']);
        
        $data = $this->model->getPostDatas($dfields);
        $insert_data = array(
            'uniacid' => $_W['uniacid']
            ,'dfid' => $item['id']
            ,'openid' => ($_W['openid']?$_W['openid']:0)
            ,'fields' => $item['fields']
            ,'data' => stripslashes(ijson_encode($data, JSON_UNESCAPED_UNICODE))
            ,'status' => '0'
            ,'remark' => ''
            ,'createtime' => TIMESTAMP
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_insert($table['data'], $insert_data);
        if(!empty($result)){
            m('notice')->taskNotice('diyform_add');
            $this->result(0, '提交成功');
        }
        $this->result(2, '数据提交失败，请联系客服');
    }
}