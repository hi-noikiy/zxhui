<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 11:37:49] -->
 */
defined('IN_IA') or exit('Access Denied');

class ComWebPage extends WebPage
{
    public function __construct()
    {
        parent::__construct(false);
        
		mychecklogin();
	}
}
