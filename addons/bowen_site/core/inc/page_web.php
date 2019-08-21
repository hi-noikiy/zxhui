<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/18 09:41:29] -->
 */
defined('IN_IA') or exit('Access Denied');

class WebPage extends Page 
{
    public function __construct($_init = true)
	{
	   global $_W, $_B;
        if($_W['uniacid']){
            if(VERSION == '0.0.1' && !pdo_tableexists($this->table_domain))return $_B['siteroot'] = $_W['siteroot'];
            $cache_key = "webpage_domain";
            $domain = m('cache')->get($cache_key, $_W['uniacid']);
            if(empty($domain)){
                $domain = pdo_fetch("SELECT * FROM ".tablename($this->table_domain)." WHERE uniacid = :uniacid ORDER BY displayorder DESC LIMIT 1", array(':uniacid' => $_W['uniacid']));
                m('cache')->set($cache_key, $domain, $_W['uniacid']);
            }
            $_B['siteroot'] = !empty($domain)?(($domain['domain'] == 'others')?$_W['siteroot']:(!empty($domain['ishttps'])?"https://":"http://").$domain['domain'].'/'):$_W['siteroot'];
            unset($cache_key);
        }
	}
    
    public function getThemes_mobile_config($key = '', $theme = '', $type = 'xml')
    {
        global $_B,$_W;
        if(empty($theme)){
            if(empty($_B['setting'])){
                $_B['setting'] = m('common')->getModuleSetting($_W['uniacid']);
            }
            $theme = $_B['setting']['global']['mobilethemes'];
            if(empty($theme)){
                $theme = 'default';
            }
        }
        if($type == 'xml'){
            $xml = MODULE_ROOT.'/template/mobile/'.$theme.'/t-custom.xml';
            $xml = is_file($xml)?$xml:MODULE_ROOT.'/template/mobile/'.$theme.'/t.xml';
            $xml = is_file($xml)?$xml:MODULE_ROOT.'/template/mobile/default/t.xml';
            $themes = @file_get_contents($xml);
            $themes = xml2array($themes);
            if(empty($themes) || !is_array($themes)){ return false;}
            if(!empty($key)){
                if(!is_array($key)){
                    if($key == 'all'){
                        return $themes;
                    }
                    if(!empty($themes['themes'][$key])){
                        return $themes['themes'][$key];
                    }
                }else{
                    $config = array();
                    foreach($key as $k){
                        $config[$k] = $themes[$k];
                    }
                    return $config;
                }
                return $themes[$key];
            }
            return $themes['themes'];
        }
        elseif($type == 'php'){
            
        }
        return false;
    }
    
    public function getThemes_mobile(){
        $path = MODULE_ROOT . '/template/mobile/';
        $template = (array)$template;
    	if(is_dir($path)) {
    		if ($handle = opendir($path)) {
    			while (false !== ($templatepath = readdir($handle))) {
    				if ($templatepath != '.' && $templatepath != '..') {
    					if(is_dir($path.$templatepath)){
    						$template[] = $templatepath;
    					}
    				}
    			}
    		}
    	}
        return $template;
    }
    
    public function getWebThemes(){
        $path = MODULE_ROOT . '/template/web/';
        $template = (array)$template;
    	if(is_dir($path)) {
    		if ($handle = opendir($path)) {
    			while (false !== ($templatepath = readdir($handle))) {
    				if ($templatepath != '.' && $templatepath != '..') {
    					if(is_dir($path.$templatepath)){
    						$template[] = $templatepath;
    					}
    				}
    			}
    		}
    	}
        return $template;
    }

    public function getCopyright(){
        $domain = $_SERVER["HTTP_HOST"];
        $cache_key = 'sys_copyright_m' . str_replace('.', '_', $domain);
        $copyright = m('cache')->get($cache_key);
        if(empty($copyright)){
            $copyright = pdo_fetch('SELECT  c.content,c.param FROM ' . tablename($this->table_domain) . ' d  ' . ' LEFT JOIN ' . tablename($this->table_sys_copyright) . ' c ON c.value = d.id WHERE c.type = 2 AND d.status=1 AND d.domain="'. $domain . '" ORDER BY displayorder DESC, createtime DESC LIMIT 1');

            if (empty($copyright)) {
                $copyright = pdo_fetch('SELECT content,param FROM ' . tablename($this->table_sys_copyright) . ' WHERE value = 0 AND type = 2 LIMIT 1');
            }

            if (!empty($copyright)) {
                $copyright['content'] = html_entity_decode($copyright['content'], ENT_QUOTES);
                $copyright['param'] = iunserializer($copyright['param']);
            }

            m('cache')->set($cache_key, $copyright);
        }
        return $copyright;
    }
}
