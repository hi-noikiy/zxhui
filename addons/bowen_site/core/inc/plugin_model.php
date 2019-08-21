<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @time 20180201
 * @url www.we7pc.com
 * 
 */
defined('IN_IA') or exit('Access Denied');

class PluginModel
{
	private $pluginname;

	public function __construct($name = '')
	{
		$this->pluginname = $name;
	}
}
