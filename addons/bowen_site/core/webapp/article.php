<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/28 16:07:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class Article_Page extends WebappPage 
{
    public function main()
    {
        global $_W,$_GPC,$_B;
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $settings = $_B['setting'];
        $id = intval($_GPC['id']);
        if(empty($id)){
            echo('Access Denied');
            sleep(3);
            header('location: ' . foregUrl());
        }

        $article = $this->getArticleInfo($id);
        $article['value'] = iunserializer($article['value']);

        if($article['tourl'] && $article['tourl'] != '#'){
            header('location: ' . $article['tourl']);die;
        }

        if(!in_array($article['themes'], array('pages','pages_about','pages_map')))
        {//普通专题模板不需要分类
            if(empty($article['thirdclass']) && !empty($article['secondclass'])){
                //文章属于二级分类
                //获取同级分类
                $navs = $this->getClasses('same', array('parid'=>$article['firstclass']));
                //当前分类信息
                $class_info = $this->getClassInfo($article['secondclass']);
                //上级分类信息
                $category_parent = $lastclass = $this->getClassInfo($article['firstclass']);
            }elseif(empty($article['secondclass'])){
                //文章属于一级分类
                $class_info = $this->getClassInfo($article['firstclass']);
                $category_parent = $lastclass = $class_info;
            }else{
                //文章属于三级分类
                //获取同级分类
                $navs = $this->getClasses('same', array('parid'=>$article['thirdclass']));
                //当前分类信息
                $class_info = $this->getClassInfo($article['thirdclass']);
                //上级分类信息
                $category_parent = $lastclass = $this->getClassInfo($article['secondclass']);
                //顶级分类
                $topclass = $this->getClassInfo($article['firstclass']);
            }

            $banner = $lastclass['thumb'];
            $sign = $lastclass['sign'];

            //上一篇
            $last_article = pdo_fetch("SELECT id,title FROM ".tablename($this->table_articles)." WHERE id < {$id} AND firstclass = {$article['firstclass']} AND secondclass = {$article['secondclass']} ORDER BY id desc limit 1");
            //下一篇
            $next_article = pdo_fetch("SELECT id,title FROM ".tablename($this->table_articles)." WHERE id > {$id} AND firstclass = {$article['firstclass']} AND secondclass = {$article['secondclass']} ORDER BY id ASC limit 1");
        }
        $banner = !empty($article['banner'])?$article['banner']:$banner;
        $banner = !empty($banner)?tomedia($banner):'';
        $sign = !empty($article['sign'])?$article['sign']:$sign;

        //SEO
        $_W['page']['title'] = $article['title'] . " - " . $settings['global']['title'];
        $seo = $article['value']['seo'];
        if(!empty($seo['title'])){
            $_W['page']['title'] = $this->_replace($seo['title'], $settings, $article, $class_info, $lastclass);
        }
        if(!empty($seo['keyword'])){
            $settings['global']['keyword'] = $this->_replace($seo['keyword'], $settings, $article, $class_info, $lastclass);
        }
        if(!empty($seo['description'])){
            $settings['global']['description'] = $this->_replace($seo['description'], $settings, $article, $class_info, $lastclass);
        }

        $page_title = $article['title'];
        $template = !empty($article['themes'])?$article['themes']:'pages';
        include $this->mytemplate('article/' . $template);
    }

    private function _replace($content, $settings, $article, $class = array(), $lastclass = array())
    {
        if (stripos($content,'#文章标题#') !== false){
            $content = str_replace("#文章标题#", $article['title'], $content);
        }
        if (stripos($content,'#分类标题#') !== false){
            $content = str_replace("#分类标题#", $class['title'], $content);
        }
        if (stripos($content,'#上级分类标题#') !== false){
            $content = str_replace("#上级分类标题#", $lastclass['title'], $content);
        }
        if (stripos($content,'#站点名称#') !== false){
            $content = str_replace("#站点名称#", $settings['global']['title'], $content);
        }

        return $content;
    }

    public function addReading()
    {
        global $_GPC,$_W;

        if($_W['ispost'] && $_W['isajax']){
            $id = intval($_GPC['id']);
            if(empty($id)){
                $this->result(1,'Access Denied');
            }
            $sql = 'UPDATE '.tablename($this->table_articles).' SET reading=reading+1 WHERE id = '.$id;
            $result = pdo_run($sql);
            $this->result(0,'Add Reading Success');
        }
        exit('Access Denied');
    }
}
