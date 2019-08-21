<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/22 22:38:33] -->
 */
defined('IN_IA') or exit('Access Denied');

class PcsiteModel extends PluginModel{
    
    public function user_login_forward($forward = '') {
    	global $_W, $_GPC;
    	$login_forward = trim($forward);
        
    	if (!empty($forward)) {
    		return $login_forward;
    	}

    	/** 不再通过url中的参数直接分配公众号
        if(!empty($_GPC['i'])){
            $uniacid = intval($_GPC['i']);
       	    uni_account_switch($uniacid);
        }*/
        
        $login_forward = webUrl('pcsite/account/display');

        /** 如果存在最后登录de缓存记录 */
    	if (!empty($_W['uniacid']) && !empty($_W['account'])) {
    		$permission = permission_account_user_role($_W['uid'], $_W['uniacid']);
            if (!empty($permission)) {
                if ($_W['account']['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $_W['account']['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH)
                {/** api接入的公众号和授权接入的公众号 */
                    $login_forward = webUrl('pcsite/account/doswitch', array('uniacid' => $_W['uniacid']));
                } elseif ($_W['account']['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL)
                {/** PC */
                    $login_forward = webUrl('pcsite/account/doswitch', array('uniacid' => $_W['uniacid']));
                }
                /** 小程序以及app
                elseif ($_W['account']['type'] == ACCOUNT_TYPE_APP_NORMAL) {
                    $login_forward = url('wxapp/display/home');
                } elseif ($_W['account']['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
                    $login_forward = url('phoneapp/display/home');
                }*/
    		}

    	}
        
        /** 是否执行微擎的跳转 */
        $login_setting = m('common')->getModuleSetting(0, 'pcsite', 'login');
        if(!empty($login_setting['aft_action'])){
            $login_forward = user_login_forward($forward);
        }
        
    	return $login_forward;
    }
    
    public function tpl_fans_form($field, $value = '', $param = array()) {
    	switch ($field) {
    	case 'avatar':
    		$avatar_url = '../attachment/images/global/avatars/';
    		$html = '';
    		if (!defined('TPL_INIT_AVATAR')) {
    			$html .= '
    			<script type="text/javascript">
    				function showAvatarDialog(elm, opts) {
    					require(["util"], function(util){
    						var btn = $(elm);
    						var ipt = btn.parent().prev();
    						var img = ipt.parent().next().children();
    						var content = \'<div class="avatar-browser clearfix">\';
    						for(var i = 1; i <= 12; i++) {
    							content +=
    								\'<div title="头像\' + i + \'" class="thumbnail">\' +
    									\'<em><img src="' . $avatar_url . 'avatar_\' + i + \'.jpg" class="img-responsive"></em>\' +
    								\'</div>\';
    						}
    						content += "</div>";
    						var dialog = util.dialog("请选择头像", content);
    						dialog.modal("show");
    						dialog.find(".thumbnail").on("click", function(){
    							var url = $(this).find("img").attr("src");
    							img.get(0).src = url;
    							ipt.val(url.replace(/^\.\.\/attachment\//, ""));
    							dialog.modal("hide");
    						});
    					});
    				}
    			</script>';
    			define('TPL_INIT_AVATAR', true);
    		}
    		if (!defined('TPL_INIT_IMAGE')) {
    			global $_W;
    			if (defined('IN_MOBILE')) {
    				$html .= <<<EOF
    				<script type="text/javascript">
    					// in mobile
    					function showImageDialog(elm) {
    						require(["jquery", "util"], function($, util){
    							var btn = $(elm);
    							var ipt = btn.parent().prev();
    							var val = ipt.val();
    							var img = ipt.parent().next().children();
    							util.image(elm, function(url){
    								img.get(0).src = url.url;
    								ipt.val(url.attachment);
    							});
    						});
    					}
    				</script>
EOF;
    			} else {
    				$html .= <<<EOF
    				<script type="text/javascript">
    					// in web
    					function showImageDialog(elm, opts) {
    						require(["util"], function(util){
    							var btn = $(elm);
    							var ipt = btn.parent().prev();
    							var val = ipt.val();
    							var img = ipt.parent().next().find('img');
    							util.image(val, function(url){
    								img.get(0).src = url.url;
    								ipt.val(url.attachment);
    							}, {multiple:false,type:"image",direct:true}, opts);
    						});
    					}
    				</script>
EOF;
    			}
    			define('TPL_INIT_IMAGE', true);
    		}
    		$val = './resource/images/nopic.jpg';
    		if (!empty($value)) {
    			$val = tomedia($value);
    		}
    		$options = array();
    		$options['width'] = '200';
    		$options['height'] = '200';
    
    		if (defined('IN_MOBILE')) {
    			$html .= <<<EOF
    			<div class="input-group">
    				<input type="text" value="{$value}" name="{$field}" class="form-control" autocomplete="off">
    				<span class="input-group-btn">
    					<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
    					<button class="btn btn-default" type="button" onclick="showAvatarDialog(this);">系统头像</button>
    				</span>
    			</div>
    			<div class="input-group" style="margin-top:.5em;">
    				<img src="{$val}" class="img-responsive img-thumbnail" width="150" style="max-height: 150px;"/>
    			</div>
EOF;
    		} else {
    			$html .= '
    			<div class="input-group">
    				<input type="text" value="' . $value . '" name="' . $field . '" class="form-control" autocomplete="off">
    				<span class="input-group-btn">
    					<button class="btn btn-default" type="button" onclick="showImageDialog(this, \'' . base64_encode(iserializer($options)) . '\');">选择图片</button>
    					<button class="btn btn-default" type="button" onclick="showAvatarDialog(this);">系统头像</button>
    				</span>
    			</div>
    			<div class="input-group" style="margin-top:.5em;">
    				<img src="' . $val . '" class="img-responsive img-thumbnail" width="150" />
    			</div>';
    		}
    
    		break;
    	case 'birth':
    	case 'birthyear':
    	case 'birthmonth':
    	case 'birthday':
    		$html = tpl_form_field_calendar('birth', $value);
    		break;
    	case 'reside':
    	case 'resideprovince':
    	case 'residecity':
    	case 'residedist':
    		$html = tpl_form_field_district('reside', $value);
    		break;
    	case 'bio':
    	case 'interest':
    		$html = '<textarea name="' . $field . '" class="form-control">' . $value . '</textarea>';
    		break;
    	case 'gender':
    		$html = '
    				<select name="gender" class="form-control">
    					<option value="0" ' . ($value == 0 ? 'selected ' : '') . '>保密</option>
    					<option value="1" ' . ($value == 1 ? 'selected ' : '') . '>男</option>
    					<option value="2" ' . ($value == 2 ? 'selected ' : '') . '>女</option>
    				</select>';
    		break;
    	case 'education':
    	case 'constellation':
    	case 'zodiac':
    	case 'bloodtype':
    		if ($field == 'bloodtype') {
    			$options = array('A', 'B', 'AB', 'O', '其它');
    		} elseif ($field == 'zodiac') {
    			$options = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
    		} elseif ($field == 'constellation') {
    			$options = array('水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座');
    		} elseif ($field == 'education') {
    			$options = array('博士', '硕士', '本科', '专科', '中学', '小学', '其它');
    		}
    		$html = '<select name="' . $field . '" class="form-control">';
    		foreach ($options as $item) {
    			$html .= '<option value="' . $item . '" ' . ($value == $item ? 'selected ' : '') . '>' . $item . '</option>';
    		}
    		$html .= '</select>';
    		break;
    	case 'nickname':
    	case 'realname':
    	case 'address':
    	case 'mobile':
    	case 'qq':
    	case 'msn':
    	case 'email':
    	case 'telephone':
    	case 'taobao':
    	case 'alipay':
    	case 'studentid':
    	case 'grade':
    	case 'graduateschool':
    	case 'idcard':
    	case 'zipcode':
    	case 'site':
    	case 'affectivestatus':
    	case 'lookingfor':
    	case 'nationality':
    	case 'height':
    	case 'weight':
    	case 'company':
    	case 'occupation':
    	case 'position':
    	case 'revenue':
    	default:
            $html = '<input type="text" name="' . $field . '" value="' . $value . '" ' . ($param['required']?'lay-verify="required"':'') . ' placeholder="' . $param['title'] . '" class="layui-input">';
    		break;
    	}
    	return $html;
    }
}
