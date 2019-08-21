<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:43:22] -->
 */
defined('IN_IA') or exit('Access Denied');

class Statvisit_Page extends PluginWebPage
{
    public function main()
    {
        global $_W, $_GPC;
        
        if($_W['ispost'] && $_W['isajax']){
            $uid = intval($_GPC['uid']);
            if($uid == 0){
                if($_W['role'] != 'founder'){
                    $this->result(-1, '权限不足', $uid);
                }
                $sql =  "TRUNCATE " . tablename('system_stat_visit');
                $result = pdo_run($sql);
            }
            if(!empty($uid)){
                $sql =  "TRUNCATE " . tablename('system_stat_visit') . "WHERE 'uid' {$uid}";
                $result = pdo_run($sql);
            }
            $this->result(0, '修复成功', $uid);
        }
        
        $_W['page']['title'] = "清空最后访问-工具";
        include $this->mytemplate();
    }
    
}


