<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 11:37:56] -->
 */
defined('IN_IA') or exit('Access Denied');

class PluginAdminWebPage extends PluginWebPage
{
    public function __construct()
    {
        parent::__construct(false);
		mychecklogin();
	}
}
