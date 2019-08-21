<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/11/18 11:52:45] -->
 */
defined('IN_IA') or exit('Access Denied');

class Notice_Model
{
    private $table_notice = 'bowen_site_notice';
    private $table_notice_set = 'bowen_site_notice_set';
    private $table_msg_sign = 'bowen_site_msg_sign';

    public $_notice_sign_config = array(
        'diyform_add' => array(
            'sign' => 'diyform_add',
            'title' => '表单提交通知',
            'level' => 'nor',
            'template_id_short' => 'OPENTM207574677',
            'tpl_title' => '业务处理通知',
            'content' => array(
                'tpl' => array(
                    'first' => array(
                        'value' => "有用户提交了新的表单信息\n",
                        'color' => '#008040'
                    ),
                    'keyword1' => array(
                        'value' => "自定义表单 插件",
                        'color' => '#c2c2c2'
                    ),
                    'keyword2' => array(
                        'value' => "提交成功",
                        'color' => ''
                    ),
                    'keyword3' => array(
                        'value' => "有用户提交了新的表单信息，请及时处理",
                        'color' => ''
                    ),
                    'remark' => array(
                        'value' => "",
                        'color' => ''
                    )
                ),
                'text' => ""
            ),
            'url' => ''
        ),
        'domain_add' => array(
            'sign' => 'domain_add',
            'title' => '域名审核通知',
            'level' => 'sys',
            'template_id_short' => 'OPENTM207574677',
            'tpl_title' => '业务处理通知',
            'content' => array(
                'tpl' => array(
                    'first' => array(
                        'value' => "有用户提交了新的域名审核\n",
                        'color' => '#008040'
                    ),
                    'keyword1' => array(
                        'value' => "设置-域名管理",
                        'color' => '#c2c2c2'
                    ),
                    'keyword2' => array(
                        'value' => "待审核",
                        'color' => ''
                    ),
                    'keyword3' => array(
                        'value' => "有域名正在等待审核，请及时处理",
                        'color' => ''
                    ),
                    'remark' => array(
                        'value' => "",
                        'color' => ''
                    )
                ),
                'text' => ""
            ),
            'url' => ''
        ),

    );

    public function setNoticeTask($sign, $template_id, $status = 0, $openids = array(), $level = ''){
        global $_W;
        $uniacid = $_W['uniacid'];
        $sign = safe_gpc_string(trim($sign));
        $level = !empty($level)?trim($level):'nor';

        if($level == 'sys'){
            $oauth = m('common')->getModuleSetting(0, 'oauth');
            $uniacid = $oauth['account'];
            $check_all = pdo_fetchall('SELECT id,uniacid FROM ' . tablename($this->table_notice) . ' WHERE sign=:sign ', array(':sign' => $sign));
            foreach($check_all as $ck2){
                if($ck2['uniacid'] != $uniacid)pdo_delete($this->table_notice, array('id' => $ck2['id']));
            }
        }

        $check_task = pdo_fetch('SELECT id FROM ' . tablename($this->table_notice) . ' WHERE uniacid=:uniacid AND sign=:sign ', array(':uniacid' => $uniacid, ':sign' => $sign));

        $task_data = array();
        $task_data['template_id'] = safe_gpc_string(trim($template_id));
        $task_data['status'] = intval($status);
        $task_data['updatetime'] = TIMESTAMP;

        if(empty($check_task)){
            $task_data['uniacid'] = $uniacid;
            $task_data['sign'] = $sign;
            $result = pdo_insert($this->table_notice, $task_data);
            $taskid = pdo_insertid();
        }else{
            $taskid = $check_task['id'];
            $result = pdo_update($this->table_notice, $task_data, array('id' => $taskid));
        }
        m('cache')->del('notice_'.$sign, $uniacid);

        if(!empty($openids) && !empty($taskid)){
            $result = $this->setNotice($uniacid, $taskid, $openids);
        }

        return $result;
    }

    /** 存openid */
    private function setNotice($uniacid, $taskid, $openids, $param = array()){
        if(empty($openids))return false;
        $openids = (array)$openids;
        $openids = safe_gpc_array($openids);
        pdo_delete($this->table_notice_set, array('taskid' => $taskid, 'uniacid' => $uniacid));

        $params = array(':uniacid' => $uniacid);
        $sql = 'INSERT INTO ' . tablename($this->table_notice_set) . ' (uniacid,taskid,openid,nickname,param,createtime) ';
        $sql .= ' SELECT '.$uniacid.','.$taskid.',`openid`,`nickname`,\''.iserializer($param).'\','.TIMESTAMP.' FROM ' . tablename('mc_mapping_fans') . ' WHERE follow=1 AND uniacid=:uniacid ';

        $openids = (array)$openids;
        foreach ($openids as $key => $openid )
        {
            $openids[$key] = '\'' . $openid . '\'';
        }
        $sql .= ' AND openid in(' . implode(',', $openids) . ')';
        return pdo_query($sql, $params);
    }

    /** 将发送写入到任务队列中 */
    public function taskNotice($sign){
        $notice = $this->getNotice($sign);
        if(empty($notice['template_id']) || $notice['status'] != 0)return Null;
        $params = array(':taskid' => $notice['id']);
        $sql = 'INSERT INTO ' . tablename($this->table_msg_sign) . ' (uniacid,type,taskid,openid,nickname,param,status,createtime) ';
        $sql .= ' SELECT `uniacid`,0,`taskid`,`openid`,`nickname`,`param`,0,'.TIMESTAMP.' FROM ' . tablename($this->table_notice_set) . ' WHERE taskid=:taskid ';
        return pdo_query($sql, $params);
    }

    /**
     * 发送消息提醒
     * 仅由队列处理程序调用
     */
    public function send($param){
        $sign_config = $this->_notice_sign_config;

        if(empty($param['uniacid']))return false;
        /** 获取借权信息 */
        $oauth = m('common')->getOauth($param['uniacid']);
        $acid = $oauth['account'];
        if(!empty($acid)){
            $param['uniacid'] = m('common')->getUniacidByAcid($acid);;
        }
        $account_api = m('common')->getAccount($param['uniacid']);

        $result = m('wechatapi')->sendTplNotice($param['openid'], $param['template_id'], $sign_config[$param['sign']]['content']['tpl'], $sign_config[$param['sign']]['url'], '#FF683F', array(), $account_api);

        $data = array();
        $data['donetime'] = time();
        if (is_error($result)) {
            $data['status'] = 2;
            $data['log'] = $result['message'];
        }else {
            $data['status'] = 1;
        }
        pdo_update($this->table_msg_sign, $data, array('id' => $param['id']));

        return $result;
    }

    public function getNotice($sign, $level = ''){
        global $_W;
        $uniacid = $_W['uniacid'];
        $level = !empty($level)?trim($level):'nor';
        if($level == 'sys'){
            $oauth = m('common')->getModuleSetting(0, 'oauth');
            $uniacid = $oauth['account'];
        }
        $sign_config = $this->_notice_sign_config;
        if(empty($sign_config[$sign])){
            return false;
        }elseif($sign_config[$sign]['level'] == 'sys'){
            $oauth = m('common')->getModuleSetting(0, 'oauth');
            $uniacid = $oauth['account'];
        }
        $cache_key = 'notice_'.$sign;
        $notice = m('cache')->get($cache_key, $uniacid);
        if(empty($notice)){
            $params = array(':sign' => $sign, ':uniacid' => $uniacid);
            $notice = pdo_fetch("SELECT id,template_id,status FROM " . tablename($this->table_notice) . " WHERE sign=:sign AND uniacid=:uniacid LIMIT 1", $params);
            m('cache')->set($cache_key, $notice, $uniacid);
        }
        return $notice;
    }

    public function getNoticeSets($taskid){
        $taskid = intval($taskid);
        $params = array(':taskid' => $taskid);
        $notice_sets = pdo_fetchall("SELECT * FROM " . tablename($this->table_notice_set) . " WHERE taskid=:taskid ", $params);
        if(!empty($notice_sets)){
            foreach($notice_sets as $k => $v){
                $fans_info = table('fans')->fansInfo($v['openid']);
                if (!empty($fans_info['tag']) && is_string($fans_info['tag'])) {
                    if (is_base64($fans_info['tag'])) {
                        $fans_info['tag'] = base64_decode($fans_info['tag']);
                    }
                    if (is_serialized($fans_info['tag'])) {
                        $fans_info['tag'] = @iunserializer($fans_info['tag']);
                    }
                    if (!empty($fans_info['tag']['headimgurl'])) {
                        $fans_info['tag']['avatar'] = tomedia($fans_info['tag']['headimgurl']);
                    }
                    if (empty($fans_info['nickname']) && !empty($fans_info['tag']['nickname'])) {
                        $fans_info['nickname'] = strip_emoji($fans_info['tag']['nickname']);
                    }
                }
                $notice_sets[$k]['fans_info'] = $fans_info;
            }
        }
        return $notice_sets;
    }
}
