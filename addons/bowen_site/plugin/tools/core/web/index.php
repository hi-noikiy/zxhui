<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 22:43:28] -->
 */
defined('IN_IA') or exit('Access Denied');

class Index_Page extends PluginWebPage
{
    public function main()
    {
       global $_W, $_GPC;
        itoast('', webUrl('tools/base/info'));
    }
}