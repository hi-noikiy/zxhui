<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/4 15:52:10] -->
 */
defined('IN_IA') or exit('Access Denied');

class Register_Page extends PluginWebPage
{
    public function __construct()
    {
        global $_W;
        parent::__construct();
        unset($_W['setting']['remote_complete_info'][$_W['uniacid']]);
	}
    
    public function main()
    {
       global $_W,$_GPC;
        load()->model('user');
        load()->model('setting');
        //load()->classs('oauth2/oauth2client');

        $copyright = $this->getCopyright();
        if($copyright){
            $copyright2 = array_filter($copyright['param']);
            $_W['page']['copyright'] = array_merge($_W['page']['copyright'],$copyright2);
        }
        $_W['page']['copyright']['title'] = $_W['page']['copyright']['title']?'用户注册 - '.$_W['page']['copyright']['title']:'用户注册';

        if (empty($_W['setting']['register']['open'])) {
        	mymessage('本站暂未开启注册功能，请联系管理员！', '', 'error');
        }
        
        /** 第三方注册 **/
        $login_urls = user_support_urls();
        $login_urls = $this->myuser_support_urls($login_urls);
        $pcsite_setting = m('common')->getModuleSetting(0, 'pcsite');
        $login_setting = $pcsite_setting['login'];
        $register_setting = $pcsite_setting['register'];
        $copyright_setting = $pcsite_setting['copyright'];
        
        if (empty($register_setting['isopen'])) {
        	mymessage('本站暂未开启注册功能，请联系管理员！', '', 'error');
        }
        
        $_GPC['register_type'] = $_GPC['register_type']?trim($_GPC['register_type']):$register_setting['register_default_type'];
        
        if(!empty($register_setting['register_open_type'])){
            if($register_setting['register_open_type'] == '1'){
                $_GPC['register_type'] = "system";
            }
            if($register_setting['register_open_type'] == '2'){
                $_GPC['register_type'] = "mobile";
            }
        }
        
        $register_type = safe_gpc_belong(safe_gpc_string($_GPC['register_type']), array('system', 'mobile'), 'system');
        if ($register_type == 'system') {
        	$extendfields = OAuth2Client::create($register_type)->systemFields();//用户扩展字段
        } else {
        	$setting_sms_sign = setting_load('site_sms_sign');
        	$register_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';
        }
        
        $owner_uid = intval($_GPC['owner_uid']);
        $table = $_W['current_plugin_config']['table'];
        $domain_value = pdo_fetch("SELECT * FROM " . tablename($table['pcsite_domain']) . " WHERE domain LIKE :domain ORDER BY displayorder DESC, createtime DESC LIMIT 1", array(':domain' => $_SERVER["HTTP_HOST"]));
        if(!empty($domain_value)){
            $owner_uid = $domain_value['owner_uid'];
        }
        
        include $this->mytemplate();
    }
    
    public function register()
    {
       global $_W,$_GPC;
        load()->model('user');
        load()->model('setting');
        load()->classs('oauth2/oauth2client');
        
        /** 验证一下图形验证码，避免机器注册 **/
        $imagecode = $_GPC['__myimagecode'];
        
        if(!empty($_W['setting']['copyright']['verifycode'])){
            if(empty($imagecode)){
                $this->result(-1, '验证码错误或验证码不能为空');
            }
            if($imagecode != $this->en_imagecode(trim($_GPC['imagecode']))){
                $this->result(-1, "你输入的验证码不正确, 请重新输入.");
            }
        }
        
        $register_type = safe_gpc_belong(safe_gpc_string($_GPC['register_type']), array('system', 'mobile'), 'system');
        $owner_uid = intval($_GPC['owner_uid']);
        $login_url = webUrl('pcsite/user/login');
        
        if ($register_type == 'system') {
        	//$extendfields = OAuth2Client::create($register_type)->systemFields();//用户扩展字段
        } else {
        	//$setting_sms_sign = setting_load('site_sms_sign');
        	//$register_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';
        }
        
        if ($register_type == 'mobile') {
        	$validate_mobile = OAuth2Client::create('mobile')->validateMobile();
        	if (is_error($validate_mobile)) {
        		$this->result(-1, $validate_mobile['message']);
        	}
            $this->check_mobile_code();
        }
        
        if($_W['ispost'] && $_W['isajax']) {
            
  		    $register_user = OAuth2Client::create($register_type)->register();
            
      		if ($register_type == 'system') {
 			    if (is_error($register_user)) {
                    $this->result(-1, $register_user['message']);
     			} else {
    				$this->result(0, $register_user['message'], array('re_url' => $login_url));
     			}
      		}

            if ($register_type == 'mobile') {
                if (is_error($register_user)) {
                    $this->result(-1, $register_user['message']);
                } else {
                    $this->result(0, $register_user['message'], array('re_url' => $login_url));
                }
            }
        }
    }
    
    public function valid_mobile()
    {
       global $_W,$_GPC;
        load()->model('user');
        load()->model('setting');
        load()->classs('oauth2/oauth2client');
        
        $setting_sms_sign = setting_load('site_sms_sign');
       	$register_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';
        
        $validate_mobile = OAuth2Client::create('mobile')->validateMobile();
       	if (is_error($validate_mobile)) {
  		    $this->result(-1, $validate_mobile['message']);
       	}
        $this->result(0, '本地校验成功');  
    }
    
    public function check_username()
    {
       global $_W,$_GPC;
        load()->model('user');
        
        $member['username'] = safe_gpc_string($_GPC['username']);
       	if (user_check(array('username' => $member['username']))) {
  		    $this->result(-1, '非常抱歉，此用户名已经被注册，你需要更换注册名称！');
       	} else {
      		$this->result(0, '用户名未被注册');
       	}
        
    }
    
    public function get_extendfields()
    {
       global $_W,$_GPC;
        load()->model('user');
        load()->model('setting');
        load()->classs('oauth2/oauth2client');
       
        $extendfields = OAuth2Client::create($register_type)->systemFields();
  		if (!empty($extendfields)) {
  		    foreach ($extendfields as $field => $value) {
     			$extendfields[$field][$field . '_err'] = false;
     			$extendfields[$field][$field . '_msg'] = '';
      		}
       	}
       	$this->result(0, $extendfields);
    }
    
    public function check_code()
    {
       global $_W,$_GPC;
        load()->model('user');
        
        if (!empty($_W['setting']['register']['code'])) {
  		    if (!checkcaptcha(intval($_GPC['code']))) {
  		        isetcookie('__myimagecode', '', -10000);
 			    $this->result(-1, '你输入的验证码不正确, 请重新输入.');
      		} else {
      		    isetcookie('__myimagecode', $this->en_imagecode($_GPC['code']), 300, true);
     			$this->result(0, '验证码正确');
      		}
       	}
    }
    
    private function check_mobile_code()
    {
       global $_W,$_GPC;
        load()->model('user');
        load()->model('setting');
        load()->classs('oauth2/oauth2client');
        
        $smscode = intval($_GPC['smscode']);
       	$mobile = safe_gpc_string($_GPC['mobile']);
       	$user_table = table('users');
       	$code_info = $user_table->userVerifyCode($mobile, $smscode);
        
       	if (empty($code_info)) {
      		$this->result(-1, '短信验证码不正确');
       	} else if ($code_info['createtime'] + 120 < TIMESTAMP) {
      		$this->result(-1, '短信验证码已过期，请重新获取');
       	} else {
      		//$this->result(0, '短信验证码正确');
       	}
        
    }
    
    /** 图形验证码cookie加密 **/
    private function en_imagecode($code){
       global $_W;
        $value = "{$code}-{$_W['config']['setting']['authkey']}-{$_W['clientip']}";
        return sha1($value);
    }
    
    /** 处理第三方登录链接 */
    private function myuser_support_urls($param){
        global $_W;
        $redirect_uri = $_W['siteroot'] . REDIRECT_URI;
        $param['qq'] = url_set_value($param['qq'], 'redirect_uri', $redirect_uri);
        $param['wechat'] = url_set_value($param['wechat'], 'redirect_uri', $redirect_uri);
        return $param;
    }
}