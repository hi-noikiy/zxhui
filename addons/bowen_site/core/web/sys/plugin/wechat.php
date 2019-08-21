<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/11/05 11:50:17] -->
 */
defined('IN_IA') or exit('Access Denied');

class Wechat_Page extends SystemPage
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
        $oauth = m('common')->getModuleSetting(0, 'oauth');

        $user_have_accounts = user_borrow_oauth_account_list();
        $oauth_accounts = $user_have_accounts['oauth_accounts'];

        foreach($oauth_accounts as $key => $account){
            $oauth_accounts[$key] = array(
                'uniacid' => $key,
                'title' => $account
            );
        }

        $data = array(
            'oauth_accounts' => $oauth_accounts,
            'account' => $oauth['account'],
            'host' => $oauth['host']
        );
        $this->result(0, 'success', $data);
    }

    public function post()
    {
        global $_GPC;

        $oauthAccount = intval($_GPC['account']);
        $oauthHost = (startsWith($_GPC['host'], 'http') && !endsWith($_GPC['host'], '/'))?trim($_GPC['host']):'';
        $data = array(
            'account' => $oauthAccount,
            'host' => $oauthHost
        );

        if(TEST_SITE){mymessage('测试站禁止操作数据', 'refresh','error');}
        $result = m('common')->saveModuleSetting($data, 0, 'oauth');
        if(!empty($result)){
            $this->result(0,'操作成功', $result);
        }
        $this->result(2,'操作失败，未知错误');
    }
}
