<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
if( !class_exists("ArticleModel") ) 
{
	class smerchantsModel extends PluginModel
	{
	static public $allPerms = array();
	static public $getLogTypes = array();
	static public $formatPerms = array();
	public function getPluginList($merchid = 0) 
	{
		$category = m('plugin')->getList(1);
		$has_plugins = array();
		$perm = com('perm');
		if (p('exhelper') && $perm && $perm->is_perm_plugin('exhelper')) 
		{
			$has_plugins[] = 'exhelper';
		}
		if (p('taobao') && $perm && $perm->is_perm_plugin('taobao')) 
		{
			$has_plugins[] = 'taobao';
		}
		if (p('diypage') && $perm && $perm->is_perm_plugin('diypage')) 
		{
			$has_plugins[] = 'diypage';
		}
		if (p('creditshop') && $perm && $perm->is_perm_plugin('creditshop')) 
		{
			$has_plugins[] = 'creditshop';
		}
		if (p('quick') && $perm && $perm->is_perm_plugin('quick')) 
		{
			$has_plugins[] = 'quick';
		}
		if (!(empty($merchid))) 
		{
			$item = $this->getListUserOne($merchid);
			if (!(empty($item['pluginset']))) 
			{
				$pluginset = iunserializer($item['pluginset']);
			}
		}
		$plugins_list = array();
		$plugins_all = array();
		foreach ($category as $key => $value ) 
		{
			foreach ($value['plugins'] as $k => $v ) 
			{
				$plugins_all[$v['identity']] = $v;
				if (in_array($v['identity'], $has_plugins)) 
				{
					$is_has = 1;
					if (!(empty($pluginset))) 
					{
						if ($pluginset[$v['identity']]['close'] == 1) 
						{
							$is_has = 0;
						}
					}
					if ($is_has) 
					{
						$plugins_list[] = $v;
					}
				}
			}
		}
		$data = array();
		$data['plugins_list'] = $plugins_list;
		$data['plugins_all'] = $plugins_all;
		return $data;
	}


	public function getGroups() 
	{
		global $_W;
		return pdo_fetchall('select id,groupname from ' . tablename('ewei_shop_merch_group') . ' where uniacid=:uniacid and status=1 order by isdefault desc , id asc', array(':uniacid' => $_W['uniacid']), 'id');
	}
 
    }
}
?>
