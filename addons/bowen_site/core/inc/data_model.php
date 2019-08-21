<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 12:03:47] -->
 */
defined('IN_IA') or exit('Access Denied');

class DataModel
{
	public function read($key = '')
	{
		global $_W,$_GPC;
		return m('cache')->get('data_' . $_W['uniacid'] . '_' . $key);
	}

	public function write($key, $data)
	{
		global $_W,$_GPC;
		m('cache')->set('data_' . $_W['uniacid'] . '_' . $key, $data);
	}
}
