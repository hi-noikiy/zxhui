<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/11/10 0:05:30] -->
 */
defined('IN_IA') or exit('Access Denied');

class Common_Model
{
    public $table_setting = 'bowen_setting';
    
    public function getModuleSetting($obj = 0, $setkey = '', $key = '', $module = '')
    {
        if(!empty($obj)){
            $setkey2 = !empty($setkey)?$setkey:'setting';
        }else{
            $setkey2 = !empty($setkey)?$setkey:'core';
        }
        
        $module = !empty($module)?$module:MODULE_NAME;

        $paras = array();
        $paras[':obj'] = $obj;
        $paras[':module'] = $module;
        $commoncondition = '';
        if(!empty($setkey2)){
            $commoncondition .= " AND setkey LIKE :setkey ";
            $paras[':setkey'] = $setkey2;
        }
        
        $ModuleSetting = m('cache')->get('set_'.$setkey2, $obj);
        
        if(empty($ModuleSetting)){
            $ModuleSetting = pdo_fetch("SELECT * FROM ".tablename($this->table_setting)." WHERE obj LIKE :obj AND module LIKE :module ". $commoncondition . "ORDER BY id LIMIT 1", $paras);
            m('cache')->set('set_'.$setkey2, $ModuleSetting, $obj);
        }
        
        if(!empty($ModuleSetting)){
            if($this->is_base64($ModuleSetting['value'])){
                $ModuleSetting['value'] = base64_decode($ModuleSetting['value']);
            }
            $ModuleSetting['value'] = iunserializer($ModuleSetting['value']);
            if(in_array($key, array('id', 'updatetime'))){
                return $ModuleSetting[$key];
            }elseif($key != ''){
                return $ModuleSetting['value'][$key];
            }
            return $ModuleSetting['value'];
        }else{
            return false;
        }
    }
    
    /**
     * $HaveToInsert强制新增，不建议开启。主要用于清除缓存后未立即生效无法插入数据的情况
     */
    public function saveModuleSetting($data, $obj = 0, $setkey = '', $HaveToInsert = false){
        $module = MODULE_NAME;

        $data['value'] = !empty($data['value'])?$data['value']:$data;

        if(!empty($obj)){
            $setkey = !empty($setkey)?$setkey:(!empty($data['setkey'])?$data['setkey']:'setting');
        }else{
            $setkey = !empty($setkey)?$setkey:(!empty($data['setkey'])?$data['setkey']:'core');
        }
        
        if(!$HaveToInsert)$SettingId = m('common')->getModuleSetting($obj, $setkey, 'id');
        
        $change_data = array();
        $change_data['updatetime'] = TIMESTAMP;

        if(empty($SettingId)){
            $change_data['module'] = $module;
            $change_data['obj'] = $obj;
            $change_data['setkey'] = $setkey;
            $change_data['value'] = base64_encode(iserializer($data['value']));
            $savestatus = pdo_insert($this->table_setting,$change_data);
        }else{
            $Settings = m('common')->getModuleSetting($obj, $setkey);
            if(is_array($Settings)){
                $change_data['value'] = base64_encode(iserializer(array_merge($Settings, $data['value'])));
            }else{
                $change_data['value'] = base64_encode(iserializer($data['value']));
            }
            $savestatus = pdo_update($this->table_setting, $change_data, array('id' => $SettingId));
        }
        m('cache')->del('set_'.$setkey, $obj);
        return $savestatus;
    }
    
    public function delModuleSetting($obj = 0, $setkey = ''){
       global $_W;
        $SettingId = m('common')->getModuleSetting($obj, $setkey, 'id');
        /** 禁止非站长删除非当前公众号的设置 */
        if($_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER && $obj != $_W['uniacid']){
            return false;
        }
        if(!empty($SettingId)){
            $result = pdo_delete($this->table_setting, array('obj' => $obj));
        }
        m('cache')->del('set_'.$setkey, $obj);
        return true;
    }

    public function getAccount($uniacid = NULL)
    {
        global $_W;
        load()->model('account');

        if (!empty($_W['acid']) && $uniacid == NULL) {
            return WeAccount::create($_W['acid']);
        }
        $uniacid = !empty($uniacid)?$uniacid:$_W['uniacid'];
        $account_wechat = pdo_fetch('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $uniacid));
        return WeAccount::create($account_wechat['acid']);
    }

    /** web借权信息 */
    public function getOauth($uniacid = NULL)
    {
        $oauthInfo = $this->getOauthInfo($uniacid);
        $oauth = iunserializer($oauthInfo['oauth']) ? iunserializer($oauthInfo['oauth']) : array();
        return $oauth;
    }

    public function getOauthInfo($uniacid = NULL)
    {
        global $_W;
        $uniacid = !empty($uniacid)?intval($uniacid):$_W['uniacid'];
        $oauthInfo = table('unisetting')->getOauthByUniacid($uniacid);
        return $oauthInfo;
    }

    public function getAcidByUniacid($uniacid){
        $uniacid = intval($uniacid);
        $account_wechat = pdo_fetch('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $uniacid));
        return $account_wechat['acid'];
    }

    public function getUniacidByAcid($acid){
        $acid = intval($acid);
        $account_wechat = pdo_fetch('SELECT uniacid FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid LIMIT 1', array(':acid' => $acid));
        return $account_wechat['uniacid'];
    }

    /**
     * 搜索已经存在系统设置的平台应用
     * 暂时只输出公众号和PC
     */
    public function getAccounts()
    {
        $accounts = pdo_fetchall('SELECT acc.type,acc.uniacid, wechat.name AS wechat_name, webapp.name AS webapp_name FROM ' . tablename($this->table_setting) . ' s  ' . ' left join ' . tablename('account_wechats') . ' wechat on wechat.uniacid = s.obj' . ' left join ' . tablename('account_webapp') . ' webapp on webapp.uniacid = s.obj' . ' left join ' . tablename('account') . ' acc on acc.uniacid = s.obj where s.setkey="setting" AND obj != "0" AND acc.isdeleted=0 GROUP BY uniacid');
        if(!empty($accounts)){
            for($i = 0; $i < count($accounts); $i++){
                if($accounts[$i]['type'] == 1 || $accounts[$i]['type'] == 3){
                    $accounts[$i]['name'] = $accounts[$i]['wechat_name'];
                }elseif ($accounts[$i]['type'] == 5){
                    $accounts[$i]['name'] = $accounts[$i]['webapp_name'];
                }
            }
        }
        return $accounts;
    }

    public function qr($url) 
	{
		global $_W;
		$url = empty($url)?trim($_W['siteurl']):$url;
        load()->library('qrcode');
		QRcode::png($url, false, QR_ECLEVEL_L, 16, 1);
	}
    
	/**
     * 格式化参数格式化成url参数
     */
	public function ToUrlParams($arr, $unBuff = false, $prefix = '')
	{
		if(empty($arr)){return false;}
        
        $buff = '';
		foreach ($arr as $k => $v){
            if(!empty($unBuff) && is_array($unBuff)){
                if(in_array($k, $unBuff)){
                    continue;
                }
            }
			if (($v != '') && !(is_array($v))) {
				$buff .= $k . '=' . $v . '&';
			}

		}
		$buff = trim($buff, '&');
        $buff = !empty($buff)?trim($prefix.$buff):'';
		return $buff;
	}
    
    /** 获取链接中的ID */
    public function getId($content)
    {
        global $_W,$_B;
        if(empty($_B['setting'])){
            $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        }
        if(!is_array($content)){
            $url = $content;
            parse_str($url);
            if(!$id){
                if(!empty($_B['setting']['global']['isrewrite'])){
                    $rew_url = explode('/', $content);
                    foreach($rew_url as $rew_i){
                        if(stripos($rew_i, 'class_') !== false || stripos($rew_i, 'article_') !== false ){
                            $rew_i = str_replace('class_', '', $rew_i);
                            $rew_i = str_replace('article_', '', $rew_i);
                            $rew_i = str_replace('form-', '', $rew_i);
                            $rew_i = str_replace('.html', '', $rew_i);
                            $result_rew = intval($rew_i);
                            break;
                        }
                    }
                }
                $id = $content;
            }
            $result = intval($id);
        }else{
            $result = array();
            for($i=0; $i<count($content); $i++){
                parse_str($content[$i]);
                if(!$id){
                    if(!empty($_B['setting']['global']['isrewrite'])){
                        $result_rew = array();
                        $rew_url = explode('/', $content[$i]);
                        foreach($rew_url as $rew_i){
                            if(stripos($rew_i, 'class_') !== false || stripos($rew_i, 'article_') !== false ){
                                $rew_i = str_replace('class_', '', $rew_i);
                                $rew_i = str_replace('article_', '', $rew_i);
                                $rew_i = str_replace('form-', '', $rew_i);
                                $rew_i = str_replace('.html', '', $rew_i);
                                $result_rew[$i] = intval($rew_i);
                                break;
                            }
                        }
                    }
                    $id = $content[$i];
                }
                $result[$i] = intval($id);
            }
        }
        if(!empty($result_rew)){/** 如果伪静态数据有，就输出伪静态的 */
            return $result_rew;
        }
        return $result;
    }
    
	public function changeTitle($title)
	{
		$title = preg_replace('/[^\\x{4e00}-\\x{9fa5}A-Za-z0-9_]/u', '', $title);
		return $title;
	}

	public function createNO($table, $field, $prefix)
	{
		$billno = date('YmdHis') . random(6, true);

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('bowen_site_' . $table) . ' where ' . $field . '=:billno limit 1', array(':billno' => $billno));
			if ($count <= 0) {
				break;
			}
			$billno = date('YmdHis') . random(6, true);
		}

		return $prefix . $billno;
	}
    
    /** 判断是否base64加密 */
    public function is_base64($str){
        /** 这里多了个纯字母和纯数字的正则判断 */
        if(@preg_match('/^[0-9]*$/',$str) || @preg_match('/^[a-zA-Z]*$/',$str)){
            return false;
        }elseif($this->is_utf8(base64_decode($str)) && base64_decode($str) != ''){
            return true;
        }
        return false;
    }

    /** 判断否为UTF-8编码 */
    public function is_utf8($str){
        $len = strlen($str);
        for($i = 0; $i < $len; $i++){
            $c = ord($str[$i]);
            if($c > 128){
                if(($c > 247)){
                    return false;
                }elseif($c > 239){
                    $bytes = 4;
                }elseif($c > 223){
                    $bytes = 3;
                }elseif ($c > 191){
                    $bytes = 2;
                }else{
                    return false;
                }
                if(($i + $bytes) > $len){
                    return false;
                }
                while($bytes > 1){
                    $i++;
                    $b = ord($str[$i]);
                    if($b < 128 || $b > 191){
                        return false;
                    }
                    $bytes--;
                }
            }
        }
        return true;
    }

    /**
     * 字符串截取，支持中文和其他编码
     * @access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * @return string
     */
    public function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
        if(function_exists("cutstr")) {
            /** 首先通过微擎的封装的进行截取 */
            $slice = cutstr($str, $length, false, $charset);
        }elseif(function_exists("mb_substr")){
            $slice = mb_substr($str, $start, $length, $charset);
        }elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
        }else{
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }

        return ($suffix && (mb_strlen($str,$charset) > $length)) ? $slice.'...' : $slice;
    }
}

