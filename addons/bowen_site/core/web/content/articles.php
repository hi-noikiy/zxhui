<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 15:38:16] -->
 */
defined('IN_IA') or exit('Access Denied');

class Articles_Page extends ComWebPage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $_W['page']['title'] = '文章管理';
        $settings = m('common')->getModuleSetting($_W['uniacid']);
        $_B['setting'] = $settings;
        $id = intval($_GPC['id']);
        $op = !empty($_GPC['op'])?$_GPC['op']:'list';
        $article_themes = $this->getThemes_mobile_config('article');
        
        $children = array();
  		$category = pdo_fetchall('SELECT * FROM ' . tablename($this->table_classes) . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY parid ASC, displayorder DESC');
        if(!$category){
            itoast('请先添加文章分类！', webUrl('content/classes'), 'error');
        }
  		foreach ($category as $index => $row) {
            if (!empty($row['parid'])) {
                $children[$row['parid']][] = $row;
				unset($category[$index]);
 			}
  		}
        
        if($op == 'list'){
            if (!empty($_GPC['displayorder'])) {
                if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
                foreach ($_GPC['displayorder'] as $id => $displayorder) {
                    pdo_update($this->table_articles, array('displayorder' => $displayorder), array('id' => $id));
                }
                itoast('排序更新成功！', 'refresh', 'success');
            }
            $params = array(':uniacid' => $_W['uniacid']);
            $commoncondition = " uniacid LIKE :uniacid ";
            
            if(!empty($_GPC['title'])){
                $commoncondition .= " AND title LIKE '%{$_GPC['title']}%' ";
            }
            
            if($_GPC['status'] != ''){
                $commoncondition .= " AND status LIKE '".intval($_GPC['status'])."' ";
            }
            
            if($_GPC['istranslate'] != ''){
                $commoncondition .= " AND istranslate LIKE '".intval($_GPC['istranslate'])."' ";
            }
            
            if(!empty($_GPC['class'])){
                $class = explode("|", $_GPC['class']);
                $firstclass = $class[0];
                $secondclass = $class[1];
                $thirdclass = $class[2];
                
                $commoncondition .= " AND firstclass LIKE '{$firstclass}' ";
                if(!empty($secondclass)){
                    $commoncondition .= " AND secondclass LIKE '{$secondclass}' ";
                }
                if(!empty($thirdclass)){
                    $commoncondition .= " AND thirdclass LIKE '{$thirdclass}' ";
                }
                $orderby = " displayorder DESC,";
            }
            
            if(!empty($id)){
                $commoncondition .= " AND id LIKE '{$id}' ";
            }
            
            if (!empty($_GPC['createtime'])) {
                $createtime = explode(" - ", $_GPC['createtime']);
                $sctime = strtotime($createtime[0]);
                $ectime = strtotime($createtime[1]);
                $commoncondition .= " AND createtime >= :sctime AND createtime <= :ectime ";
                $params[':sctime'] = $sctime;
                $params[':ectime'] = $ectime;
            }
            
            $count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_articles) . " WHERE " . $commoncondition, $params);
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $articles = pdo_fetchall("SELECT * FROM ".tablename($this->table_articles) . " WHERE " . $commoncondition . " ORDER BY ". $orderby . " createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
            $pager = pagination($count, $pindex, $psize);
            
            $classes_info = $this->getClasses('false');
        }
        
        if($op == 'post'){
            $_W['page']['title'] = '编辑文章';
            
            if(empty($settings['global']['mobilethemes'])){
                itoast('请先选择模板！', webUrl('setting/themes'), 'error');
            }
            
            if(checksubmit('submit')){
                if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
                $value = array(
                    'seo' => $_GPC['seo']
                    ,'baidumap' => $_GPC['baidumap']
                    ,'mobilethumb' => trim($_GPC['mobilethumb'])
                );
                
                $tag = array();
                $_GPC['tag'] = explode("\n", trim($_GPC['tag']));
                for($i = 0; $i<count($_GPC['tag']); $i++){
                    /**
                    if(count($tag) >= 3){
                        break;
                    }
                    */
                    if(empty($_GPC['tag'][$i])){
                        continue;
                    }
                    $tag[] = $_GPC['tag'][$i];
                }
                
                $class = explode("|", $_GPC['class']);
                $firstclass = $class[0];
                $secondclass = $class[1];
                $thirdclass = $class[2];
                
                $tourl = trim($_GPC['tourl']);
                if($tourl == foregUrl('article', array('id' => $id))){
                    itoast('直接链接填写错误！', '', 'error');
                }
                $content = m('ui')->ueditor_content($_GPC['content']);
                $content2 = m('ui')->ueditor_content($_GPC['content2']);
                $content3 = m('ui')->ueditor_content($_GPC['content3']);

                $thumb = trim($_GPC['thumb']);
                if($_GPC['autoextrthump'] == 1){
                    $content_info = m('ui')->separation_ImgText($content);
                    $thumb = !empty($thumb)?$thumb:(!empty($content_info['images'][0])?m('ui')->replace_image_attachurl($content_info['images'][0]):'');
                }
                $description = $_GPC['description'];
                if($_GPC['autoextrdesc'] == 1){
                    $description = !empty($description)?$description:m('common')->msubstr(m('ui')->html_to_text($content), 0, 150);
                }
                $data = array(
                    'firstclass' => $firstclass,
                    'secondclass' => $secondclass,
                    'thirdclass' => $thirdclass,
                    'themes' => $_GPC['themes'],
                    'banner' => trim($_GPC['banner']),
                    'title' => trim($_GPC['title']),
                    'subtitle' => trim($_GPC['subtitle']),
                    'author' => trim($_GPC['author']),
                    'sign' => trim($_GPC['sign']),
                    'icon' => trim($_GPC['icon']),
                    'thumb' => $thumb,
                    'description' => $description,
                    'images' => iserializer($_GPC['images']),
                    'content' => $content,
                    'content2' => $content2,
                    'content3' => $content3,
                    'value' => iserializer($value),
                    'tourl' => $tourl,
                    'status' => $_GPC['status'],
                    'istranslate' => $_GPC['istranslate'],
                    'displayorder' => intval($_GPC['displayorder']),
                    'reading' => intval($_GPC['reading']),
                    'tag' => iserializer($tag),
                    'createtime' => strtotime($_GPC['createtime']),
                    'updatetime' => TIMESTAMP
                );
                if(empty($id)){
                    $data['uniacid'] = $_W['uniacid'];
                    $result = pdo_insert($this->table_articles, $data);
                    $id = pdo_insertid();
                    //$re_url = webUrl('content/articles');
                }
                else{
                    $result = pdo_update($this->table_articles, $data, array('id'=>$id));
                    //$re_url = webUrl('content/articles', array('op' => 'post', 'id' => $id));
                }
                if(!empty($result)){
                    mymessage('更新文章成功', webUrl('content/articles', array('op' => 'post', 'id' => $id)), 'success');
                }
            }
            
            if(!empty($id)){
                $article = $this->getArticleInfo($id);
                $article['tag'] = implode("\n", iunserializer($article['tag']));
                $article['class'] = intval($article['firstclass']).'|'.intval($article['secondclass']).'|'.intval($article['thirdclass']);
                $article['images'] = iunserializer($article['images']);
            }
        }
        
        if($op == 'delete'){
            if(TEST_SITE){itoast('测试站禁止操作数据', 'refresh','error');$this->result(1, '测试站禁止操作数据');}
            
            if(empty($id)){
                itoast('参数错误', 'referer', 'error');
            }
            $result = pdo_delete($this->table_articles, array('id'=>$id));
            if(!empty($result)){
                itoast('操作成功', 'referer','success');
            }
            $this->result(0, '未知错误');
        }
        
        include $this->mytemplate('content/articles/' . $op);
	}
    
    public function  changeStatus(){
       global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        //初始数据
        $errno = '0';
        $message = '未知错误';
        $content['status'] = $data;
        
        empty($data)?($data = 1):$data = 0;
        
        $result = pdo_update($this->table_articles, array('status' => $data), array("id" => $id));
        if(!empty($result)){
            $errno = '0';
            $message = 'ok';
            $content['status'] = $data;
        }
        
        $this->result($errno, $message, $content);
    }
    
    public function  changeTranslate(){
       global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        
        $errno = '0';
        $message = '未知错误';
        $content['translate'] = $data;
        
        empty($data)?($data = 1):$data = 0;
        
        $result = pdo_update($this->table_articles, array('istranslate' => $data), array("id" => $id));
        if(!empty($result)){
            $content['translate'] = $data;
            $this->result(0, 'success', $content);
        }
        
        $this->result(1, '操作失败', $content);
    }
    
}
