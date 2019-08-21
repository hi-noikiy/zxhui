<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['dingzhi'])) { ?><?php  echo $title['dingzhi'];?><?php  } else { ?>定制开发-<?php  echo $setting['company'];?><?php  } ?></title>
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
    title: "<?php  if(!empty($title['dingzhi'])) { ?><?php  echo $title['dingzhi'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
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
    <div id="banner" class="banner" style="background:url(<?php  if(!empty($banner['dingzhi'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['dingzhi'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_banner.jpg<?php  } ?>) no-repeat center center; background-size:cover;">
    	<div class="wrapper">
        	<div class="jjfa_bantxt">
            	<h2 class="wow fadeInUp"><?php  if(!empty($banner['dingzhititle'])) { ?><?php  echo $banner['dingzhititle'];?><?php  } else { ?>定制开发<?php  } ?><span></span></h2>
                <div class="wow fadeInUp animated delay-2s bannerp">
				<?php  echo $content?>
				</div>
				<h3 class="wow fadeInUp animated delay-5s"><a class="ban_a" href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $setting['qq'];?>&site=qq&menu=yes" target="_blank">了解更多</a></h3>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($setting["title31"])) { ?><?php  echo $setting["title31"];?><?php  } else { ?>我们能为您做什么<?php  } ?></h2><p><?php  if(!empty($setting["title32"])) { ?><?php  echo $setting["title32"];?><?php  } else { ?>we offer products and service<?php  } ?></p></div>
            <div class="dzme_ui">
                <ul>
                    <li class="wow fadeInUp animated delay-1s">
                        <h3><img src="<?php  if($cando['image1']) { ?><?php  echo $_W['attachurl'];?><?php  echo $cando['image1'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_weico1.png<?php  } ?>" /></h3>
                        <h2><?php  if($cando['title1']) { ?><?php  echo $cando['title1'];?><?php  } else { ?>微营销功能开发<?php  } ?></h2>
                        <p><?php  if($cando['miaoshu1']) { ?><?php  echo $cando['miaoshu1'];?><?php  } else { ?>专业定制软件各种软件/分销/电商系统专业程序设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-2s">
                        <h3><img src="<?php  if($cando['image2']) { ?><?php  echo $_W['attachurl'];?><?php  echo $cando['image2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_weico2.png<?php  } ?>" /></h3>
                        <h2><?php  if($cando['title2']) { ?><?php  echo $cando['title2'];?><?php  } else { ?>微商城量身定制<?php  } ?></h2>
                        <p><?php  if($cando['miaoshu2']) { ?><?php  echo $cando['miaoshu2'];?><?php  } else { ?>专业定制软件各种软件/分销/电商系统专业程序设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-3s">
                        <h3><img src="<?php  if($cando['image3']) { ?><?php  echo $_W['attachurl'];?><?php  echo $cando['image3'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_weico3.png<?php  } ?>" /></h3>
                        <h2><?php  if($cando['title3']) { ?><?php  echo $cando['title3'];?><?php  } else { ?>手机APP定制开发<?php  } ?></h2>
                        <p><?php  if($cando['miaoshu3']) { ?><?php  echo $cando['miaoshu3'];?><?php  } else { ?>专业定制软件各种软件/分销/电商系统专业程序设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-4s">
                        <h3><img src="<?php  if($cando['image4']) { ?><?php  echo $_W['attachurl'];?><?php  echo $cando['image4'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_weico4.png<?php  } ?>" /></h3>
                        <h2><?php  if($cando['title4']) { ?><?php  echo $cando['title4'];?><?php  } else { ?>小程序定制开发<?php  } ?></h2>
                        <p><?php  if($cando['miaoshu4']) { ?><?php  echo $cando['miaoshu4'];?><?php  } else { ?>专业定制软件各种软件/分销/电商系统专业程序设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-5s">
                        <h3><img src="<?php  if($cando['image5']) { ?><?php  echo $_W['attachurl'];?><?php  echo $cando['image5'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_weico5.png<?php  } ?>" /></h3>
                        <h2><?php  if($cando['title5']) { ?><?php  echo $cando['title5'];?><?php  } else { ?>高端网站定制<?php  } ?></h2>
                        <p><?php  if($cando['miaoshu5']) { ?><?php  echo $cando['miaoshu5'];?><?php  } else { ?>专业定制软件各种软件/分销/电商系统专业程序设计服务<?php  } ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($setting["title33"])) { ?><?php  echo $setting["title33"];?><?php  } else { ?>我们的优势<?php  } ?></h2><p><?php  if(!empty($setting["title34"])) { ?><?php  echo $setting["title34"];?><?php  } else { ?>our advantage<?php  } ?></p></div>
            <div class="dz_ysui">
                <ul>
                    <li class="wow fadeInUp animated delay-1s">
                        <h3><em></em><span>01</span></h3>
                        <h2><?php  if($youshi['title1']) { ?><?php  echo $youshi['title1'];?><?php  } else { ?>七位一体  整体解决<?php  } ?></h2>
                        <p><?php  if($youshi['miaoshu1']) { ?><?php  echo $youshi['miaoshu1'];?><?php  } else { ?>为企源提供移动终端站略解决方案<br>专业定制IOS/安卓APP软件<br>专业APP设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-2s">
                        <h3><em></em><span>02</span></h3>
                        <h2><?php  if($youshi['title2']) { ?><?php  echo $youshi['title2'];?><?php  } else { ?>专业技术  精品保证<?php  } ?></h2>
                        <p><?php  if($youshi['miaoshu2']) { ?><?php  echo $youshi['miaoshu2'];?><?php  } else { ?>为企源提供移动终端站略解决方案<br>专业定制IOS/安卓APP软件<br>专业APP设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-3s">
                        <h3><em></em><span>03</span></h3>
                        <h2><?php  if($youshi['title3']) { ?><?php  echo $youshi['title3'];?><?php  } else { ?>价格真实  拒绝忽悠<?php  } ?></h2>
                        <p><?php  if($youshi['miaoshu3']) { ?><?php  echo $youshi['miaoshu3'];?><?php  } else { ?>为企源提供移动终端站略解决方案<br>专业定制IOS/安卓APP软件<br>专业APP设计服务<?php  } ?></p>
                    </li>
                    <li class="wow fadeInUp animated delay-4s">
                        <h3><em></em><span>04</span></h3>
                        <h2><?php  if($youshi['title4']) { ?><?php  echo $youshi['title4'];?><?php  } else { ?>客户口碑  价值见证<?php  } ?></h2>
                        <p><?php  if($youshi['miaoshu4']) { ?><?php  echo $youshi['miaoshu4'];?><?php  } else { ?>为企源提供移动终端站略解决方案<br>专业定制IOS/安卓APP软件<br>专业APP设计服务<?php  } ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($setting["title35"])) { ?><?php  echo $setting["title35"];?><?php  } else { ?>定制服务流程<?php  } ?></h2><p><?php  if(!empty($setting["title36"])) { ?><?php  echo $setting["title36"];?><?php  } else { ?>service process<?php  } ?></p></div>
            <div class="dz_lcimg wow fadeInUp"><img src="<?php  if($setting['dzt']) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['dzt'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dz_lcimg.jpg<?php  } ?>"></div>
        </div>
    </div>
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>