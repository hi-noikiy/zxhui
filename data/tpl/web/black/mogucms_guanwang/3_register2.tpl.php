<?php defined('IN_IA') or exit('Access Denied');?>﻿<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>用户注册</title>
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
});
</script>
</head>
<body>
<form id="form1" method="post" action="">
<dl class="admin_login">
 <dt>
  <strong>用户注册</strong>
 </dt>
 <dd class="regdd">
  <span>用户名：<em>*</em></span><input name="username" id="username" type="text" placeholder="请输入用户名" class="reg_txtbx"/>
 </dd>
 <dd class="regdd">
  <span>密码：<em>*</em></span><input type="password" name="password" id="password" placeholder="请输入不少于8位的密码" class="reg_txtbx"/>
 </dd>
 <dd class="regdd">
  <span>确认密码：<em>*</em></span><input type="password" name="repassword" id="repassword" placeholder="请再次输入不少于8位的密码" class="reg_txtbx"/>
 </dd>
 <?php  if($extendfields) { ?>
 <?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
 <dd class="regdd">
  <span><?php  echo $item['title'];?>：<?php  if($item['required']) { ?><em>*</em><?php  } ?></span><input type="text" placeholder="请输入<?php  echo $item['title'];?>" name="<?php  echo $item['field'];?>" id="<?php  echo $item['field'];?>" class="reg_txtbx regext" <?php  if($item['required']) { ?>required="required"<?php  } ?>/>
 </dd>
 <?php  } } ?>
<?php  } ?>

<?php  if($_W['setting']['register']['code']) { ?>
 <dd class="regdd">
  <span>验证码：<em>*</em></span><input type="text" name="code" id="code" placeholder="请输入验证码" class="reg_yzm"/><a class="regyzmimg" href="javascript:;"><img src="/web/index.php?c=utility&a=code&" id="imgcode" onclick="this.src='/web/index.php?c=utility&a=code&' + Math.random();"></a>
 </dd>
 <?php  } ?>
 <dd class="reg_button">
  <input name="token" value="<?php  echo $_W['token'];?>" type="hidden"/>
  <input name="owner_uid" value="<?php  echo $owner_uid;?>" type="hidden"/>
  <input name="register_type" value="" type="hidden"/>
  <input name="do" value="register" type="hidden"/>
  <input type="button" value="立即注册" class="submit_btn"/>
 </dd>
 <dd><a class="regbtn" href="<?php  echo $this->mogucms_url('login')?>">已有账号 请登录</a></dd>
</dl>
</form>
<script type="text/javascript">
  document.onkeydown = function(e){
        if(e.keyCode === 13){
            formcheck();
        }
    }
  $(function(){
    $(".submit_btn").click(function(){
       var username = $("#username").val();
       var password = $("#password").val();
       var repassword = $("#repassword").val();
       var code = $("#code").val();

        if(username == ''){
            alert("请输入用户名")
            return false
        }
        if(password == '' || password.length<8){
            alert("请输入至少8位密码")
            return false
        }
        if(repassword == '' || repassword.length<8){
            alert("请再次输入至少8位密码")
            return false
        }
        
        if(password !== repassword){
            alert("输入的两次密码不一致，请重新输入")
            return false
        }
        $(".regext").each(function(){
          if(this.required){
            if($(this).val()==""){
              alert(this.placeholder);
              return false
            }
          }
        })
        if(code == ''){
            alert("请输入图形验证码");
            return false
        }
        $.ajax({
            url:"/web/index.php?c=user&a=register",
            type:"POST",
            dataType:'json',
            data:$('#form1').serialize(),
            success: function(data){
				console.log(data);
                alert(data.message);
                var type = data.type;
                if(type=="success"){
                   window.location.href="/";
                }else{
                    var codesrc = "/web/index.php?c=utility&a=code&"+Math.random();
                    $("#imgcode").arrt("src",codesrc);
                }
            }
        });

    });
    $("#username").blur(function(){
        if($("#username").val()==""){
          return;
        }
          $.ajax({
            url:"/web/index.php?c=user&a=register&do=check_username&",
            type:"POST",
            dataType:'json',
            data:"username="+$("#username").val(),
            success: function(data){
                if(data.message.errno!=0){
                  $("#username").val("");
                  if(data.message.message==undefined){
					alert(data.message);
				  }else{
					alert(data.message.message);
				  }
                }
            }
        })
   });
  })



</script>
</body>
</html>
