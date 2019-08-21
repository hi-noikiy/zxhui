<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:42:53] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginAdminWebPage
{
    public function main()
    {
        itoast('', webUrl('diyform/base/info'));
    }
}