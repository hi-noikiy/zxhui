<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/20 22:13:28] -->
 */
defined('IN_IA') or exit('Access Denied');

class Perm_Page extends SystemPage
{
    public function __construct()
    {
        global $_W,$_B;
        parent::__construct();
        if(!$_W['isajax'] || !$_W['ispost'])$this->result(2, '参数错误，非法访问');
        if(!$_B['core_settings'])$_B['core_settings'] = m('common')->getModuleSetting(0, 'core', 'core_settings');
    }

    public function main()
    {
        global $_GPC;

        /** 获取模板列表 */
        $mobilethemes = $this->getThemes_mobile();
        $themes_list = array();
        if(!empty($mobilethemes)){
            for($i = 0;$i < count($mobilethemes); $i++){
                $themes_list[$i] = $this->getThemes_mobile_config(array('name', 'title', 'tag'), $mobilethemes[$i]);
                $themes_list[$themes_list[$i]['name']] = $themes_list[$i];
                unset($themes_list[$i]);
                if(empty($themes_list[$themes_list[$i]['name']])){
                    unset($themes_list[$themes_list[$i]['name']]);
                }
            }
        }
        $themes_list = sortArrByManyField($themes_list);

        /** 获取应用插件列表 */
        $plugin_list = m('plugin')->getAll(1);

        $data = array(
            'themes' => $themes_list,
            'plugins' => $plugin_list
        );

        $uniacid = intval($_GPC['uniacid']);
        if(!empty($uniacid)){
            $uni_perm = m('common')->getModuleSetting($uniacid, 'uni_perm');
            $uni_account = uni_account_default($uniacid);

            $themes = array();
            if(!empty($uni_perm['themes'])){
                foreach($uni_perm['themes'] as $t){
                    $themes['themes['.$t.']'] = true;
                }
            }

            $plugins = array();
            if(!empty($uni_perm['plugins'])){
                foreach($uni_perm['plugins'] as $t){
                    $plugins['plugins['.$t.']'] = true;
                }
            }

            $data['content'] = array(
                'uniacid' => $uniacid,
                'account_name' => $uni_account['name'],
            );
            if(!empty($themes))$data['content'] = array_merge($data['content'], $themes);
            if(!empty($plugins))$data['content'] = array_merge($data['content'], $plugins);
        }

        $this->result(0, 'success', $data);
    }

    public function showList(){
        global $_GPC,$_B;
        $commoncondition = " setkey LIKE 'uni_perm' AND module LIKE '".MODULE_NAME."' ";

        if (!empty($_GPC['account_name'])) {
            $uniacid = 0;
            if(!empty($uniacid)){
                $commoncondition .= " AND uniacid = ". $uniacid ." ";
            }
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
        $count = $this->countAll($this->table_setting, $commoncondition);
        $list = $this->getAll($this->table_setting, $commoncondition, array('id DESC'), array($pindex, $psize));

        if(!empty($list)){
            foreach($list as $k => $v){
                $list[$k]['account'] = uni_account_default($list[$k]['obj']);
                $list[$k]['account_name'] = $list[$k]['account']['name'];
                $list[$k]['value'] = iunserializer(base64_decode($list[$k]['value']));
                $list[$k]['themes'] = implode('，', $list[$k]['value']['themes']);
                $list[$k]['plugins'] = implode('，', $list[$k]['value']['plugins']);
                unset($list[$k]['account'],$list[$k]['value']);
            }
        }

        $odata = array(
            'is_open_perm' => $_B['core_settings']['is_open_perm']
        );

        $this->result(0, 'success', $list, array('count' => $count, 'odata' => $odata));
    }

    public function delPerm(){
        global $_GPC;

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

        $perms = pdo_fetchall('SELECT id FROM ' . tablename($this->table_setting) . ' WHERE id in( ' . $id . ' )');

        if(TEST_SITE)$this->result(1, '测试站禁止操作数据');

        foreach ($perms as $p) {
            pdo_delete($this->table_setting, array('id' => $p['id']));
        }

        $this->result(0, "操作成功", $perms);
    }

    public function post(){
        global $_GPC;
        $uniacid = intval($_GPC['uniacid']);

        $themes = array();
        if(!empty($_GPC['themes'])){
            foreach($_GPC['themes'] as $k => $v){
                if($v !== 'on')continue;
                $themes[] = $k;
            }
        }

        $plugins = array();
        if(!empty($_GPC['plugins'])){
            foreach($_GPC['plugins'] as $k => $v){
                if($v !== 'on')continue;
                $plugins[] = $k;
            }
        }

        $data = array(
            'themes' => $themes,
            'plugins' => $plugins
        );
        if(TEST_SITE)$this->result(1, '测试站禁止操作数据');
        $result = m('common')->saveModuleSetting($data, $uniacid, 'uni_perm');
        if(!empty($result)){
            $this->result(0, '操作成功');
        }
        $this->result(2,'操作失败，未知错误');
    }

    public function switch_perm(){
        global $_GPC,$_B;
        $status = intval($_GPC['status']);

        $core_site_data['core_settings'] = array(
            'is_open_perm' => $status
        );
        $core_site_data['core_settings'] = array_merge($_B['core_settings'], $core_site_data['core_settings']);
        if(TEST_SITE)$this->result(1, '测试站禁止操作数据');
        $result = m('common')->saveModuleSetting($core_site_data, 0, 'core');
        if(!empty($result)){
            $this->result(0,'操作成功');
        }
        $this->result(2,'操作失败，未知错误');
    }

}
