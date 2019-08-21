<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/16 22:09:22] -->
 */
defined('IN_IA') or exit('Access Denied');

class Foreg_Page extends ComWebPage
{
    public function main()
    {
        global $_GPC;
        $uniacid = intval($_GPC['uniacid']);
        if (!empty($uniacid)) {
            $copyrights = pdo_fetch('SELECT * FROM ' . tablename($this->table_sys_copyright) . ' WHERE value=' . $uniacid . ' AND type = 1 LIMIT 1');
        }

        if (empty($copyrights)) {
            $copyrights = pdo_fetch('SELECT * FROM ' . tablename($this->table_sys_copyright) . ' WHERE value = 0 AND type = 1 LIMIT 1');
        }

        if (!empty($copyrights)) {
            $copyrights['content'] = html_entity_decode($copyrights['content'], ENT_QUOTES);
        }

        $accounts = m('common')->getAccounts();
        $accounts = array_filter($accounts);

        $data = array(
            'accounts'=>$accounts
            ,'copyright' => $copyrights
        );

        $this->result(0, 'success', $data);
    }

    public function post()
    {
        global $_GPC;
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $uniacid = intval($_GPC['uniacid']);

        $check = pdo_fetch('SELECT id FROM ' . tablename($this->table_sys_copyright) . (' WHERE value='.$uniacid.' AND type = 1 LIMIT 1'));

        /** 缓存处理 */
        if($uniacid != 0){
            $cache_key = 'sys_copyright_f' . $uniacid;
            m('cache')->del($cache_key);
        }else{
            cache_clean();
        }


        $data = array(
            'content' => $_GPC['copyright']
            ,'updatetime' => TIMESTAMP
        );

        if(empty($check)){
            $data['type'] = 1;
            $data['value'] = $uniacid;
            $result = pdo_insert($this->table_sys_copyright, $data);
        }else{
            $result = pdo_update($this->table_sys_copyright, $data, array('id' => $check['id']));
        }
        if(!empty($result)){
            $this->result(0, '操作成功');
        }
        $this->result(2, '未知错误！');
    }
}
