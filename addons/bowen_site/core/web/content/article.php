<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/05 10:54:15] -->
 */
defined('IN_IA') or exit('Access Denied');

class Article_Page extends ComWebPage 
{
    public function getList(){
        global $_W, $_GPC;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "非法访问"));
        }
        
        $commoncondition = "";
        
        $commoncondition .= " AND uniacid LIKE {$_W['uniacid']} ";
        
        $id = intval($_GPC['id']);
        if(!empty($id)){
            $commoncondition .= " AND id LIKE '{$id}' ";
        }
        
        if(!empty($_GPC['title'])){
            $commoncondition .= " AND title LIKE '%{$_GPC['title']}%' ";
        }
        
        if ($_GPC['status'] != '') {
            $commoncondition .= " AND status LIKE {$_GPC['status']} ";
        }
        
        if ($_GPC['istranslate'] != '') {
            $commoncondition .= " AND istranslate LIKE {$_GPC['istranslate']} ";
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
        }
        
        if (!empty($_GPC['createtime'])) {
            $createtime = explode(" - ", $_GPC['createtime']);
            $sctime = strtotime($createtime[0]);
            $ectime = strtotime($createtime[1]);
            $commoncondition .= " AND createtime >= {$sctime} AND createtime <= {$ectime} ";
        }
        
        if (!empty($_GPC['updatetime'])) {
            $updatetime = explode(" - ", $_GPC['updatetime']);
            $sutime = strtotime($updatetime[0]);
            $eutime = strtotime($updatetime[1]);
            $commoncondition .= " AND updatetime >= {$sutime} AND updatetime <= {$eutime} ";
        }
          
        $pindex = max(1, intval($_GPC['page']));
        $psize = !empty($_GPC['psize'])?intval($_GPC['psize']):12;
        $count = $this->countAll($this->table_articles, $commoncondition);
        $list = $this->getAll($this->table_articles, $commoncondition, array('displayorder DESC', 'createtime DESC'), array($pindex, $psize));
        
        if(!empty($list)){
            $article_themes = $this->getThemes_mobile_config('article');
            $classes_info = $this->getClasses('false');
            for($i=0;$i<count($list);$i++){
                $list[$i]['createtime'] = date('Y-m-d H:i:s', $list[$i]['createtime']);
                $list[$i]['themes_title'] = !empty($list[$i]['themes'])?$article_themes[$list[$i]['themes']]['title']:'无需模板';
                if($classes_info[$list[$i]['firstclass']]['title']){
                    $list[$i]['category'] = $classes_info[$list[$i]['firstclass']]['title'];
                    if($classes_info[$list[$i]['secondclass']]['title']){
                        $list[$i]['category'] .= ' - '.$classes_info[$list[$i]['secondclass']]['title'];
                        if($classes_info[$list[$i]['thirdclass']]['title']){
                            $list[$i]['category'] .= ' - '.$classes_info[$list[$i]['thirdclass']]['title'];
                        }
                    }
                }
            }
        }
        
        $this->result(0, 'success', $list, array('count' => $count));
    }
    
    public function updateField(){
        global $_GPC, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $field = trim($_GPC['field']);
        $value = trim($_GPC['value']);
        if(empty($id) || empty($field) || ($value == '' && $field != 'tourl') || !in_array($field, array('displayorder', 'title', 'tourl'))){
            $this->result(2, "参数错误，无效的参数");
        }
        if($field == 'displayorder')$value=intval($value);
        $change_data = array(
            $field => $value
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_articles, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '编辑成功', array($field => $value));
        }
        $this->result(2, '未知错误');
        
    }
    
    public function  changeStatus(){
       global $_GPC, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $status = intval($_GPC['status']);
        $status = empty($status)?1:0;
        $change_data = array(
            'status' => $status
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_articles, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '文章状态切换成功', array('status' => $status));
        }
        $this->result(2, '未知错误');
    }
    
    public function  changeTranslate(){
       global $_GPC, $_W;
        if(!$_W['isajax']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $translate = intval($_GPC['translate']);
        $translate = empty($translate)?1:0;
        $change_data = array(
            'istranslate' => $translate
        );
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
        $result = pdo_update($this->table_articles, $change_data, array('id' => $id));
        if(!empty($result)){
            $this->result(0, '推荐状态切换成功', array('istranslate' => $translate));
        }
        $this->result(2, '未知错误');
    }
    
    public function delete()
    {
       global $_W,$_GPC;
        
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        
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
        
		$articles = pdo_fetchall('SELECT id,title FROM ' . tablename($this->table_articles) . ' WHERE id in( ' . $id . ' )');
        
        if(TEST_SITE){$this->result(1, '测试站禁止操作数据');}
		
        foreach ($articles as $article) {
			pdo_delete($this->table_articles, array('id' => $article['id']));
		}
        
		$this->result(0, "操作成功", $articles);
    }

    public function copyArticle(){
        global $_W, $_GPC;
        if(!$_W['isajax'] || !$_W['ispost']){
            exit($this->result(2, "参数错误，无效的传入方式"));
        }
        $id = intval($_GPC['id']);
        $old_article = $this->getArticleInfo($id, array(), false);

        if(!$old_article){
            $this->result(-1, "复制失败，源文章不存在或已删除");
        }

        $new_article_data = array(
            'firstclass' => $old_article['firstclass'],
            'secondclass' => $old_article['secondclass'],
            'thirdclass' => $old_article['thirdclass'],
            'themes' => $old_article['themes'],
            'banner' => $old_article['banner'],
            'title' => $old_article['title'],
            'subtitle' => $old_article['subtitle'],
            'author' => $old_article['author'],
            'sign' => $old_article['sign'],
            'icon' => $old_article['icon'],
            'thumb' => $old_article['thumb'],
            'description' => $old_article['description'],
            'images' => $old_article['images'],
            'content' => $old_article['content'],
            'content2' => $old_article['content2'],
            'content3' => $old_article['content3'],
            'value' => $old_article['value'],
            'tourl' => $old_article['tourl'],
            'status' => $old_article['status'],
            'istranslate' => $old_article['istranslate'],
            'displayorder' => $old_article['displayorder'],
            'reading' => $old_article['reading'],
            'tag' => $old_article['tag'],
            'createtime' => TIMESTAMP,
            'updatetime' => TIMESTAMP
        );

        $new_article_data['uniacid'] = $_W['uniacid'];
        $result = pdo_insert($this->table_articles, $new_article_data);

        if(!empty($result)){
            $this->result(0, "复制文章 [". $old_article['title'] ."] 成功");
        }else{
            $this->result(2, "复制失败，未知错误");
        }
    }
}
