<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/18 17:31:59] -->
 */
define('IN_SYS', true);
require '../../../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';

define('IN_GW', true);
load()->model('user');
load()->model('message');
load()->classs('oauth2/oauth2client');

define('MODULE_NAME', 'bowen_site');
require_once IA_ROOT . '/addons/'.MODULE_NAME.'/defines.php';
require_once M_ROOT.'/version.php';
include_once M_INC . 'functions.php';

if(empty($_GPC['state'])) exit('Access Denied');

$login_callback_params = OAuth2Client::supportParams($_GPC['state']);
if (!empty($login_callback_params)) {
    $controller = 'user';
    $action = 'login';
    $_GPC['login_type'] = $login_callback_params['from'];
    $_GPC['handle_type'] = $login_callback_params['mode'];
}

$referer = 'web/index.php?c=site&a=entry&m=bowen_site&do=web&r=pcsite.account.display';
if (!empty($_W['uniacid']) && !empty($_W['account'])) {
    $permission = permission_account_user_role($_W['uid'], $_W['uniacid']);
    if (!empty($permission)) {
        $referer = 'web/index.php?c=site&a=entry&m=bowen_site&do=web';
    }
}

$login_setting = m('common')->getModuleSetting(0, 'pcsite');
$login_setting = $login_setting['login'];
if(!empty($login_setting['aft_action'])){
    $referer = user_login_forward();
}

$GPC_info = array(
    'code'=>$_GPC['code'],
    'state' =>$_GPC['state'],
    'login_type' => $login_callback_params['from'],
    'handle_type' => $login_callback_params['mode'],
    'referer' => $referer
);
isetcookie('__ispcsite', 'true', !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
$secure = getIsSecureConnection();
$http = (($secure ? 'https' : 'http'));
header('location: ' . $http . '://' . $_SERVER["HTTP_HOST"] . '/web/' . webUrl('pcsite/user/login', $GPC_info, false));
exit();
