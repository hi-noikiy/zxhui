<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/21 15:31:41] -->
 */
defined('IN_IA') or exit('Access Denied');

class PluginWebPage extends WebPage
{
    public $model;
    
    public function __construct()
	{
	   global $_W, $_B;
		parent::__construct();
        
        /** 加载插件定义 **/
        if(file_exists(M_PLUGIN . $_B['current_plugin'] . '/defines.php')){
            require_once M_PLUGIN . $_B['current_plugin'] . '/defines.php';
        }
        
		$this->model = m('plugin')->loadModel($_B['current_plugin']);
        $_B['current_plugin_config'] = m('plugin')->getConfig($_B['current_plugin']);
        $_W['current_plugin_config'] = $_B['current_plugin_config'];
	}
}