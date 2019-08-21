<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/23 10:39:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class Base_Page extends WebPage
{
    public function __construct()
    {
        global $_W;
        parent::__construct();
        if(!$_W['isajax'] || !$_W['ispost']){
            $this->result(2, '参数错误，非法访问');
        }
    }

    public function get(){
        global $_W;
        $oauthInfo = table('unisetting')->getOauthByUniacid($_W['uniacid']);
        $oauth = iunserializer($oauthInfo['oauth']) ? iunserializer($oauthInfo['oauth']) : array();
        $jsoauth = $oauthInfo['jsauth_acid'];

        $user_have_accounts = user_borrow_oauth_account_list();
        $oauth_accounts = $user_have_accounts['oauth_accounts'];
        $jsoauth_accounts = $user_have_accounts['jsoauth_accounts'];

        foreach($oauth_accounts as $key => $account){
            $oauth_accounts[$key] = array(
                'uniacid' => $key,
                'title' => $account
            );
        }

        foreach($jsoauth_accounts as $key2 => $jsaccount){
            $jsoauth_accounts[$key2] = array(
                'uniacid' => $key2,
                'title' => $jsaccount
            );
        }

        $data = array(
            'oauth_accounts' => $oauth_accounts,
            'oauthAccount' => $oauth['account'],
            'oauthHost' => $oauth['host'],
            'jsOauthAccounts' => $jsoauth_accounts,
            'jsOauthAccount' => $jsoauth
        );
        $this->result(0, 'success', $data);
    }

    public function post()
    {
        global $_W, $_GPC;

        $oauthAccount = intval($_GPC['oauthAccount']);
        $jsOauthAccount = intval($_GPC['jsOauthAccount']);
        $host = safe_gpc_url(rtrim($_GPC['oauthHost'],'/'), false);
        if (!empty($_GPC['host']) && empty($host)) {
            $this->result(-1, '域名不合法');
        }
        $data = array(
            'host' => $host,
            'account' => $oauthAccount,
        );

        pdo_update('uni_settings', array('jsauth_acid' => $jsOauthAccount, 'oauth' => iserializer($data)), array('uniacid' => $_W['uniacid']));
        cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));

        $this->result(0,'操作成功');
    }
}
