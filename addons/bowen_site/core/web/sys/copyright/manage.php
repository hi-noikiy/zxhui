<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/17 15:25:22] -->
 */
defined('IN_IA') or exit('Access Denied');

class Manage_Page extends ComWebPage
{
    public function main()
    {
        global $_GPC;
        $id = intval($_GPC['id']);
        if (!empty($id)) {
            $copyrights = pdo_fetch('SELECT * FROM ' . tablename($this->table_sys_copyright) . (' WHERE value=' . $id . ' AND type = 2 LIMIT 1'));
        }

        if (empty($copyrights)) {
            $copyrights = pdo_fetch('SELECT * FROM ' . tablename($this->table_sys_copyright) . (' WHERE value = 0 AND type = 2 LIMIT 1'));
        }

        if (!empty($copyrights)) {
            $copyrights['content'] = html_entity_decode($copyrights['content'], ENT_QUOTES);
            $copyrights['param'] = iunserializer($copyrights['param']);
        }

        $domains = pdo_fetchall('SELECT  id,domain FROM ' . tablename($this->table_domain) . ' WHERE status=1 AND domain != "others"');
        $domains = array_filter($domains);

        $data = array(
            'domains'=>$domains
            ,'copyright' => $copyrights
        );

        $this->result(0, 'success', $data);
    }

    public function post()
    {
        global $_GPC;
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $id = intval($_GPC['domain']);

        $check = pdo_fetch('SELECT id FROM ' . tablename($this->table_sys_copyright) . ' WHERE value='.$id.' AND type = 2 LIMIT 1');

        /** 缓存处理 */
        if($id != 0){
            $check2 = pdo_fetch('SELECT id,domain FROM ' . tablename($this->table_domain) . ' WHERE id='.$id.' AND status = 1 ');
            if(empty($check2)){
                $this->result(-1, '域名待审核或已被删除！');
            }else{
                $cache_key = 'sys_copyright_m' . str_replace('.', '_', $check2['domain']);
                m('cache')->del($cache_key);
            }
        }else{
            cache_clean();
        }

        $param = array(
            'title' => safe_gpc_string(trim($_GPC['title']))
            ,'keywords' => safe_gpc_string(trim($_GPC['keywords']))
            ,'description' => safe_gpc_string(trim($_GPC['description']))
        );

        $data = array(
            'content' => $_GPC['copyright']
            ,'param' => iserializer($param)
            ,'updatetime' => TIMESTAMP
        );

        if(empty($check)){
            $data['type'] = 2;
            $data['value'] = $id;
            $result = pdo_insert($this->table_sys_copyright, $data);
        }else{
            $result = pdo_update($this->table_sys_copyright, $data, array('id' => $check['id']));
        }
        if(!empty($result)){
            cache_clean();
            $this->result(0, '操作成功');
        }
        $this->result(2, '未知错误！');
    }
}
