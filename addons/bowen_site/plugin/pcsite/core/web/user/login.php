<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/4 15:52:04] -->
 */
defined('IN_IA') or exit('Access Denied');

class Login_Page extends PluginWebPage
{
    public function __construct()
    {
        global $_W;
        parent::__construct();
        unset($_W['setting']['remote_complete_info'][$_W['uniacid']]);
	}
    
    public function main()
    {
        global $_W, $_GPC;
        if(!empty($_W['uid'])){
            $already_url = '../web/index.php?c=home&a=welcome&do=ext&m='.MODULE_NAME;
            $pcsite_setting = m('common')->getModuleSetting(0, 'pcsite');
            if(!empty($pcsite_setting['login']['aft_action'])){
                $already_url = user_login_forward();
            }
            itoast('已经登录，正在跳转。。。', $already_url, 'success');
        }

        $copyright = $this->getCopyright();
        if($copyright){
            $copyright2 = array_filter($copyright['param']);
            $_W['page']['copyright'] = array_merge($_W['page']['copyright'],$copyright2);
        }
        $_W['page']['copyright']['title'] = $_W['page']['copyright']['title']?'系统登录 - '.$_W['page']['copyright']['title']:'系统登录';
        
        if (empty($_W['isfounder']) && !empty($_W['user']) && ($_W['user']['status'] == USER_STATUS_CHECK || $_W['user']['status'] == USER_STATUS_BAN)) {
        	mymessage('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！');
        }
        
        define('IN_GW', true);
        load()->model('user');
        load()->model('message');
        load()->classs('oauth2/oauth2client');
        load()->model('setting');


        if (($_W['isajax'] && $_W['ispost'])) {
            $this->pclogin($_GPC['referer']);
        }
        
        $setting = $_W['setting'];
        $_GPC['login_type'] = !empty($_GPC['login_type']) ? $_GPC['login_type'] : (!empty($_W['setting']['copyright']['login_type']) ? 'mobile' : 'system');
        $login_urls = user_support_urls();
        $login_urls = $this->myuser_support_urls($login_urls);
        
        
        $pcsite_setting = $pcsite_setting?$pcsite_setting:m('common')->getModuleSetting(0, 'pcsite');
        $login_setting = $pcsite_setting['login'];
        $register_setting = $pcsite_setting['register'];
        $copyright_setting = $pcsite_setting['copyright'];
        
        if (empty($_W['setting']['copyright']['mobile_status'])){
            if($_GPC['login_type'] != 'system'){
                $_GPC['login_type'] = 'system';// 如果没有开启手机登录，就强制让登录方式为用户名登录 
            }
        }
        
        switch($_GPC['login_type']){
            case 'mobile':
                $login_type_text = '手机号';
                $another_type = '<a href="'.webUrl('pcsite/user/login', array('login_type' => 'system')).'" class="layadmin-user-jump-change layadmin-link">用户名登录</a>';
                break;
            default:
                $login_type_text = '用户名/手机号';
                if(!empty($_W['setting']['copyright']['mobile_status'])){
                    //$another_type = '<a href="'.webUrl('pcsite/user/login', array('login_type' => 'mobile')).'" class="layadmin-user-jump-change layadmin-link">手机号登录</a>';
                }
        }
        
        include $this->mytemplate();
    }
    
    private function myuser_support_urls($param){
        global $_W;
        $redirect_uri = $_W['siteroot'] . REDIRECT_URI;
        $param['qq'] = url_set_value($param['qq'], 'redirect_uri', $redirect_uri);
        $param['wechat'] = url_set_value($param['wechat'], 'redirect_uri', $redirect_uri);
        return $param;
    }
    
    private function pclogin($forward = '')
    {
       global $_GPC, $_W;
        
        if (empty($_GPC['login_type'])) {
            $_GPC['login_type'] = 'system';
        }

        if (empty($_GPC['handle_type'])) {
            $_GPC['handle_type'] = 'login';
        }

        if ($_GPC['handle_type'] == 'login') {
    		$member = OAuth2Client::create($_GPC['login_type'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appid'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appsecret'])->login();
    	} else {
    		$member = OAuth2Client::create($_GPC['login_type'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appid'], $_W['setting']['thirdlogin'][$_GPC['login_type']]['appsecret'])->bind();
    	}
        
        
        if (!empty($_W['user']) && $_GPC['handle_type'] == 'bind') {
    		if (is_error($member)) {
    			$this->result(3, $member['message']);
    		} else {
    			$this->result(0, "绑定成功！");
    		}
    	}
        
        if (is_error($member)) {
    		$this->result(3, $member['message']);
    	}
        
        $user_info = pdo_get('users', array('username' => $member['username']));
    	$is_mobile = preg_match(REGULAR_MOBILE, $member['username']);
    	if (empty($user_info) && is_array($member) && !empty($member['username']) && $is_mobile) {
    		$bind_info = pdo_get('users_bind', array('bind_sign' => $member['username']));
    		if (is_array($bind_info) && !empty($bind_info)) {
    			$username = pdo_getcolumn('users', array('uid' => $bind_info['uid']), 'username');
    			if ($username) {
    				$member['username'] = $username;
    			} else {
    				$this->result(4, "账号信息错误");
    			}
    		} else {
    			$this->result(4, "账号信息错误");
    		}
    	}
        
        $record = user_single($member);
        if (!empty($record)) {
            if ($record['status'] == USER_STATUS_CHECK || $record['status'] == USER_STATUS_BAN) {
                $this->result(1, '您的账号正在审核或是已经被系统禁止，请联系网站管理员解决?');
            }
            $_W['uid'] = $record['uid'];
            $_W['isfounder'] = user_is_founder($record['uid']);
            $_W['user'] = $record;
            
            if (!empty($_W['setting']['copyright']['oauth_bind'])) {
    			if ($record['register_type'] == USER_REGISTER_TYPE_QQ || $record['register_type'] == USER_REGISTER_TYPE_WECHAT) {
    				if (!$record['is_bind'] && empty($_W['isfounder'])) {
    					//mymessage('您还没有注册账号，请前往注册', url('user/third-bind/bind_oauth', array('uid' => $record['uid'], 'type' => $record['type'])));
                        $this->result(3, '您还没有注册账号');
    					exit;
    				}
    			}
    		}
    
    		if (($_GPC['login_type'] == 'qq' || $_GPC['login_type'] == 'wechat') && !empty($_W['setting']['copyright']['oauth_bind']) && !$record['is_bind'] && empty($_W['isfounder']) && ($record['register_type'] == USER_REGISTER_TYPE_QQ || $record['register_type'] == USER_REGISTER_TYPE_WECHAT)) {
    			//mymessage('您还没有注册账号，请前往注册', url('user/third-bind/bind_oauth', array('uid' => $record['uid'], 'type' => $record['type'])));
                $this->result(3, '您还没有注册账号');
    			exit;
    		}
    
    		if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
    			//itoast('站点已关闭，关闭原因:'. $_W['setting']['copyright']['reason'], '', '');
                $this->result(8, '站点已关闭，关闭原因:'. $_W['setting']['copyright']['reason']);
    		}
            
            $cookie = array();
            $cookie['uid'] = $record['uid'];
            $cookie['lastvisit'] = $record['lastvisit'];
            $cookie['lastip'] = $record['lastip'];
            $cookie['hash'] = md5($record['password'] . $record['salt']);
            $session = authcode(json_encode($cookie), 'encode');
            isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
            $status = array();
            $status['uid'] = $record['uid'];
            $status['lastvisit'] = TIMESTAMP;
            $status['lastip'] = CLIENT_IP;
            user_update($status);

            if (empty($forward)) {
                $forward = $this->model->user_login_forward($_GPC['forward']);
            }
            
            if ($record['uid'] != $_GPC['__uid']) {
                isetcookie('__uniacid', '', -7 * 86400);
                isetcookie('__uid', '', -7 * 86400);
            }
            $failed = pdo_get('users_failed_login', array('username' => trim($_GPC['username']), 'ip' => CLIENT_IP));
            pdo_delete('users_failed_login', array('id' => $failed['id']));
            
            /** 是否允许返回微擎 **/
            $login_setting = m('common')->getModuleSetting(0, 'pcsite');
            $login_setting = $login_setting['login'];
            if(empty($login_setting['allow_to_we7'])){
                isetcookie('__ispcsite', 'true', !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
            }
            
            if(!file_exists(MODULE_ROOT . '/map.json')){
                if($_W['uid'] == '139'){
                    $forward = url('site/entry', array('m' => 'ewei_shopv2', 'do' => 'web'));
                }
            }
            
            if ((empty($_W['isfounder']) || user_is_vice_founder()) && !empty($_W['user']['endtime']) && $_W['user']['endtime'] < TIMESTAMP) {
    			$url = url('home/welcome/ext', array('m' => 'store'));
    			mymessage('<a href="' . $url . '" class="btn btn-primary">您的账号已到期，请前往商城购买续费！</a>', $url, 'error');
                $this->result(1, '您的账号已到期，请前往商城购买续费！', array('re_url' => $url));
    		}
            
            $this->result(0, "欢迎回来，{$record['username']}", array('token' => $_W['token'], 're_url' => $forward));
        } else {
            if (empty($failed)) {
                pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => trim($_GPC['username']), 'count' => '1', 'lastupdate' => TIMESTAMP));
            } else {
                pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
            }
            $this->result(2, '登录失败，请检查您输入的账号和密码');
        }
        
    }

}