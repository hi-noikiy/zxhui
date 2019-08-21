<?php defined('IN_IA') or exit('Access Denied');?>﻿<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8"/>
<title><?php  if(!empty($setting['title'])) { ?><?php  echo $setting['title'];?><?php  } else { ?>后台登录<?php  } ?></title>
<meta name="keywords" content="<?php  echo $_W['page']['copyright']['keywords'];?>" />
<meta name="description" content="<?php  echo $_W['page']['copyright']['description'];?>" />
<link rel="shortcut icon" href="<?php  if(!empty($_W['setting']['copyright']['icon'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $_W['setting']['copyright']['icon'];?><?php  } else { ?>./resource/images/favicon.ico<?php  } ?>" />
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="../addons/mogucms_guanwang/template/loginstyle2/css/style.css" tppabs="../addons/mogucms_guanwang/template/loginstyle2/css/style.css" />
<style>
body{height:100%;background:#166fa0;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="../addons/mogucms_guanwang/template/loginstyle2/js/jquery.js"></script>
<script src="../addons/mogucms_guanwang/template/loginstyle2/js/Particleground.js" tppabs="../addons/mogucms_guanwang/template/loginstyle2/js/Particleground.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5c9bbd',
    lineColor: '#5c9bbd'
  });
  
  //测试提交，对接程序删除即可
  $(".submit_btn").click(function(){
	  //location.href="javascrpt:;"
	  });
});
</script>
</head>
<body>
<form method="post"  id="form1" class="we7-form">
<dl class="admin_login">
 <dt>
  <strong><?php  if(!empty($setting['zhongwen'])) { ?><?php  echo $setting['zhongwen'];?><?php  } else { ?>站点后台管理系统<?php  } ?></strong>
  <em><?php  if(!empty($setting['yingwen'])) { ?><?php  echo $setting['yingwen'];?><?php  } else { ?>Management System<?php  } ?></em>
 </dt>
 <dd class="user_icon">
  <input type="text" name="username" id="username"  placeholder="账号" class="login_txtbx"/>
 </dd>
 <dd class="pwd_icon">
  <input name="password" id="password" type="password" placeholder="密码" class="login_txtbx"/>
 </dd>
 <?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
 <dd class="yzml_icon">
  <input name="verify" id="verify" type="text" placeholder="验证码" class="login_yzm"/>
  <a class="logyzmimg" href="javascript:;"><img src="/web/index.php?c=utility&a=code&" id="imgcode" onclick="this.src='/web/index.php?c=utility&a=code&' + Math.random();"></a>
 </dd>
 <?php  } ?>
 <dd class="val_icon">
  	<input type="checkbox" class="checkbox" id="rember" name="rember" value="true">记住用户名
 	<a href="/web/index.php?c=user&a=find-password">忘记密码？</a>
 </dd>
 <dd>
  <input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
  <input name="login_type" id="login_type" type="hidden" class="form-control " value="system">
  <input type="button" value="立即登陆" class="submit_btn" onclick="return formcheck();" />
 </dd>
 <?php  if($setting['iszhuche'] != "1") { ?>
 <dd><a class="regbtn" href="<?php  echo $this->mogucms_url('register')?>">立即注册</a></dd>
 <?php  } ?>
 <?php  if($isfounder == 1) { ?>
 <?php  if(!empty($_W['setting']['thirdlogin']['qq']['authstate']) || !empty($_W['setting']['thirdlogin']['wechat']['authstate'])) { ?>
         <dd class="tac">使用第三方账号登录</dd>
         <dd class="linklogin"><?php  if(!empty($_W['setting']['thirdlogin']['qq']['authstate'])) { ?><a href="<?php  echo $login_urls['qq'];?>"><img src="../addons/mogucms_guanwang/template/loginstyle1/qqlogin.png"></a><?php  } ?><?php  if(!empty($_W['setting']['thirdlogin']['wechat']['authstate'])) { ?><a href="<?php  echo $login_urls['wechat'];?>"><img src="../addons/mogucms_guanwang/template/loginstyle1/wxlogin.png"></a><?php  } ?></dd>
         <?php  } ?>
         <?php  } ?>
</dl>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer-base', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-base', TEMPLATE_INCLUDEPATH));?>
<script>
document.onkeydown = function(e){
	if(e.keyCode === 13){
		formcheck();
	}
}
function formcheck(){
          var username = $("#username").val();
          var str = /^[1][3,4,5,7,8][0-9]{9}$///手机
          if(username == ''){
            alert("请输入帐号")
            return false
          }
          /*if(str.test(username)){
              $("#login_type").val("mobile");
          }else{
              $("#login_type").val("system");
          }*/
          $.ajax({
              url:"/web/index.php?c=user&a=login",
              type:"POST",
              dataType:'json',
              data:$('#form1').serialize(),
              success: function(data){
                 var url = data.redirect;
                 if(url){
                     if(url.indexOf("user") != -1){
						 alert(data.message);
						 $("#imgcode").attr("src","/web/index.php?c=utility&a=code&" + Math.random());
					 }else{
						url = url.replace(".","");
						window.location.href="/web"+url;
					 }
                 }else{
					alert(data.message);
				 }
              }
          });
          return false;
      }
</script>
</body>
</html>
