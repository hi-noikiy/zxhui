<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:39:11] -->
 */
defined('IN_IA') or exit('Access Denied');

class DatabaseModel extends PluginModel
{
    public $modulename = 'bowen_site';
    public $table_setting = 'bowen_setting';
    
    public $table_navs = 'bowen_site_navs';
    public $table_classes = 'bowen_site_classes';
    public $table_articles = 'bowen_site_articles';
    public $table_domain = 'bowen_site_domain';
    
    public function insertCategory($data, $uniacid){
        $data = json_decode(base64_decode($data), true);
        $category = $data['category'];
  		$children = $data['children'];
        $ccid = array();
        foreach($category as $c){
            /** 一级 */
            $c_data = array(
                'uniacid' => $uniacid,
                'topid' => 0,
                'parid' => 0,
                'level' => 1,
                'title' => $c['title'],
                'subtitle' => $c['subtitle'],
                'icon' => $c['icon'],
                'images' => $c['images'],
                'description' => $c['description'],
                'sign' => $c['sign'],
                'thumb' => $c['thumb'],
                'themes' => $c['themes'],
                'tourl' => $c['tourl'],
                'value' => $c['value'],
                'status' => $c['status'],
                'displayorder' => $c['displayorder'],
                'createtime' => $c['createtime']
            );
            pdo_insert($this->table_classes, $c_data);
            $ccid[$c['id']] = pdo_insertid();
            if(count($children[$c['id']]) > 0){
                foreach($children[$c['id']] as $c_s){
                    /** 二级 */
                    $cs_data = array(
                        'uniacid' => $uniacid,
                        'topid' => $ccid[$c['id']],
                        'parid' => $ccid[$c['id']],
                        'level' => 2,
                        'title' => $c_s['title'],
                        'subtitle' => $c_s['subtitle'],
                        'icon' => $c_s['icon'],
                        'images' => $c_s['images'],
                        'description' => $c_s['description'],
                        'sign' => $c_s['sign'],
                        'thumb' => $c_s['thumb'],
                        'themes' => $c_s['themes'],
                        'tourl' => $c_s['tourl'],
                        'value' => $c_s['value'],
                        'status' => $c_s['status'],
                        'displayorder' => $c_s['displayorder'],
                        'createtime' => $c_s['createtime']
                    );
                    pdo_insert($this->table_classes, $cs_data);
                    $ccid[$c_s['id']] = pdo_insertid();
                    if (count($children[$c_s['id']]) > 0){
                        foreach($children[$c_s['id']] as $c_t){
                            /** 三级 */
                            $ct_data = array(
                                'uniacid' => $uniacid,
                                'topid' => $ccid[$c['id']],
                                'parid' => $ccid[$c_s['id']],
                                'level' => 3,
                                'title' => $c_t['title'],
                                'subtitle' => $c_t['subtitle'],
                                'icon' => $c_t['icon'],
                                'images' => $c_t['images'],
                                'description' => $c_t['description'],
                                'sign' => $c_t['sign'],
                                'thumb' => $c_t['thumb'],
                                'themes' => $c_t['themes'],
                                'tourl' => $c_t['tourl'],
                                'value' => $c_t['value'],
                                'status' => $c_t['status'],
                                'displayorder' => $c_t['displayorder'],
                                'createtime' => $c_t['createtime']
                            );
                            pdo_insert($this->table_classes, $ct_data);
                            $ccid[$c_t['id']] = pdo_insertid();
                        }
                    }
                }
            }
        }
        m('cache')->set('database_ccid', $ccid, $uniacid);
        return $ccid;
    }
    
    public function insertArticle($data, $uniacid){
        //$data = json_decode(base64_decode($data), true);
        $ccid = m('cache')->get('database_ccid', $uniacid);
        if(empty($ccid)){return result(1, "Ccid Is Empty!", array('from' => 'insertArticle', 'ccid' => $ccid, 'acid' => $o_acid));}
        $acid = array();
        foreach($data as $article){
            $a_data = array(
                'uniacid' => $uniacid,
                'firstclass' => $ccid[$article['firstclass']],
                'secondclass' => $ccid[$article['secondclass']],
                'thirdclass' => $ccid[$article['thirdclass']],
                'themes' => $article['themes'],
                'banner' => $article['banner'],
                'sign' => $article['sign'],
                'icon' => $article['icon'],
                'title' => $article['title'],
                'subtitle' => $article['subtitle'],
                'author' => $article['author'],
                'description' => $article['description'],
                'thumb' => $article['thumb'],
                'images' => $article['images'],
                'content' => $article['content'],
                'content2' => $article['content2'],
                'content3' => $article['content3'],
                'tag' => $article['tag'],
                'good' => $article['good'],
                'reading' => $article['reading'],
                'value' => $article['value'],
                'tourl' => $article['tourl'],
                'status' => $article['status'],
                'istranslate' => $article['istranslate'],
                'displayorder' => $article['displayorder'],
                'updatetime' => $article['updatetime'],
                'createtime' => $article['createtime']
            );
            pdo_insert($this->table_articles, $a_data);
            $acid[$article['id']] = pdo_insertid();
        }
        m('cache')->set('database_acid', $acid, $uniacid);
        return $acid;
    }
    
    public function insertSetting($data, $uniacid){
        $data = json_decode(base64_decode($data), true);
        $ccid = m('cache')->get('database_ccid', $uniacid);
        $acid = m('cache')->get('database_acid', $uniacid);
        if(empty($ccid) || empty($acid)){return result(1, "ChangeId Is Empty!", array('from' => 'insertSetting', 'ccid' => $ccid, 'acid' => $acid));}
        $settings = m('common')->getModuleSetting($uniacid);
        if(empty($settings['global']['mobilethemes'])){
            return result(1, "This Account's Theme Is Empty!");
        }
        
        $settings['home']['advantages']['content'] = iunserializer($settings['home']['advantages']['content']);
        $settings['global']['mobilethemes'] = !empty($settings['global']['mobilethemes'])?$settings['global']['mobilethemes']:'default';
        
        $dht_info = $this->replaceHomeChangeId($data['home'][$settings['global']['mobilethemes']], $ccid, $acid);
        
        $set_data = array(
            'value' => array(
                'global' => $data['global'],
                'home' => array(
                    'banner' => $data['home']['banner'],
                    $settings['global']['mobilethemes'] => $dht_info
                )
            )
        );
        $set_data['value']['home'] = array_merge($settings['home'], $set_data['value']['home']);
        $result = m('common')->saveModuleSetting($set_data, $uniacid);
        return $result;
    }
    
    public function insertNav($data, $uniacid){
        $data = json_decode(base64_decode($data), true);
        $ccid = m('cache')->get('database_ccid', $uniacid);
        $acid = m('cache')->get('database_acid', $uniacid);
        if(empty($ccid) || empty($acid)){return result(1, "ChangeId Is Empty!", array('from' => 'insertNav', 'ccid' => $ccid, 'acid' => $acid));}
        $category = $data['category'];
  		$children = $data['children'];
        $ncid = array();
        foreach($category as $c){
            /** 一级 */
            $c_data = array(
                'uniacid' => $uniacid,
                'topid' => 0,
                'parid' => 0,
                'level' => 1,
                'type' => 'topnav',
                'title' => $c['title'],
                'sign' => $c['sign'],
                'url' => $this->replaceUrlChangeId($c['url'], $ccid, $acid),
                'target' => $c['target'],
                'value' => $c['value'],
                'status' => $c['status'],
                'displayorder' => $c['displayorder']
            );
            pdo_insert($this->table_navs, $c_data);
            $ncid[$c['id']] = pdo_insertid();
            if(count($children[$c['id']]) > 0){
                foreach($children[$c['id']] as $c_s){
                    /** 二级 */
                    $cs_data = array(
                        'uniacid' => $uniacid,
                        'topid' => $ncid[$c['id']],
                        'parid' => $ncid[$c['id']],
                        'level' => 2,
                        'type' => 'topnav',
                        'title' => $c_s['title'],
                        'sign' => $c_s['sign'],
                        'url' => $this->replaceUrlChangeId($c_s['url'], $ccid, $acid),
                        'target' => $c_s['target'],
                        'value' => $c_s['value'],
                        'status' => $c_s['status'],
                        'displayorder' => $c_s['displayorder'],
                    );
                    pdo_insert($this->table_navs, $cs_data);
                    $ncid[$c_s['id']] = pdo_insertid();
                    if (count($children[$c_s['id']]) > 0){
                        foreach($children[$c_s['id']] as $c_t){
                            /** 三级 */
                            $ct_data = array(
                                'uniacid' => $uniacid,
                                'topid' => $ncid[$c['id']],
                                'parid' => $ncid[$c_s['id']],
                                'level' => 3,
                                'type' => 'topnav',
                                'title' => $c_t['title'],
                                'sign' => $c_t['sign'],
                                'url' => $this->replaceUrlChangeId($c_t['url'], $ccid, $acid),
                                'target' => $c_t['target'],
                                'value' => $c_t['value'],
                                'status' => $c_t['status'],
                                'displayorder' => $c_t['displayorder']
                            );
                            pdo_insert($this->table_navs, $ct_data);
                            $ncid[$c_t['id']] = pdo_insertid();
                        }
                    }
                }
            }
        }
        
        return true;
    }
    
    /** 替换 分类中的直接链接ID */
    public function rcci_Category($uniacid){
        $ccid = m('cache')->get('database_ccid', $uniacid);
        $acid = m('cache')->get('database_acid', $uniacid);
        if(empty($ccid) || empty($acid)){return result(1, "ChangeId Is Empty!", array('from' => 'rcci_Category', 'ccid' => $ccid, 'acid' => $acid));}
        $category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $uniacid . '\' ORDER BY parid ASC, displayorder DESC');
        for($i=0;$i<count($category);$i++){
            if(!empty($category[$i]['tourl'])){
                $new_url = $this->replaceUrlChangeId($category[$i]['tourl'], $ccid, $acid);
                pdo_update($this->table_classes, array('tourl' => $new_url), array('id' => $category[$i]['id']));
            }
        }
    }
    
    /** 替换 文章中的直接链接ID */
    public function rcci_Article($page = 0, $uniacid){
        $ccid = m('cache')->get('database_ccid', $uniacid);
        $acid = m('cache')->get('database_acid', $uniacid);
        if(empty($ccid) || empty($acid)){return result(1, "ChangeId Is Empty!", array('from' => 'rcci_Article', 'ccid' => $ccid, 'acid' => $acid));}
        
        $params = array('uniacid' => $uniacid);
        
        $pindex = max(1, intval($page));
        $psize = 12;
        
        $count = countAll($this->table_articles, $params);
        $pages = ceil($count/$psize);
        $articles = getAll($this->table_articles, $params, array(), array($pindex, $psize));
        
        for($i=0;$i<count($articles);$i++){
            if(!empty($articles[$i]['tourl'])){
                $new_url = $this->replaceUrlChangeId($articles[$i]['tourl'], $ccid, $acid);
                pdo_update($this->table_articles, array('tourl' => $new_url), array('id' => $articles[$i]['id']));
            }
        }
        
        $page++;
        if($page <= $pages){
            $this->rcci_Article($page, $uniacid);
        }
        
    }
    
    public function delCache($uniacid){
        m('cache')->del('database_ccid', $uniacid);
        m('cache')->del('database_acid', $uniacid);
        return true;
    }
    
    private function replaceHomeChangeId($str, $ccid, $acid){
        if(empty($ccid) || empty($acid)){return result(-1, "ChangeId Is Empty!", array('from' => 'replaceHomeChangeId', 'ccid' => $ccid, 'acid' => $acid));}
        foreach($str as $gk=>$gv)
        {
            if(stripos($gk, 'class') !== false){ 
                if(!is_array($gv)){
                    if(!empty($ccid[$gv])){
                        $str[$gk] = $ccid[$gv];
                    }
                }else{
                    for($i = 0; $i < count($gv); $i++){
                        if(!empty($ccid[$gv[$i]])){
                            $str[$gk][$i] = $ccid[$gv[$i]];
                        }
                    }
                }
                
            }
            elseif(stripos($gk, 'article') !== false){
                if(!is_array($gv)){
                    if(!empty($acid[$gv])){
                        $str[$gk] = $acid[$gv];
                    }
                }else{
                    for($i = 0; $i < count($gv); $i++){
                        if(!empty($acid[$gv[$i]])){
                            $str[$gk][$i] = $acid[$gv[$i]];
                        }
                    }
                }
                
            }
            elseif(stripos($gk, 'diyform') !== false){
                if(!is_array($gv)){
                    if(!empty($acid[$gv])){
                        $str[$gk] = '';
                    }
                }else{
                    for($i = 0; $i < count($gv); $i++){
                        if(!empty($acid[$gv[$i]])){
                            $str[$gk][$i] = '';
                        }
                    }
                }
            }
            elseif(stripos($gk, 'diy') !== false && $gk != 'diyform'){
                if(is_array($gv)){
                    foreach($gv as $gk2=>$gv2)
                    {
                        if(stripos($gk2, 'class') !== false){
                            if(!empty($ccid[$gv2])){
                                $gv[$gk2] = $ccid[$gv2];
                            }
                        }
                        elseif(stripos($gk2, 'article') !== false){
                            if(!empty($acid[$gv2])){
                                $gv[$gk2] = $acid[$gv2];
                            }
                        }
                        elseif(stripos($gk2, 'diyform') !== false){
                            if(!empty($acid[$gv2])){
                                $gv[$gk2] = '';
                            }
                        }
                    }
                    $str[$gk] = $gv;
                }
            }
        }
        return $str;
    }
    
    private function replaceUrlChangeId($str, $ccid, $acid){
       global $_W, $_B;
        if(empty($ccid) || empty($acid)){return result(-1, "ChangeId Is Empty!", array('from' => 'replaceUrlChangeId', 'ccid' => $ccid, 'acid' => $acid));}
        $_B['setting']['global']['isrewrite'] = 1;/** 演示数据中，是打开伪静态的 */
        $id = m('common')->getId($str);
        if(!empty($id)){
            if(stripos($str, 'r=class') !== false || stripos($str, 'class_') !== false){
                $ccid[$id] = !empty($ccid[$id])?$ccid[$id]:$id;
                $str = foregUrl('class', array('id' => $ccid[$id]), true);
                $str = str_replace($_W['siteroot'], "../", $str);
            }
            elseif(stripos($str, 'r=article') !== false || stripos($str, 'article_') !== false){
                $acid[$id] = !empty($acid[$id])?$acid[$id]:$id;
                $str = foregUrl('article', array('id' => $acid[$id]), true);
                $str = str_replace($_W['siteroot'], "../", $str);
            }
        }else{
            parse_str($str);
            if(stripos($str, 'do=foreg') !== false && $i){
                $str = foregUrl();
                $str = str_replace($_W['siteroot'], "../", $str);
            }elseif(!$i){
                $rew_url = explode('/', $str);
                foreach($rew_url as $rew_i){
                    if($rew_i == 'index.html'){
                        $str = foregUrl();
                        $str = str_replace($_W['siteroot'], "../", $str);
                        break;
                    }
                }   
            }
        }
        return $str;
    }
}
