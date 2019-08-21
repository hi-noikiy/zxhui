<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 16:38:23] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{
    public function main()
    {
        itoast('', webUrl('database/base/info'));
    }
}