<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/28 16:07:15] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends WebappPage 
{
    public function main()
    {
        global $_W,$_GPC,$_B;

        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $settings = $_B['setting'];
        $_W['page']['title'] = $settings['global']['title'];
        $sign = 'home';
        $settings['home']['banner'] = iunserializer($_B['setting']['home']['banner']);
        $settings['home']['advantages']['content'] = iunserializer($_B['setting']['home']['advantages']['content']);

        $page_title = $_B['setting']['global']['title'];
        $template = 'index';
        include $this->mytemplate();
    }
    /** 废弃
    public function image_crop()
    {
        global $_GPC;
        $url = $_GPC['url'];
        $width = $_GPC['w'];
        $height = $_GPC['h'];
        if(empty($width)){
            return $url;
        }
        if(empty($height)){
            $height = $width;
        }
        if(empty($url)){return false;}
        m('image')->image_center_crop($url, $width, $height);
    }

    public function diyStatic(){
        global $_W, $_B, $_GPC;

        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $type = in_array($_GPC['type'], array('css', 'js'))?$_GPC['type']:'';
        $filename = (stripos($_GPC['sfn'], '/') == false || stripos($_GPC['sfn'], '%2f') == false)?trim($_GPC['sfn']):'';
        if(empty($type) || empty($filename)){
            exit($this->result(2, '参数错误，缺失重要参数！'));
        }
        header( 'Content-Type:text/html;charset=utf-8 ');
        switch($type){
            case 'css':
                header('Content-type: text/css');
                $suffix = 'css';
                break;
            case 'js' :
                header('Content-type: text/javascript');
                $suffix = 'js';
                break;
        }

        $cache_key = 'diyStaticCacheVersion';
        $diyStaticCacheVersion = m('cache')->get($cache_key, $_W['uniacid']);
        $setting_updatetime = m('common')->getModuleSetting($_W['uniacid'], 'setting', 'updatetime');

        $file_write_static = FILE_WRITE_M_ROOT.'/data/cache/' . $_W['uniacid'] . '/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;
        $file_get_static = M_DATA . 'cache/' . $_W['uniacid'] . '/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;

        if($diyStaticCacheVersion != $setting_updatetime || !file_exists($file_get_static)){
            $path = M_ROOT . '/template/mobile/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;
            if(!file_exists($path)){
                $path = M_ROOT . '/template/mobile/default/static/' . $type . '/' . $filename . '.' . $suffix;
            }
            $static = '';
            if(file_exists($path)){
                $static = file_get_contents($path);
                if(!empty($static)){
                    $set_color = $_B['setting']['home'][$_B['setting']['global']['mobilethemes']]['info']['color'];
                    if(!empty($set_color['0'])){
                        //读取可替换颜色
                        $defaultColor = $set_color['0'];
                        $defaultColor = (stripos($defaultColor, '|') !== false)?explode('|', $defaultColor):$defaultColor;
                        if(!is_array($defaultColor)){
                            $defaultColor = (array)$defaultColor;
                        }
                        //替换
                        $pattern = array();
                        $replace = array();
                        for($i = 1; $i <= count($defaultColor); $i++){
                            $num = $i-1;
                            if(empty($defaultColor[$num]) || empty($set_color[$i]) || $defaultColor[$num] == $set_color[$i]){
                                continue;
                            }
                            $pattern[] = '/' . $defaultColor[$num] . '/';
                            $replace[] = $set_color[$i];
                        }
                        $static = preg_replace($pattern, $replace, $static);
                    }
                    $need = array(
                        '/\.\.\/\.\.\/\.\.\/\.\.\/\.\.\//'
                    ,'/\.\.\/images\//'
                    );
                    $to = array(
                        '../addons/bowen_site/'
                    ,'../addons/bowen_site/template/mobile/' . $_B['setting']['global']['mobilethemes'] . '/static/images/'
                    );
                    $static = preg_replace($need, $to, $static);
                }
            }
            // 写一个缓存文件
            load()->func('file');
            $_W['config']['setting']['filemode'] = 0755;
            file_write($file_write_static, $static);
            m('cache')->set($cache_key, $setting_updatetime, $_W['uniacid']);
        }else{
            $static = file_get_contents($file_get_static);
        }

        echo $static;
        die;
    }
    */
}