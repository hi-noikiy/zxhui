<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/27 15:21:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class MobilePage extends Page 
{
    public function __construct()
	{
        global $_W,$_B;
        $_B['sys_copyright'] = $this->getCopyright();

        $need_go = 0;
        $cache_key = "webpage_domains";
        $domains = m('cache')->get($cache_key, $_W['uniacid']);
        if(empty($domains)){
            $alldomain = pdo_fetchall("SELECT * FROM ".tablename($this->table_domain)." WHERE uniacid = :uniacid ORDER BY displayorder DESC,createtime DESC", array(':uniacid' => $_W['uniacid']));
            $domains = array();
            foreach($alldomain as $value){
                $domains[$value['domain']] = $value;
            }
            m('cache')->set($cache_key, $domains, $_W['uniacid']);
        }
        unset($cache_key);

        if(!empty($domains)){
            $domain = $domains[$_SERVER["HTTP_HOST"]];
            if(empty($domain)){
                $need_go = 1;
                $domain = current($domains);
            }
            if($domain['domain'] != 'others' && $need_go == 1){
                header('location: ' . (!empty($domain['ishttps'])?"https://":"http://") . $domain['domain'] . $_W['script_name'] . '?' . $_SERVER['QUERY_STRING']);
            }
        }
	}

    public function getCopyright(){
        global $_W;
        $uniacid = $_W["uniacid"];
        $cache_key = 'sys_copyright_f' . $uniacid;
        $copyright = m('cache')->get($cache_key);
        if(empty($copyright) || $copyright['endtime'] < TIMESTAMP){
            $copyright = pdo_fetch('SELECT content,param FROM ' . tablename($this->table_sys_copyright) . ' WHERE value = ' . $uniacid . ' AND type = 1 LIMIT 1');

            if (empty($copyright)) {
                $copyright = pdo_fetch('SELECT content,param FROM ' . tablename($this->table_sys_copyright) . ' WHERE value = 0 AND type = 1 LIMIT 1');
            }

            if (!empty($copyright)) {
                $copyright['content'] = html_entity_decode($copyright['content'], ENT_QUOTES);
                $copyright['param'] = iunserializer($copyright['param']);
                $copyright['endtime'] = time()+(60*30);
            }

            m('cache')->set($cache_key, $copyright);
        }
        return $copyright;
    }
}