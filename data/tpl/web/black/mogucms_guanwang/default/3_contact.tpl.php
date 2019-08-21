<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['contact'])) { ?><?php  echo $title['contact'];?><?php  } else { ?>联系我们-<?php  echo $setting['company'];?><?php  } ?></title>
<meta name="keywords" content="<?php  echo $setting['keywords'];?>" />
<meta name="description" content="<?php  echo $setting['description'];?>" />
<?php  if(!empty($setting['icon'])) { ?>
<link rel="shortcut icon" href="<?php  echo $_W['attachurl'];?><?php  echo $setting['icon'];?>" />
<?php  } ?>
<meta name="format-detection" content="telephone=no"/>
<meta content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<link href="../addons/mogucms_guanwang/template/style/css/common.css" type="text/css" rel="stylesheet">
<link href="../addons/mogucms_guanwang/template/style/css/style.css" type="text/css" rel="stylesheet">
<script src="../addons/mogucms_guanwang/template/style/js/jquery.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/wow.min.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/jquery.lazyload.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/comloding.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/common.js"></script>
<!--[if lt IE 9]>
<script src="../addons/mogucms_guanwang/template/style/js/html5.js"></script>
<![endif]-->
<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
  wx.config({
	  debug: false,
      appId: "<?php  echo $jssdk['appId'];?>",
      timestamp: "<?php  echo $jssdk['timestamp'];?>",
      nonceStr: "<?php  echo $jssdk['nonceStr'];?>",
      signature: "<?php  echo $jssdk['signature'];?>",
      jsApiList: [
		'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage'
      ]
  });
  wx.ready(function () {
  
    var shareData = {
    title: "<?php  if(!empty($title['contact'])) { ?><?php  echo $title['contact'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
    desc: "<?php  echo $setting['keywords'];?>",
    link: "<?php  echo $jssdk['url'];?>",
    imgUrl: "<?php  if($setting['logo2']) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['logo2'];?><?php  } else if($fdset['logo2']) { ?><?php  echo $_W['attachurl'];?><?php  echo $fdset['logo2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/logo2.png<?php  } ?>",
  };
 
  wx.onMenuShareAppMessage({
      title: shareData.title,
      desc: shareData.desc,
      link: shareData.link,
      imgUrl:shareData.imgUrl,
      success: function (res) {
      }
    });
  wx.onMenuShareTimeline({
      title: shareData.title+"---"+shareData.desc,
      link: shareData.link,
      imgUrl:shareData.imgUrl,
      success: function (res) {
      }
    }); 
  });
</script>
</head>
<?php  if(!empty($setting['shangqiao']) && $setting['isshangqiao']=="1") { ?><?php  echo html_entity_decode($setting['shangqiao'])?><?php  } ?>
<body>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/header', TEMPLATE_INCLUDEPATH)) : (include template('default/header', TEMPLATE_INCLUDEPATH));?>
<div class="container">
    <div id="banner" class="banner"><img src="<?php  if(!empty($banner['contact'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['contact'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/contact_banner.jpg<?php  } ?>" /></div>
    <div class="content">
        <div class="wrapper">
        	<div class="contact_fl wow fadeInUp">
            	<h1 style="font-size:28px; font-weight:bold; line-height:40px;"><?php  echo $setting["company"];?></h1>
                <p><a style="color:#108bec; font-size:18px;" href="http://<?php  echo $setting['domain'];?>" target="_blank"><?php  echo $setting["domain"];?></a></p>
                <div class="contact_tel"><h2><?php  echo $setting["dianhua"];?></h2><p>Phone:<?php  echo $setting["shouji"];?>&nbsp;&nbsp;QQ:<?php  echo $setting["qq"];?></p></div>
                <h3 style="font-size:24px; line-height:30px; margin-top:20px;"><?php  echo $setting["email"];?></h3>
                <div class="contact_dz">
                	<h2><?php  echo $setting["dizhi"];?></h2>
                    <p><?php  echo $setting["luxian"];?></p>
                </div>
                <div style="margin-top:20px; float:left;"><h2><img src="<?php  if(!empty($setting['erweima'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['erweima'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/foot_ewm.png<?php  } ?>" style="max-width:130px;"/></h2><p class="tac">扫一扫 关注我</p></div>
            </div>
            <div class="contact_map wow fadeInUp"><?php  if(!empty($setting['ditu'])) { ?><?php  echo html_entity_decode($setting['ditu'])?><?php  } else { ?><img src="../addons/mogucms_guanwang/template/style/images/map.jpg" /><?php  } ?></div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>