<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/12 12:34:12] -->
 */
defined('IN_IA') or exit('Access Denied');

class Msg_Page extends ComWebPage
{
    public function __construct()
    {
        global $_W;
        parent::__construct();
        if(!$_W['isajax'] || !$_W['ispost']){
            $this->result(2, '参数错误，非法访问');
        }
    }

    public function main(){
        global $_GPC;
        $level = !empty($_GPC['level'])?trim($_GPC['level']):'nor';
        $sign_config = m('notice')->_notice_sign_config;
        if(!empty($sign_config)){
            foreach($sign_config as $k => $v){
                if($level != 'sys' && $sign_config[$k]['level'] == 'sys'){
                    unset($sign_config[$k]);
                    continue;
                }elseif($level == 'sys' && $sign_config[$k]['level'] != 'sys'){
                    unset($sign_config[$k]);
                    continue;
                }
                $sign_config[$k]['param'] = m('notice')->getNotice($k, $level);
                if(!empty($sign_config[$k]['param'])){
                    $sign_config[$k]['param']['sets'] = m('notice')->getNoticeSets($sign_config[$k]['param']['id']);
                }
            }
        }
        $this->result(0, 'success', $sign_config);
    }

    public function post(){
        global $_GPC;
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = m('notice')->setNoticeTask($_GPC['to'], $_GPC['tplid'], $_GPC['status'], $_GPC['openid'], $_GPC['level']);
        if(!empty($result)){
            $this->result(0, '保存成功');
        }
        $this->result(2, '操作失败，未知错误');
    }

    public function getMsgSign(){
        global $_W, $_GPC;
        $params = array();
        $condition = '';
        if($_GPC['status'] != ''){
            $condition .= 'AND s.status = :status';
            $new_params = array(':status' => intval($_GPC['status']));
            $params = (!empty($params) && is_array($params))?array_merge($params, $new_params):$new_params;
        }

        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $condition .= 'AND s.uniacid = :uniacid';
            $new_params = array(':uniacid' => $_W['uniacid']);
            $params = (!empty($params) && is_array($params))?array_merge($params, $new_params):$new_params;
        }

        if(!empty($condition)){
            $condition = ltrim($condition," AND");
            $condition = ltrim($condition,"AND");
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?$_GPC['psize']:15;
        $limitsql = SqlPaser::parseLimit(array($pindex, $psize));
        $orderbysql = ' ORDER BY s.id DESC ';
        $center_sql =  tablename($this->table_msg_sign) . ' s left join ' . tablename($this->table_notice) . ' n on s.taskid = n.id '. (!empty($condition) ? " WHERE {$condition} " : '');

        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . $center_sql, $params);
        $items = pdo_fetchall('SELECT s.id,s.uniacid,s.type,s.openid,s.nickname,s.param,s.status,s.log,n.sign as n_sign,n.template_id as n_template_id FROM '.$center_sql.$orderbysql.$limitsql, $params);
        $pages = ceil($count/$psize);

        if(!empty($items)){
            $msg_type_config = m('task')->_msg_type_config;
            $notice_sign_config = m('notice')->_notice_sign_config;
            foreach ($items as $key => $item){
                if($item['type'] == 0){
                    $items[$key]['type'] = $msg_type_config[$item['type']]['title'];
                    $items[$key]['sign'] = $notice_sign_config[$item['n_sign']]['title'];
                    $items[$key]['msg_title'] = $notice_sign_config[$item['n_sign']]['tpl_title'];
                    $items[$key]['tpl_id'] = $item['n_template_id'];
                }
                $items[$key]['param'] = iunserializer($items[$key]['param']);
            }
        }

        $this->result(0, 'success', $items, array('pages'=>$pages));
    }

    public function resetStatus(){
        global $_W, $_GPC;
        $changeData = array(
            'status' => 0,
            'donetime' => 0,
            'log' => NULL
        );
        $params = array('id' => intval($_GPC['id']));
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $new_params = array('uniacid' => $_W['uniacid']);
            $params = (!empty($params) && is_array($params))?array_merge($params, $new_params):$new_params;
        }
        $resullt = pdo_update($this->table_msg_sign, $changeData, $params);
        if(!empty($resullt)){
            $this->result(0, '状态重置成功', $resullt);
        }
        $this->result(2, '重置失败，未知错误，请联系管理员', $resullt);
    }
    
    public function sendSingle(){
       global $_W,$_GPC;
        $condition = 'AND s.id = :id';
        $params = array(':id' => intval($_GPC['id']));
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            $condition .= 'AND s.uniacid = :uniacid';
            $new_params = array(':uniacid' => $_W['uniacid']);
            $params = (!empty($params) && is_array($params))?array_merge($params, $new_params):$new_params;
        }
        if(!empty($condition)){
            $condition = ltrim($condition," AND");
            $condition = ltrim($condition,"AND");
        }
        $sql = 'SELECT s.id,s.uniacid,s.type,s.openid,s.nickname,s.param,n.sign as n_sign,n.template_id as n_template_id FROM ' . tablename($this->table_msg_sign) . ' s left join ' . tablename($this->table_notice) . ' n on s.taskid = n.id '. (!empty($condition) ? " WHERE {$condition} " : '' . 'LIMIT 1');
        $item = pdo_fetch($sql, $params);
        if(!empty($item)){
            $param = array(
                'id' => $item['id'],
                'uniacid' => $item['uniacid'],
                'openid' => $item['openid'],
                'template_id' => $item['n_template_id'],
                'nickname' => $item['nickname'],
                'sign' => $item['n_sign']
            );
            $resullt = m('notice')->send($param);
            if(!empty($resullt))$this->result(0, '发送成功');
        }
        $this->result(2, '发送失败，未知错误，请联系管理员', $resullt);
    }
}
