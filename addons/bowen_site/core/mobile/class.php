<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/03 21:51:05] -->
 */
defined('IN_IA') or exit('Access Denied');

class Class_Page extends MobilePage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $settings = $_B['setting'];
        $id = intval($_GPC['id']);
        if(!is_numeric($id) || empty($id)){
            echo('Access Denied');
            sleep(3);
            header('location: ' . foregUrl());
        }
        
        $class_info = $this->getClassInfo($id);
        $class_info['value'] = iunserializer($class_info['value']);
        if($class_info['tourl'] && $class_info['tourl'] != '#'){
            header('location: ' . $class_info['tourl']);die;
        }
        $_W['page']['title'] = $class_info['title'] . " - " . $settings['global']['title'];
        
        if($class_info['level'] == 2){
            //获取同级分类
            $navs = $this->getClasses('same', array('parid'=>$class_info['parid']));
            //上级分类信息
            $category_parent = $lastclass = $this->getClassInfo($class_info['parid']);
            $banner = $class_info['thumb'];
            if(empty($banner)){$banner = $lastclass['thumb'];}
            $all = array(
                'id' => $class_info['parid']
            );
        }elseif($class_info['level'] == 3){
            $topclass = $this->getClassInfo($class_info['topid']);
            //获取同级分类
            $navs = $this->getClasses('same', array('parid'=>$class_info['topid']));
            //上级分类信息
            $category_parent = $lastclass = $this->getClassInfo($class_info['parid']);
            $banner = $class_info['thumb'];
            if(empty($banner)){$banner = $lastclass['thumb'];}
            if(empty($banner)){$banner = $topclass['thumb'];}
            $all = array(
                'id' => $class_info['topid']
            );
        }else{
            $navs = $this->getClasses('lower', array('cid'=>$id));
            $category_parent = $lastclass = $class_info;//老版本定义的变量就是$lastclass['title']
            $banner = $class_info['thumb'];
            $all = array(
                'id' => $class_info['id']
            );
        }
        $banner = !empty($banner)?tomedia($banner):'';
        $no_need = array('metinfo_328', 'bowen_help');
        if(!in_array($settings['global']['mobilethemes'], $no_need)){
            $commoncondition = ' status = 1 ';
            if(!empty($_GPC['kw'])){
                $keywords =  safe_gpc_string(trim($_GPC['kw']));
                $tag = safe_gpc_string(trim($_GPC['tag']));
                
                if(!empty($keywords)){
                    $commoncondition .= " AND title LIKE '%{$keywords}%' ";
                }
                elseif(!empty($tag)){
                    $commoncondition .= " AND tag LIKE '%{$tag}%' ";
                }
            }
            
            //获取文章列表
            $pindex = max(1, intval($_GPC['page']));
            $psize = !empty($class_info['value']['psize'])?$class_info['value']['psize']:12;
            $count = $this->getClasseArticlesColumn($id, $commoncondition);
            $articles = $this->getClasseArticles($id, $commoncondition, array('displayorder DESC', 'createtime DESC'), array($pindex, $psize));
        }
        
        $sign = !empty($class_info['sign'])?$class_info['sign']:(!empty($lastclass['sign'])?$lastclass['sign']:$topclass['sign']);
        
        //SEO
        $_W['page']['title'] = $class_info['title'] . " - " . $settings['global']['title'];
        $seo = $class_info['value']['seo'];
        if(!empty($seo['title'])){
            $_W['page']['title'] = $this->_replace($seo['title'], $settings, $class_info, $lastclass);
        }
        if(!empty($seo['keyword'])){
            $settings['global']['keyword'] = $this->_replace($seo['keyword'], $settings, $class_info, $lastclass);
        }
        if(!empty($seo['description'])){
            $settings['global']['description'] = $this->_replace($seo['description'], $settings, $class_info, $lastclass);
        }

        $page_title = $class_info['title'];
        $template = !empty($class_info['themes'])?$class_info['themes']:'article';
        include $this->mytemplate('class/' . $template);
	}
    
    private function _replace($content, $settings, $class = array(), $lastclass = array())
    {
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
    
    public function getArticles_list(){
        global $_W,$_GPC;
        if(($_W['isajax'] && $_W['ispost']) || $_GPC['check'] == 1){
            $id = intval($_GPC['id']);
            $hide_lower_leve = ($_GPC['hide_lower_leve'] == 1)?false:true;
            $commoncondition = " status = 1";

            if(!empty($_GPC['kw'])){
                $keywords =  safe_gpc_string(trim($_GPC['kw']));
                $tag = safe_gpc_string(trim($_GPC['tag']));

                if(!empty($keywords)){
                    $commoncondition .= " AND title LIKE '%{$keywords}%' ";
                }
                elseif(!empty($tag)){
                    $commoncondition .= " AND tag LIKE '%{$tag}%' ";
                }
            }elseif(!empty($_GPC['title'])){/** 兼容老版本的ajax搜索 */
                $commoncondition .= " AND title LIKE '%{$_GPC['title']}%' ";
            }
            
            $pindex = max(1, intval($_GPC['page']));
            $psize = !empty($_GPC['psize'])?$_GPC['psize']:12;
            $isASC = !empty($_GPC['isASC'])?'ASC':'DESC';
            
            $count = $this->getClasseArticlesColumn($id, $commoncondition, $hide_lower_leve);//print_r($count);exit();
            $articles = $this->getClasseArticles($id, $commoncondition, array('displayorder DESC', 'createtime ' . $isASC), array($pindex, $psize), $hide_lower_leve);
            $pages = ceil($count/$psize);
            
            if(count($articles) > 0){
                for($i = 0; $i < count($articles); $i++){
                    $articles[$i]['reading'] = $articles[$i]['reading']?$articles[$i]['reading']:0;

                    /** 对文章简介进行处理 */
                    if (!empty($articles[$i]['description'])){
                        $articles[$i]['description_repl'] = html_entity_decode(replaceRN($articles[$i]['description']), ENT_QUOTES);
                    }
                    if (empty($articles[$i]['description'])){
                        $articles[$i]['description'] = m('ui')->html_to_text($articles[$i]['content']);
                    }
                    $desc_cutLength = intval($_GPC['desc_cutLength']);
                    if(!empty($desc_cutLength)){
                        $articles[$i]['description'] = m('common')->msubstr($articles[$i]['description'],0,$desc_cutLength);
                    }

                    /** 对文章内容进行转换 */
                    if(empty($_GPC['contentType'])){
                        $articles[$i]['content'] = html_entity_decode($articles[$i]['content'], ENT_QUOTES);
                    }elseif($_GPC['contentType'] == 'lazy'){
                        $articles[$i]['content'] = m('ui')->html_lazy($articles[$i]['content']);
                    }elseif($_GPC['contentType'] == 'layui'){
                        $articles[$i]['content'] = m('ui')->layui($articles[$i]['content'], false);
                    }elseif($_GPC['contentType'] == 'lazy_layui'){
                        $articles[$i]['content'] = m('ui')->layui($articles[$i]['content']);
                    }

                    /** 对文章扩展内容2进行转换 */
                    if(empty($_GPC['content2Type'])){
                        $articles[$i]['content2'] = html_entity_decode($articles[$i]['content2'], ENT_QUOTES);
                    }elseif($_GPC['content2Type'] == 'lazy'){
                        $articles[$i]['content2'] = m('ui')->html_lazy($articles[$i]['content2']);
                    }elseif($_GPC['content2Type'] == 'layui'){
                        $articles[$i]['content2'] = m('ui')->layui($articles[$i]['content2'], false);
                    }elseif($_GPC['content2Type'] == 'lazy_layui'){
                        $articles[$i]['content2'] = m('ui')->layui($articles[$i]['content2']);
                    }

                    /** 对文章扩展内容3进行转换 */
                    if(empty($_GPC['content3Type'])){
                        $articles[$i]['content3'] = html_entity_decode($articles[$i]['content3'], ENT_QUOTES);
                    }elseif($_GPC['content3Type'] == 'lazy'){
                        $articles[$i]['content3'] = m('ui')->html_lazy($articles[$i]['content3']);
                    }elseif($_GPC['content3Type'] == 'layui'){
                        $articles[$i]['content3'] = m('ui')->layui($articles[$i]['content3'], false);
                    }elseif($_GPC['content3Type'] == 'lazy_layui'){
                        $articles[$i]['content3'] = m('ui')->layui($articles[$i]['content3']);
                    }
                    
                    $articles[$i]['d_createtime'] = date('d', $articles[$i]['createtime']);
                    $articles[$i]['m_createtime'] = month_en(date('m', $articles[$i]['createtime']));
                    $articles[$i]['createtime'] = date('Y-m-d', $articles[$i]['createtime']);
                    
                    $articles[$i]['tag'] = iunserializer($articles[$i]['tag']);
                    $articles[$i]['images'] = iunserializer($articles[$i]['images']);
                    /** 如果配图为空，则读取封面图 */
                    if(empty($articles[$i]['images']) && !empty($articles[$i]['thumb']))$articles[$i]['images'][0] = $articles[$i]['thumb'];
                    /** 封面图为空则读取第一张配图 */
                    if(empty($articles[$i]['thumb']) && !empty($articles[$i]['images']))$articles[$i]['thumb'] = $articles[$i]['images'][0];
                    /** 如果二者都为空，则直接输出“暂无图片”图片 */
                    if(empty($articles[$i]['thumb'])){
                        $articles[$i]['thumb'] = '../web/resource/images/nopic.jpg';
                        $articles[$i]['images'][0] = '../web/resource/images/nopic.jpg';
                    }
                    /** 配图附件链接转换 */
                    if(!empty($articles[$i]['images'])){
                        for($ii = 0; $ii < count($articles[$i]['images']); $ii++){
                            $articles[$i]['images'][$ii] = tomedia($articles[$i]['images'][$ii]);
                        }
                    }

                    /** 封面图裁剪及附件链接转换 */
                    if(!empty($articles[$i]['thumb'])){
                        $articles[$i]['thumb'] = tomedia($articles[$i]['thumb']);
                        if(!empty($_GPC['thumb_crop'])){
                            $thumb_crop_w = intval($_GPC['thumb_crop']['width']);
                            $thumb_crop_h = intval($_GPC['thumb_crop']['height']);
                            $articles[$i]['thumb'] = m('image')->image_crop($articles[$i]['thumb'], $thumb_crop_w, $thumb_crop_h);
                        }
                    }
                }
            }
            
            exit($this->result(0, 'success', $articles, array('pages'=>$pages)));
        }
        exit($this->result(1, 'Access Denied'));
    }
}