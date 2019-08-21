<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/05 10:43:16] -->
 */
defined('IN_IA') or exit('Access Denied');

class Page extends WeModuleSite {
	public $modulename = 'bowen_site';
    public $table_setting = 'bowen_setting';
    
    public $table_navs = 'bowen_site_navs';
    public $table_classes = 'bowen_site_classes';
    public $table_articles = 'bowen_site_articles';
    public $table_domain = 'bowen_site_domain';
    public $table_plugin = 'bowen_site_plugin';
    public $table_sys_copyright = 'bowen_site_sys_copyright';
    public $table_notice = 'bowen_site_notice';
    public $table_notice_set = 'bowen_site_notice_set';
    public $table_msg_sign = 'bowen_site_msg_sign';
    
    /** 获取文章数据
     * $articleid 文章ID
     * $params 参数指定查询的条件，以是 AND 连接，支持大于，小于等范围查询
     * $is_decode 是否对数据结构进行转换
     */
    public function getArticleInfo($articleid, $params = array(), $is_decode = true)
    {
       global $_W,$_GPC;
        $articleid = trim($articleid);
        if(empty($articleid)){return false;}
        
        if(empty($params)){
            $params = array('uniacid' => $_W['uniacid']);
        }else{
            if(is_array($params)){
                $params = array_merge(array('uniacid' => $_W['uniacid']), $params);
            }else{
                $params .= ' AND uniacid =' . $_W['uniacid'];
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        $params2 = array_merge($params, array('id' => $articleid));
        $condition = SqlPaser::parseParameter($params2, 'AND');
        $sql = "SELECT * FROM ".tablename($this->table_articles) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . " LIMIT 1";
        $article = pdo_fetch($sql, $condition['params']);
        if($article && $is_decode){
            if($_GPC['do'] != 'web'){
                $article['description'] = replaceRN($article['description']);
            }
            $article['value'] = iunserializer($article['value']);
            $article['tag'] = iunserializer($article['tag']);
        }
        return $article;
    }
    
    /** 获取分类文章列表
     * $classid     int           分类id
     * $params      array/string  参数指定查询的条件，以是 AND 连接，支持大于，小于等范围查询
     * $orderby     array/string  排序，可传入数组array('displayorder','id asc'),也可以直接sql语句
     * $limit       array         参数指定查询语句的LIMIT值，array(start, end) 或是直接传入范围 2,3
     * $lower_leve  boolean       是否显示下级分类的文章数据，默认为显示
     */
    public function getClasseArticles($classid, $params = array(), $orderby =  array(), $limit = array(), $lower_leve = true)
    {
       global $_W;
        $classid = trim($classid);
        if(empty($classid)){return false;}
        
        //$orderbysql = SqlPaser::parseOrderby($orderby);
        $orderbysql = $this->parseOrderby($orderby);//修复底层坏掉的问题
        $limitsql = SqlPaser::parseLimit($limit);
        
        $class = $this->getClassInfo($classid);
        if($class['level'] == '3'){
            $class_level = 'thirdclass';
        }elseif($class['level'] == '2'){
            $class_level = 'secondclass';
        }else{
            $class_level = 'firstclass';
        }
        
        if(empty($params)){
            $params = array('uniacid' => $_W['uniacid']);
            $params = array_merge($params, array($class_level => $classid));
        }else{
            if(is_array($params)){
                $params = array_merge(array('uniacid' => $_W['uniacid']), $params);
                $params = array_merge($params, array($class_level => $classid));
            }else{
                $params .= ' AND uniacid =' . $_W['uniacid'];
                $params .= ' AND ' . $class_level . ' = ' . $classid;
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        
        if(!$lower_leve){
            if($class['level'] == '2'){
                if(is_array($params)){
                    $params = array_merge($params, array('thirdclass' => 0));
                }else{
                    $params .= " AND thirdclass = 0 ";
                }
            }
            elseif($class['level'] == '1'){
                if(is_array($params)){
                    $params = array_merge($params, array('secondclass' => 0));
                    $params = array_merge($params, array('thirdclass' => 0));
                }else{
                    $params .= " AND secondclass = 0 ";
                    $params .= " AND thirdclass = 0 ";
                }
            }
        }
        
        $condition = SqlPaser::parseParameter($params, 'AND');
        $sql = "SELECT * FROM ".tablename($this->table_articles) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . $orderbysql . $limitsql;
        $articles = pdo_fetchall($sql, $condition['params']);
        
        return $articles;
    }
    
    /** 获取分类文章总数，输出为数字
     * $classid     int           分类id
     * $params      array/string  参数指定查询的条件，以是 AND 连接，支持大于，小于等范围查询
     * $lower_leve  boolean       是否包含下级分类的文章，默认为包含
     */
    public function getClasseArticlesColumn($classid, $params = array(), $lower_leve = true)
    {
       global $_W;
        $classid = trim($classid);
        if(empty($classid)){return false;}
        
        $class = $this->getClassInfo($classid);
        if($class['level'] == '3'){
            $class_level = 'thirdclass';
        }elseif($class['level'] == '2'){
            $class_level = 'secondclass';
        }else{
            $class_level = 'firstclass';
        }
        
        if(empty($params)){
            $params = array('uniacid' => $_W['uniacid']);
            $params = array_merge($params, array($class_level => $classid));
        }else{
            if(is_array($params)){
                $params = array_merge(array('uniacid' => $_W['uniacid']), $params);
                $params = array_merge($params, array($class_level => $classid));
            }else{
                $params .= ' AND uniacid = ' . $_W['uniacid'];
                $params .= ' AND ' . $class_level . ' =' . $classid;
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        
        if(!$lower_leve){
            if($class['level'] == '2'){
                if(is_array($params)){
                    $params = array_merge($params, array('thirdclass' => 0));
                }else{
                    $params .= " AND thirdclass = 0 ";
                }
            }
            elseif($class['level'] == '1'){
                if(is_array($params)){
                    $params = array_merge($params, array('secondclass' => 0));
                    $params = array_merge($params, array('thirdclass' => 0));
                }else{
                    $params .= " AND secondclass = 0 ";
                    $params .= " AND thirdclass = 0 ";
                }
            }
        }
        
        $condition = SqlPaser::parseParameter($params, 'AND');
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table_articles) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '');
        $articles_count = pdo_fetchcolumn($sql, $condition['params']);
        
        return $articles_count;
    }
    
    /** 获取文章列表
     * $params   array/string  参数指定查询的条件，以是 AND 连接，支持大于，小于等范围查询
     * $orderby  array/string  排序，可传入数组array('displayorder','id asc'),也可以直接sql语句
     * $limit    array/string  参数指定查询语句的LIMIT值，array(start, end) 或是直接传入范围 2,3
     */
    public function getArticles($params = array(), $orderby =  array(), $limit = array())
    {
        global $_W;
        if(empty($params)){
            $params = array('uniacid' => $_W['uniacid']);
        }else{
            if(is_array($params)){
                $params = array_merge(array('uniacid' => $_W['uniacid']), $params);
            }else{
                $params .= ' AND uniacid =' . $_W['uniacid'];
            }
        }
        $articles = $this->getAll($this->table_articles, $params, $orderby, $limit);
        return $articles;
    }
    
    /** 获取文章总数，输出为数字
     * $params  array/string  参数指定查询的条件，以是 AND 连接，支持大于，小于等范围查询
     */
    public function getArticlesColumn($params = array())
    {
        global $_W;
        if(empty($params)){
            $params = array('uniacid' => $_W['uniacid']);
        }else{
            if(is_array($params)){
                $params = array_merge(array('uniacid' => $_W['uniacid']), $params);
            }else{
                $params .= ' AND uniacid =' . $_W['uniacid'];
            }
        }
        $articles_count = $this->countAll($this->table_articles, $params);
        return $articles_count;
    }
    
    /**
     * 通用数据批量获取
     * $table 表名
     * $params 参数指定查询的条件。以 AND 连接，支持大于，小于等范围查询
     * $orderby 排序，可传入数组array('displayorder','id asc'),也可以直接以,分隔
     * $limit 参数指定查询语句的LIMIT值，array(start, end) 或是直接传入范围 2,3
     */
    public function getAll($table, $params = array(), $orderby =  array(), $limit = array())
    {
        $orderbysql = $this->parseOrderby($orderby);//修复底层坏掉的问题
        $limitsql = SqlPaser::parseLimit($limit);
        
        if(!empty($params)){
            if(!is_array($params)){
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        $condition = SqlPaser::parseParameter($params, 'AND');
        $sql = "SELECT * FROM ".tablename($table) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . $orderbysql . $limitsql;
        $result = pdo_fetchall($sql, $condition['params']);
        return $result;
    }
    
    /**
     * 通用数据总数获取，返回数字
     * $table 表名
     * $params 参数指定查询的条件。以 AND 连接，支持大于，小于等范围查询
     */
    public function countAll($table, $params = array())
    {
        if(!empty($params)){
            if(!is_array($params)){
                $params = ltrim($params," AND");
                $params = ltrim($params,"AND");
            }
        }
        $condition = SqlPaser::parseParameter($params, 'AND');
        
        $sql = "SELECT COUNT(*) FROM ".tablename($table) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '');
        $result = pdo_fetchcolumn($sql, $condition['params']);
        
        return $result;
    }
    
    /** 获取分类信息 */
    public function getClassInfo($classid)
    {
       global $_W;
        $class = pdo_fetch("SELECT * FROM ".tablename($this->table_classes) . " WHERE uniacid LIKE :uniacid AND id LIKE :id ", array(':uniacid' => $_W['uniacid'], ':id'=> $classid));
        return $class;
    }
    
    /** 获取前端导航信息 */
    public function getForegNavInfo($navid)
    {
       global $_W;
        $nav = pdo_fetch("SELECT * FROM ".tablename($this->table_navs) . " WHERE uniacid LIKE :uniacid AND id LIKE :id ", array(':uniacid' => $_W['uniacid'], ':id'=> $navid));
        return $nav;
    }
    
    /** 获取前端导航 **/
    public function getForegTopNav($is_old = true)
    {
        global $_W;
        if($is_old){
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':topid'=> '0',
                ':type'=>'topnav',
            );
            $commoncondition = " WHERE uniacid LIKE :uniacid AND topid LIKE :topid AND type LIKE :type ";
            $topnavs_f = pdo_fetchall("SELECT * FROM ".tablename($this->table_navs) . $commoncondition . " ORDER BY displayorder DESC", $params);
            $topnavs = array();
            for($i = 0; $i < count($topnavs_f); $i++){
                $params_s = array(
                    ':uniacid' => $_W['uniacid'],
                    ':topid'=> $topnavs_f[$i]['id'],
                    ':type'=>'topnav',
                );
                $commoncondition_s = " WHERE uniacid LIKE :uniacid AND topid LIKE :topid AND type LIKE :type ";
                $topnavs[$i] = $topnavs_f[$i];
                $topnavs[$i]['s'] = pdo_fetchall("SELECT * FROM ".tablename($this->table_navs) . $commoncondition_s . " ORDER BY displayorder DESC", $params_s);
            }
            return $topnavs;
        }else{
            $children = array();
    		$topnavs = pdo_fetchall('SELECT * FROM ' . tablename($this->table_navs) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
    		foreach ($topnavs as $index => $row) {
    			if (!empty($row['parid'])) {
    				$children[$row['parid']][] = $row;
    				unset($topnavs[$index]);
    			}
    		}
            $navs = array();
            $navs['top'] = $topnavs;
            $navs['children'] = $children;
            return $navs;
        }
        
    }

    public function getClasses($level = 'true', $info = array())
    {
        global $_W;
        $classes = array();
        if($level == 'true')
        {/** 全部分类(分等级) */
            $params = array(':uniacid' => $_W['uniacid'],':topid'=> '0');
            $commoncondition = " uniacid LIKE :uniacid AND topid LIKE :topid ";
            $classes_l = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE " . $commoncondition . " ORDER BY displayorder DESC,id ", $params);

            if($classes_l){
                for($i = 0; $i < count($classes_l); $i++){
                    $params_s = array(':uniacid' => $_W['uniacid'],':topid'=> $classes_l[$i]['id']);
                    $commoncondition_s = '';
                    $commoncondition_s .= " uniacid LIKE :uniacid AND topid LIKE :topid AND topid = parid ";
                    $classes[$i] = $classes_l[$i];
                    $classes[$i]['s'] = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE " . $commoncondition_s . " ORDER BY displayorder DESC,id ", $params_s);

                    if($classes[$i]['s']){
                        for($i2 = 0; $i2 < count($classes[$i]['s']); $i2++){
                            $params_s2 = array(':uniacid' => $_W['uniacid'],':parid'=> $classes[$i]['s'][$i2]['id']);
                            $commoncondition_s2 = '';
                            $commoncondition_s2 .= " uniacid LIKE :uniacid AND parid LIKE :parid ";
                            $classes[$i]['s'][$i2]['t'] = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE " . $commoncondition_s2 . " ORDER BY displayorder DESC,id ", $params_s2);
                        }
                    }

                }
            }
        }else if($level == 'same')
        {/** 获取同级分类 */
            $parid = intval($info['parid']);

            $class = $this->getClassInfo($parid);
            if($class['level'] == '3'){
                $class_level = 'parid';
            }else{
                $class_level = 'topid';
            }

            $classes_s = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE  uniacid LIKE :uniacid AND ".$class_level." LIKE :".$class_level." ORDER BY displayorder DESC,id ", array(':uniacid' => $_W['uniacid'], ':'.$class_level => $parid));
            if($classes_s){
                for($i = 0; $i < count($classes_s); $i++){
                    $classes[$classes_s[$i]['id']] = $classes_s[$i];
                    if($classes_s[$i]['parid'] != $classes_s[$i]['topid']){
                        $classes[$classes_s[$i]['parid']]['t'][] = $classes_s[$i];
                        unset($classes[$classes_s[$i]['id']]);
                    }
                }
            }
        }elseif($level == 'lower')
        {/** 获取下级分类 */
            $cid = intval($info['cid']);

            $children = array();
            $category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
            foreach ($category as $index => $row) {
                if (!empty($row['parid'])) {
                    $children[$row['parid']][] = $row;
                    unset($category[$index]);
                }
            }
            /** 如果没有下级分类 */
            if(count($children[$cid]) == 0){
                return false;
            }
            if(!empty($children[$cid])){
                for($i = 0; $i < count($children[$cid]); $i++){
                    $id = $children[$cid][$i]['id'];
                    $classes[$id] = $children[$cid][$i];
                    if(!empty($children[$id])){
                        $classes[$id]['t'] = $children[$id];
                    }
                }
            }
        }else
        {/** 全部分类(直接) $level = 'false';*/
            $classes_a = pdo_fetchall("SELECT * FROM ".tablename($this->table_classes) . " WHERE uniacid LIKE :uniacid ORDER BY displayorder DESC,id ", array(':uniacid' => $_W['uniacid']));
            if($classes_a){
                for($i = 0; $i < count($classes_a); $i++){
                    $classes[$classes_a[$i]['id']] = $classes_a[$i];
                }
            }
        }
        return $classes;
    }
    
    public function qr($url) 
	{
		return m('common')->qr($url);
	}
    
    public function mytemplate($filename = '', $tthemes = '') {
		return mytemplate($filename, $tthemes);
	}

    public function getModuleSetting($obj = '', $key = '', $module = '', $setkey = '')
    {
        return m('common')->getModuleSetting($obj, $key, $module, $setkey);
    }

    public function saveModuleSetting($data, $obj = 0, $setkey = '', $HaveToInsert = false){
        return m('common')->saveModuleSetting($data, $obj, $setkey, $HaveToInsert);
    }

    public function result($errno = '0', $message = '', $data = array(), $params = array(), $type = 'exit')
    {
        return result($errno, $message, $data, $params, $type);
    }
    
    public function result_r($errno = '0', $message = '', $data = array(), $params = array()){
        return result_r($errno, $message, $data, $params);
    }
    
    public function parseOrderby($orderby = array())
    {//修补系统底层函数parseOrderby
		$orderbysql = '';
		if (empty($orderby)) {
			return $orderbysql;
		}
	
		if (!is_array($orderby)) {
			$orderby = explode(',', $orderby);
		}
		foreach ($orderby as $i => &$row) {
			$row = strtolower($row);
			list($field, $orderbyrule) = explode(' ', $row);
			if ($orderbyrule != 'asc' && $orderbyrule != 'desc' && $orderbyrule) {
				unset($orderby[$i]);
			}
            if($orderbyrule){
                $orderbyrule = " {$orderbyrule}";
            }
			$row = "{$field}{$orderbyrule}";
		}
		$orderbysql = implode(',', $orderby);
		return !empty($orderbysql) ? " ORDER BY $orderbysql " : '';
	}
}
