<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/20 11:14:55] -->
 */
defined('IN_IA') or exit('Access Denied');

class Route_Model{
	public function run($type = 'web')
	{
	   global $_W,$_GPC,$_B;
        $r = str_replace('//', '/', trim($_GPC['r'], '/'));
        $routes = explode('.', $r);
        if(in_array('system', $routes) && in_array('install', $routes)){
            $_B['routes'] = $routes;
            require_once M_CORE_WEB . 'system/install.php';
            $instance = new Install();
            $method = 'main';
            if(!empty($routes[2])){
                $method = $routes[2];
            }
            if (!(method_exists($instance, $method))) {
                result(-1, '控制器 ' . $_W['controller'] . ' 方法 ' . $method . ' 未找到!');
    		}
            $instance->$method();
            exit();
        }
        
        if($type == 'webapp'){
            require_once M_INC . 'page2.php';
        }else{
            require_once M_INC . 'page.php';
        }
        
        /** 后面一个条件和对$type的定义是兼容老版本site.php */
        if ($type == 'webapp') {
			require_once M_INC . 'page_webapp.php';
            $type = 'webapp';
        }elseif($type == 'mobile' || $type == false){
            require_once M_INC . 'page_mobile.php';
            $type = 'mobile';
		}else {
			require_once M_INC . 'page_web.php';
            require_once M_INC . 'page_web_com.php';
            $type = 'web';
            $_W['need_we7res'] = true;
            $_W['nav_left'] = true;
		}
        
		$segs = !empty($r)?count($routes):'0';
		$method = 'main';
        
		switch ($type){
            case 'webapp':
                $root = M_CORE_WEBAPP;
                break;
            case 'mobile':
                $root = M_CORE_MOBILE;
                break;
            default:
                $root = M_CORE_WEB;
        }
        
        $isplugin = !empty($r) && is_dir(M_PLUGIN . $routes[0]);
        
        if ($isplugin) {
			if ($type == 'webapp'){
				require_once M_INC . 'page_webapp_plugin.php';
            }elseif($type == 'mobile'){
                require_once M_INC . 'page_mobile_plugin.php';
			}else{
                require_once M_INC . 'page_web_plugin.php';
                if(file_exists(M_INC . 'page_web_plugin_admin.php')){
                    require_once M_INC . 'page_web_plugin_admin.php';
                }
			}
            
            
            $_W['current_plugin'] = $routes[0];
			$_W['plugin'] = $_W['current_plugin'];
			$root = M_PLUGIN . $routes[0] . '/core/' . $type . '/';
            $routes = array_slice($routes, 1);
			$segs = count($routes);          
		}else{
			if($routes[0] == 'system' || $routes[0] == 'sys'){
				require_once M_INC . 'page_system.php';
			}
		}
        
		switch ($segs) {
		case 0:
			$file = $root . 'index.php';
			$class = 'Index';

		case 1:
			$file = $root . $routes[0] . '.php';

			if (is_file($file)) {
				$class = ucfirst($routes[0]);
			}else if (is_dir($root . $routes[0])) {
				$file = $root . $routes[0] . '/index.php';
				$class = 'Index';
			}else {
				$method = $routes[0];
				$file = $root . 'index.php';
				$class = 'Index';
			}
            
			$_W['action'] = $routes[0];
			break;

		case 2:
			$_W['action'] = $routes[0] . '.' . $routes[1];
			$file = $root . $routes[0] . '/' . $routes[1] . '.php';

			if (is_file($file)) {
				$class = ucfirst($routes[1]);
			}else if (is_dir($root . $routes[0] . '/' . $routes[1])) {
				$file = $root . $routes[0] . '/' . $routes[1] . '/index.php';
				$class = 'Index';
			}else {
				$file = $root . $routes[0] . '.php';

				if (is_file($file)) {
					$method = $routes[1];
					$class = ucfirst($routes[0]);
				}else if (is_dir($root . $routes[0])) {
					$method = $routes[1];
					$file = $root . $routes[0] . '/index.php';
					$class = 'Index';
				}else {
					$file = $root . 'index.php';
					$class = 'Index';
				}
			}

			$_W['action'] = $routes[0] . '.' . $routes[1];
			break;

		case 3:
			$_W['action'] = $routes[0] . '.' . $routes[1] . '.' . $routes[2];
			$file = $root . $routes[0] . '/' . $routes[1] . '/' . $routes[2] . '.php';

			if (is_file($file)) {
				$class = ucfirst($routes[2]);
			}else if (is_dir($root . $routes[0] . '/' . $routes[1] . '/' . $routes[2])) {
				$file = $root . $routes[0] . '/' . $routes[1] . '/' . $routes[2] . '/index.php';
				$class = 'Index';
			}else {
				$method = $routes[2];
				$file = $root . $routes[0] . '/' . $routes[1] . '.php';

				if (is_file($file)) {
					$class = ucfirst($routes[1]);
				}else if (is_dir($root . $routes[0] . '/' . $routes[1])) {
					$file = $root . $routes[0] . '/' . $routes[1] . '/index.php';
					$class = 'Index';
				}
				$_W['action'] = $routes[0] . '.' . $routes[1];
			}
			break;

		case 4:
			$_W['action'] = $routes[0] . '.' . $routes[1] . '.' . $routes[2];
			$method = $routes[3];
			$class = ucfirst($routes[2]);
			$file = $root . $routes[0] . '/' . $routes[1] . '/' . $routes[2] . '.php';
			break;
		}

		if (!(is_file($file))) {
            result(-1,'未找到控制器 ' . $r);
		}
        
        /** 加载配置文件 **/
        $_B['config'] = '';
        $configfile = M_DATA . 'config.php'; 
        if(file_exists($configfile)){
            require $configfile;
            $_B['config'] = $config;
        }
        if(!empty($_B['config']['setting']['test_site']) && $_W['role'] != ACCOUNT_MANAGE_NAME_FOUNDER){
            define('TEST_SITE', true);
        }else{
            define('TEST_SITE', false);
        }
        
		$_W['routes'] = $r;
        $_W['routes_array'] = $routes;
        $_W['isplugin'] = $isplugin;
		$_W['controller'] = $routes[0];
        $_W['type_is_'] = $type;
        $_W['core_settings'] = m('common')->getModuleSetting(0, 'core', 'core_settings');
        
        $_B['action'] = $_W['action'];
        $_B['controller'] = $_W['controller'];
        $_B['routes'] = $_W['routes'];
        $_B['routes_array'] = $_W['routes_array'];
        $_B['isplugin'] = $_W['isplugin'];
        $_B['current_plugin'] = !empty($_W['current_plugin'])?$_W['current_plugin']:'';
        $_B['action_type'] = $_W['type_is_'];
        $_B['core_settings'] = $_W['core_settings'];
        $_B['core_settings']['webtheme'] = empty($_B['core_settings']['webtheme'])?'default':$_B['core_settings']['webtheme'];
        if($_B['action_type'] == 'web' && !is_dir(MODULE_ROOT . '/template/web/'.$_B['core_settings']['webtheme'])){
            $_B['core_settings']['webtheme'] = 'default';
        }
        
		include $file;
        $class = ucfirst($class) . '_Page';
		$instance = new $class();

		if (!(method_exists($instance, $method))) {
            result(-1, '控制器 ' . $_W['controller'] . ' 方法 ' . $method . ' 未找到!');
		}
        $instance->$method();
		exit();
	}
}
