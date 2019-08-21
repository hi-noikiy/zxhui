<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/28 16:08:15] -->
 */
defined('IN_IA') or exit('Access Denied');

class Search_Page extends MobilePage 
{
	public function main() 
	{
	   global $_W,$_GPC,$_B;
        $settings = $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $_W['page']['title'] = '搜索' . " - " . $settings['global']['title'];
        
        $keywords =  safe_gpc_string(trim($_GPC['kw']));
        $tag = safe_gpc_string(trim($_GPC['tag']));
        
        if(!empty($keywords)){
            $commoncondition = ' status = 1 ';
            $commoncondition .= " AND title LIKE '%{$keywords}%' ";
            
            if(!empty($_GPC['classlevel']) && !empty($_GPC['class'])){
                $classlevel = intval($_GPC['classlevel']);
                $classid = intval($_GPC['class']);
                switch($classlevel){
                    case 1:
                        $commoncondition .= " AND firstclass LIKE '%{$classid}%' ";
                        break;
                    case 1:
                        $commoncondition .= " AND secondclass LIKE '%{$classid}%' ";
                        break;
                    case 1:
                        $commoncondition .= " AND thirdclass LIKE '%{$classid}%' ";
                        break;
                }
            }
            
            $pindex = max(1, intval($_GPC['page']));
            $psize = 12;
            $count = $this->getArticlesColumn($commoncondition);
            $articles = $this->getArticles($commoncondition, array('createtime DESC'), array($pindex, $psize));
            
            if(empty($articles)){
                $commoncondition2 = ' status = 1 ';
                $commoncondition2 .= " AND content LIKE '%{$keywords}%' ";
                
                $count = $this->getArticlesColumn($commoncondition2);
                $articles = $this->getArticles($commoncondition2, array('createtime DESC'), array($pindex, $psize));
            }
        }elseif($tag){
            $commoncondition = ' status = 1 ';
            $commoncondition .= " AND tag LIKE '%{$tag}%' ";
            
            $pindex = max(1, intval($_GPC['page']));
            $psize = 12;
            $count = $this->getArticlesColumn($commoncondition);
            $articles = $this->getArticles($commoncondition, array('createtime DESC'), array($pindex, $psize));
        }

        $page_title = '搜索';
        $template = 'search';
        include $this->mytemplate();
	}
}
