<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/14 15:58:01] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends WebPage 
{
	public function main() 
	{
	   exit('Access Denied');
	}

	/** 获取mobile目录下的tpl文件 */
    public function tpl_app_setting($fname)
    {
       global $_W,$_GPC;
        $fname = $fname?$fname:safe_gpc_string(trim($_GPC['fname']));
        $is_ajax_tpl = 1;
        $mid = intval($_GPC['mid']);
        include $this->mytemplate('web/tpl/'.$fname, 'mobile');
        exit();
    }

    public function tpl_app_index()
    {
        global $_W,$_GPC;
        $filename = 'index/'.safe_gpc_string(trim($_GPC['fname']));
        $this->tpl_app_setting($filename);
    }
}
