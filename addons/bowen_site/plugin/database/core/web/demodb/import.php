<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:38:09] -->
 */
defined('IN_IA') or exit('Access Denied');

class Import_Page extends PluginWebPage
{
    public function main()
    {
       global $_W, $_GPC;
        $_W['page']['title'] = "主题数据导入";
        $setting = m('common')->getModuleSetting($_W['uniacid']);
        if(empty($setting['global']['mobilethemes'])){
            itoast("请先选择模板！", webUrl('setting/themes'), 'error');
        }
        include $this->mytemplate();
    }
    
    public function run(){
       global $_W, $_GPC;
        
        if(!$_W['ispost'] || !$_W['isajax']){
            exit($this->result('2', '参数错误'));
        }
        if(TEST_SITE){$this->result(5, '测试站禁止操作数据');}
        set_time_limit(0);/** 重置超时 */
        $msetting = m('common')->getModuleSetting($_W['uniacid']);
        
        $db_source = MODULE_ROOT.'/data/plugin/database/' . $msetting['global']['mobilethemes'];
        $file_write_db_source = FILE_WRITE_M_ROOT.'/data/plugin/database/' . $msetting['global']['mobilethemes'];
        $msetting['global']['mobilethemes'] = $msetting['global']['mobilethemes']?$msetting['global']['mobilethemes']:'default';
        if(!file_exists($db_source."/config.txt") || $_GPC['op'] == 'download'){
            if(file_exists($db_source)){
                rmdirs($db_source);
            }
            if($_W['role'] == ACCOUNT_MANAGE_NAME_FOUNDER){
                load()->func('db');
                load()->func('communication');
                load()->func('file');
                $_W['config']['setting']['filemode'] = 0755;
                
                $oauth = (array)$oauth;
                $oauth['domain'] = $_SERVER['HTTP_HOST'];
                $setting = setting_load('site');
                $copysite = m('common')->getModuleSetting(0);
                $we7id = isset($setting['site']['key'])? $setting['site']['key'] : '1';
                $oauth['id'] = $we7id;
                $oauth['oauth_code'] = !empty($copysite['oauth_info']['oauth_code'])?1:0;
                $oauth['module']= MODULE_NAME;
                $oauth['site'] = $setting;
                $oauth['version'] = $version;
                $oauth['release'] = $release;
                $oauth['timestamp'] = TIMESTAMP;
                $oauth['theme'] = $msetting['global']['mobilethemes'];
                $oauth['sign'] = md5("id={$we7id}&oauth_code={$copysite['oauth_info']['oauth_code']}&timestamp=".$oauth['timestamp']);
                
                if (DEVELOPMENT) {
                    $this->result(0, '请关闭开发者模式后再操作');
                }
                
                $res = @json_decode(oauthPost(oUrl('web', '',array('r' => 'download.theme_info.getContent', 'do' => 'getConfig')),$oauth),true);
                if($res['errno'] == '0'){
                    $config = @json_decode(base64_decode($res['data']), true);
                    $o_config = $res['data'];
                    $category = @json_decode(oauthPost(oUrl('web', '',array('r' => 'download.theme_info.getContent', 'do' => 'getCategory')),$oauth),true);
                    if($category['errno'] == 0){
                        $category = $category['data'];
                    }
                    $navs = @json_decode(oauthPost(oUrl('web', '',array('r' => 'download.theme_info.getContent', 'do' => 'getNavs')),$oauth),true);
                    if($navs['errno'] == 0){
                        $navs = $navs['data'];
                    }
                    $setting = @json_decode(oauthPost(oUrl('web', '',array('r' => 'download.theme_info.getContent', 'do' => 'getSetting')),$oauth),true);
                    if($setting['errno'] == 0){
                        $setting = $setting['data'];
                    }
                    $article = array();
                    for($i=1;$i<=$config['article_pages'];$i++){
                        $article[$i] = @json_decode(oauthPost(oUrl('web', '',array('r' => 'download.theme_info.getContent', 'do' => 'getArticle', 'article_page' => $i)),$oauth),true);
                        if($article[$i]['errno'] == 0){
                            $article[$i] = $article[$i]['data'];
                        }
                        file_write($file_write_db_source."/article/{$i}.txt", $article[$i]);
                    }
                    file_write($file_write_db_source.'/category.txt', $category);
                    file_write($file_write_db_source.'/navs.txt', $navs);
                    file_write($file_write_db_source.'/setting.txt', $setting);
                    //$config = base64_encode(stripslashes(ijson_encode($config)));
                    file_write($file_write_db_source.'/config.txt', $o_config);
                    
                    $this->result(0, "{$msetting['global']['mobilethemes']} 数据下载成功，再次点击即可导入数据");
                }else{
                    $this->result(2, '未知错误', '',$res);
                }
            }else{
                $this->result(-1, "模板数据不存在，请联系管理员");
            }
        }
        $uniacid = $_W['uniacid'];
        $config = file_get_contents($db_source."/config.txt");
        /** 写分类 */
        $category = file_get_contents($db_source."/category.txt");
        $this->model->insertCategory($category, $uniacid);
        /** 写文章 */
        $config = @json_decode(base64_decode($config), true);
        $articles = array();
        for($i=1;$i<=$config['article_pages'];$i++){
            $article = file_get_contents($db_source."/article/{$i}.txt");
            $article = json_decode(base64_decode($article), true);
            $articles = array_merge($articles, $article);
        }
        $this->model->insertArticle($articles, $uniacid);
        /** 写导航 */
        $navs = file_get_contents($db_source."/navs.txt");
        $this->model->insertNav($navs, $uniacid);
        /** 写设置 */
        $setting = file_get_contents($db_source."/setting.txt");
        $this->model->insertSetting($setting, $uniacid);
        /** 修改分类及文章的直接链接 */
        $this->model->rcci_Category($uniacid);
        $this->model->rcci_Article(0, $uniacid);
        
        $this->model->delCache($uniacid);
        $this->result(0, "{$msetting['global']['mobilethemes']} 数据导入成功");
    }

}