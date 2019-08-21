<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/8/18 15:12:26] -->
 */
defined('IN_IA') or exit('Access Denied');

class Diy_Model
{
    public function diyStatic($type, $filename){
      global $_W, $_B;
        $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
        $type = in_array($type, array('css', 'js'))?$type:'';
        $filename = (stripos($filename, '/') == false || stripos($filename, '%2f') == false)?trim($filename):'';
        if(empty($type) || empty($filename)){
            exit($this->result(2, '参数错误，缺失重要参数！'));
        }
        $suffix = $type;
        
        $cache_key = 'diyStaticCacheVersion';
        $diyStaticCacheVersion = m('cache')->get($cache_key, $_W['uniacid']);
        $setting_updatetime = m('common')->getModuleSetting($_W['uniacid'], 'setting', 'updatetime');
        
        $file_write_static = FILE_WRITE_M_ROOT.'/data/cache/' . $_W['uniacid'] . '/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;

        /** @var  $file_get_static 缓存文件的绝对路径 */
        $file_get_static = M_DATA . 'cache/' . $_W['uniacid'] . '/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;
        /** @var  $path 原静态文件的绝对路径 */
        $path = M_ROOT . '/template/mobile/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix;
        if(!file_exists($path)){
            $path = M_ROOT . '/template/mobile/default/static/' . $type . '/' . $filename . '.' . $suffix;
        }

        if($diyStaticCacheVersion != $setting_updatetime || !file_exists($file_get_static) || filemtime($path) > filemtime($file_get_static)){
            $static = '';
            if(!file_exists($path))return false;/** 如原静态文件不存在，返回false */
            $static = file_get_contents($path);

            /** 对静态文件进行处理 */
            if(!empty($static)){
                //if($type == 'css'){}
                /** 颜色替换 BEGIN */
                $set_color = $_B['setting']['home'][$_B['setting']['global']['mobilethemes']]['info']['color'];
                if(!empty($set_color['0'])){
                    /** 读取可替换颜色 */
                    $defaultColor = $set_color['0'];
                    $defaultColor = (stripos($defaultColor, '|') !== false)?explode('|', $defaultColor):$defaultColor;
                    if(!is_array($defaultColor)){
                        $defaultColor = (array)$defaultColor;
                    }
                    /** 替换 */
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
                /** 颜色替换 END */

                /** 路径变更 BEGIN */
                $need = array(
                    '/\.\.\/\.\.\/\.\.\/\.\.\/\.\.\//'
                ,'/\.\.\/images\//'
                );
                $to = array(
                    '../../../../../../'
                ,'../../../../../../template/mobile/' . $_B['setting']['global']['mobilethemes'] . '/static/images/'
                );
                $static = preg_replace($need, $to, $static);
                /** 路径变更 END */

                /** 生成静态文件的缓存文件 */
                load()->func('file');
                $_W['config']['setting']['filemode'] = 0755;
                file_write($file_write_static, $static);
                m('cache')->set($cache_key, $setting_updatetime, $_W['uniacid']);
            }

        }
        $path_url = M_URL . 'data/cache/' . $_W['uniacid'] . '/' . $_B['setting']['global']['mobilethemes'] . '/static/' . $type . '/' . $filename . '.' . $suffix . '?v=' . $setting_updatetime . RELEASE;
        return $path_url;
    }
    
    public function result($errno = '0', $message = '', $data = array(), $params = array(), $type = 'exit')
    {
        return result($errno, $message, $data, $params, $type);
    }
    
    public function result_r($errno = '0', $message = '', $data = array(), $params = array()){
        return result_r($errno, $message, $data, $params);
    }
}
