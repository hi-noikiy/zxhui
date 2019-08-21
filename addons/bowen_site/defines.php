<?php
/**
 * 企业官网
 * 
 * @author 开吧源码社区
 * @url http://www.kai8.top/
 * <!-- phpDesigner :: Timestamp [2018/7/18 17:58:25] -->
 */
defined('IN_IA') or exit('Access Denied');

define('BOWEN_DEBUG', false);
!(defined('MODULE_NAME')) && define('MODULE_NAME', 'bowen_site');
!(defined('M_ROOT')) && define('M_ROOT', IA_ROOT . '/addons/' . MODULE_NAME);

!(defined('M_CORE')) && define('M_CORE', M_ROOT . '/core/');
!(defined('M_DATA')) && define('M_DATA', M_ROOT . '/data/');
!(defined('M_VENDOR')) && define('M_VENDOR', M_ROOT . '/vendor/');
!(defined('M_PLUGIN')) && define('M_PLUGIN', M_ROOT . '/plugin/');

!(defined('M_CORE_WEB')) && define('M_CORE_WEB', M_CORE . 'web/');
!(defined('M_CORE_MOBILE')) && define('M_CORE_MOBILE', M_CORE . 'mobile/');
!(defined('M_CORE_WEBAPP')) && define('M_CORE_WEBAPP', M_CORE . 'webapp/');
!(defined('M_CORE_SYSTEM')) && define('M_CORE_SYSTEM', M_CORE . 'system/');
!(defined('M_PROCESSOR')) && define('M_PROCESSOR', M_CORE . 'processor/');
!(defined('M_INC')) && define('M_INC', M_CORE . 'inc/');

!(defined('M_URL')) && define('M_URL', $_W['siteroot'] . 'addons/' . MODULE_NAME . '/');
!(defined('M_PLUGIN_URL')) && define('M_PLUGIN_URL', M_URL . '/plugin/');
!(defined('M_TASK_URL')) && define('M_TASK_URL', $_W['siteroot'] . 'addons/' . MODULE_NAME . '/core/task/');
// !(defined('BOWEN_SITE_AUTH_URL')) && define('BOWEN_SITE_AUTH_URL', 'https://cloud.we7pc.com/oauth/');

!(defined('M_LOCAL')) && define('M_LOCAL', '../addons/' . MODULE_NAME . '/');

!(defined('M_STATIC')) && define('M_STATIC', M_LOCAL . 'static/');

!(defined('M_TPL_M')) && define('M_TPL_M', M_LOCAL . 'template/mobile/');
!(defined('M_TPL_W')) && define('M_TPL_W', M_LOCAL . 'template/web/');
!(defined('M_TPL_WA')) && define('M_TPL_WA', M_LOCAL . 'template/webapp/');

!(defined('FILE_WRITE_IA_ROOT')) && define('FILE_WRITE_IA_ROOT', '/..');
!(defined('FILE_WRITE_M_ROOT')) && define('FILE_WRITE_M_ROOT', FILE_WRITE_IA_ROOT . '/addons/' . MODULE_NAME);

!defined('BOWEN_SITE_PREFIX') && define('BOWEN_SITE_PREFIX', MODULE_NAME . '_');