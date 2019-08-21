<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018/11/20 22:12:31] -->
 */
defined('IN_IA') or exit('Access Denied');
 
class Plugin_Model
{
    public $table_plugin = 'bowen_site_plugin';
    /**
	 * 判断是否有插件
	 * @param type $pluginName
	 */
	public function exists($pluginName = '')
	{
		$dbplugin = pdo_fetchall('select * from ' . tablename($this->table_plugin) . ' where name=:name limit  1', array(':name' => $pluginName));

		if (empty($dbplugin)) {
			return false;
		}

		return true;
	}

	/**
	 * 获取所有插件
	 */
	public function getAll($status = "", $rolelevel = "")
	{
		$c = "";
		if ($status !== '') {
			$c .= 'AND status = ' . intval($status);
		}
        
        if ($rolelevel !== '') {
			$c .= 'AND rolelevel = ' . intval($rolelevel);
		}
        $c = ltrim($c, "AND");
        $c = !empty($c)?" WHERE " . $c:"";

        $plugins = m('cache')->get($status.'AllPlugin'.$rolelevel, 0);
        if (empty($plugins)) {
            $plugins = pdo_fetchall('select * from ' . tablename($this->table_plugin) . $c . ' ORDER BY displayorder DESC');
            m('cache')->set($status.'AllPlugin'.$rolelevel, $plugins, 0);
        }
	
		return $plugins;
	}
    
    /**
	 * 强刷所有插件
	 */
    public function refreshCache($status = "", $rolelevel = "")
	{
		$c = "";
		if ($status !== '') {
			$c .= 'AND status = ' . intval($status);
		}
        
        if ($rolelevel !== '') {
			$c .= 'AND rolelevel = ' . intval($rolelevel);
		}
        $c = ltrim($c, "AND");
        $c = !empty($c)?" WHERE " . $c:"";

        $plugins = pdo_fetchall('select * from ' . tablename($this->table_plugin) . $c . ' ORDER BY displayorder DESC');
        m('cache')->set($status.'AllPlugin'.$rolelevel, $plugins, 0);
	
		return $plugins;
	}

	public function getList($status = '', $check_perm = false)
	{
	    global $_W,$_B;
		$list = $this->getCategory();
		$plugins = $this->getAll($status);
		if(!empty($_B['core_settings']['is_open_perm']) && $check_perm){
            $uni_perm = m('common')->getModuleSetting($_W['uniacid'], 'uni_perm');
        }
		foreach ($list as $ck => &$cv) {
			$ps = array();
			foreach ($plugins as $k => $p) {
			    if(!empty($_B['core_settings']['is_open_perm']) && $check_perm && !in_array($p['name'], $uni_perm['plugins'])){
			        unset($plugins[$k]);
			        continue;
                }
				if ($p['category'] == $ck) {
					$ps[] = $p;
                    unset($plugins[$k]);
                    continue;
				}
			}
			$cv['plugins'] = $ps;
		}
		unset($cv);
		return $list;
	}

	public function getName($identity = '')
	{
		$plugins = $this->getAll();

		foreach ($plugins as $p) {
			if ($p['identity'] == $identity) {
				return $p['name'];
			}
		}

		return '';
	}
    
    public function loadModel($pluginname = '')
	{
		static $_model;

		if (!$_model){
			$modelfile = M_PLUGIN . $pluginname . '/core/model.php';

			if (is_file($modelfile)) {
				$classname = ucfirst($pluginname) . 'Model';
				require_once M_INC . 'plugin_model.php';
				require_once $modelfile;
				$_model = new $classname($pluginname);
			}
		}

		return $_model;
	}
    
	public function getCategory()
	{
        return array(
        	'biz'  => array('name' => 'biz', 'title' => '业务类')
        	,'sale' => array('name' => 'sale', 'title' => '营销类')
        	,'tool' => array('name' => 'tool', 'title' => '工具类')
        	,'help' => array('name' => 'help', 'title' => '辅助类')
            ,'sys' => array('name' => 'sys', 'title' => '系统类')
        );
	}

	public function getConfig($pluginname = '')
	{
		if (empty($pluginname)) {
			return false;
		}

		$config_file = M_PLUGIN . $pluginname . '/config.php';

		if (!is_file($config_file)) {
			return false;
		}

		return include $config_file;
	}
}
