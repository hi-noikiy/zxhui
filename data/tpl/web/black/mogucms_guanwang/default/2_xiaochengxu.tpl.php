<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['xiaochengxu'])) { ?><?php  echo $title['xiaochengxu'];?><?php  } else { ?>小程序-<?php  echo $setting['company'];?><?php  } ?></title>
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
    title: "<?php  if(!empty($title['xiaochengxu'])) { ?><?php  echo $title['xiaochengxu'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
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
    <div id="banner" class="banner" style="background:url(<?php  if(!empty($banner['xiaochengxu'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['xiaochengxu'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/xiaochengxu_banner.jpg<?php  } ?>) no-repeat center center; background-size:cover;">
    	<div class="wrapper">
        	<div class="jjfa_bantxt">
            	<h2 class="wow fadeInUp"><?php  if(!empty($banner['xiaochengxutitle'])) { ?><?php  echo $banner['xiaochengxutitle'];?><?php  } else { ?>微信小程序<?php  } ?><span></span></h2>
                <div class="wow fadeInUp animated delay-2s bannerp">
				<?php  echo $content?>
				</div>
				<h3 class="wow fadeInUp animated delay-5s"><a class="ban_a" href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $setting['qq'];?>&site=qq&menu=yes" target="_blank">快速创建</a></h3>
            </div>
        </div>
    </div>
    <div class="content bgf9">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($setting["titlexcxrk"])) { ?><?php  echo $setting["titlexcxrk"];?><?php  } else { ?>小程序入口<?php  } ?></h2><p><?php  if(!empty($setting["titlexcxrken"])) { ?><?php  echo $setting["titlexcxrken"];?><?php  } else { ?>MINI-CODE PRESENTATION<?php  } ?></p></div>
            <div class="xcx_xwbox">
            	<ul>
					<?php  if(is_array($rukous)) { foreach($rukous as $rk) { ?>
                	<li class="wow fadeInUp"><h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $rk['image'];?>" /></h3><h2><?php  echo $rk['title'];?></h2><p><?php  echo $rk['abstract'];?></p></li>
                	<?php  } } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><a name="cate"><?php  if(!empty($setting["titlebfanzs"])) { ?><?php  echo $setting["titlebfanzs"];?><?php  } else { ?>部分案例展示<?php  } ?></a></h2><p><?php  if(!empty($setting["titlebfanzsen"])) { ?><?php  echo $setting["titlebfanzsen"];?><?php  } else { ?>MINI-CODE PRESENTATION<?php  } ?></p></div>
            <div class="icase_menu"><a <?php  if($cid==0) { ?>class="active"<?php  } ?> href="<?php  echo $this->mogucms_url('xiaochengxu')?>">全部</a><?php  if(is_array($categorys)) { foreach($categorys as $c) { ?><a href="<?php  echo $this->mogucms_url('xiaochengxu',array('cid'=>$c['id'].'#cate'))?>" <?php  if($cid==$c['id']) { ?>class="active"<?php  } ?>><?php  echo $c['categoryname'];?></a><?php  } } ?></div>
            <div class="icase_ui">
                <ul>
					<?php  if(is_array($cases)) { foreach($cases as $case) { ?>
                    <li class="wow fadeInUp">
						<?php  if(!empty($case['myurl'])) { ?>
                        <a href="<?php  echo $case['myurl'];?>" target="_blank"><h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $case['image'];?>" /><?php  if(!empty($case['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $case['erweima'];?>" /></span><?php  } ?></h3></a>
                        <p><a href="<?php  echo $case['myurl'];?>" target="_blank"><?php  echo $case['title'];?></a></p>
						<?php  } else { ?>
						<h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $case['image'];?>" /><?php  if(!empty($case['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $case['erweima'];?>" /></span><?php  } ?></h3>
                        <p><?php  echo $case['title'];?></p>
						<?php  } ?>
                    </li>
                    <?php  } } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($setting["titlesykh"])) { ?><?php  echo $setting["titlesykh"];?><?php  } else { ?>适用客户<?php  } ?></h2><p><?php  if(!empty($setting["titlesykhen"])) { ?><?php  echo $setting["titlesykhen"];?><?php  } else { ?>SUITABLE USERS<?php  } ?></p></div>
            <div class="xcx_sykhbox">
            	<ul>
					<?php  if(is_array($customers)) { foreach($customers as $cm) { ?>
                	<li class="wow fadeInUp"><h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $cm['image'];?>" /></h3><p><?php  echo $cm['title'];?></p></li>
					<?php  } } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>