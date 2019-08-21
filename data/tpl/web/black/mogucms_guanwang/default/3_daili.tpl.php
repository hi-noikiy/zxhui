<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['daili'])) { ?><?php  echo $title['daili'];?><?php  } else { ?>代理加盟-<?php  echo $setting['company'];?><?php  } ?></title>
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
    title: "<?php  if(!empty($title['daili'])) { ?><?php  echo $title['daili'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
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
    <div id="banner" class="banner" style="background:url(<?php  if(!empty($banner['daili'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['daili'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/xiaochengxu_banner.jpg<?php  } ?>) no-repeat center center; background-size:cover;">
    	<div class="wrapper">
        	<div class="jjfa_bantxt">
            	<h2 class="wow fadeInUp"><?php  if(!empty($banner['dailititle'])) { ?><?php  echo $banner['dailititle'];?><?php  } else { ?>代理加盟<?php  } ?><span></span></h2>
                 <div class="wow fadeInUp animated delay-2s bannerp">
				<?php  echo $content?>
				</div>
				<h3 class="wow fadeInUp animated delay-5s"><a class="ban_a" href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $setting['qq'];?>&site=qq&menu=yes" target="_blank">申请成为代理商</a></h3>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($daili["title1"])) { ?><?php  echo $daili["title1"];?><?php  } else { ?>市场分析<?php  } ?></h2><p><?php  if(!empty($daili["title2"])) { ?><?php  echo $daili["title2"];?><?php  } else { ?>MARKET ANALYSIS<?php  } ?></p></div>
            <div class="scfx_txt wow fadeInUp"><?php  if(!empty($title3)) { ?><?php  echo $title3;?><?php  } else { ?>2017年1月9日微信小程序正式上线，引发各界关注，千亿市场马上到来。<br>
腾讯公布了2017年全年业绩，腾讯全年收入2377.60亿元！<br>
微信活跃用户近10亿，日均活跃账号7.68亿，娱乐。购物。公众号所占微信收入比例高达90%。<br>
腾讯几乎影响了中国所有网民，巨大的用户基数是微信小程序发展的根基与前景。<?php  } ?>
</div>
        </div>
    </div>
    <div class="content bgf9">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($daili["title4"])) { ?><?php  echo $daili["title4"];?><?php  } else { ?>合作，你能获得什么？<?php  } ?></h2><p><?php  if(!empty($daili["title5"])) { ?><?php  echo $daili["title5"];?><?php  } else { ?>WHAT TO GAIN<?php  } ?></p></div>
            <div class="xcxdl_box">
            	<ul>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title6'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title6'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico1.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title7"])) { ?><?php  echo $daili["title7"];?><?php  } else { ?>平台支持<?php  } ?></h2><p><?php  if(!empty($daili["title8"])) { ?><?php  echo $daili["title8"];?><?php  } else { ?>OEM贴牌式/赠送整套系统权限/独立合伙人系统<?php  } ?></p></li>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title9'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title9'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico2.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title10"])) { ?><?php  echo $daili["title10"];?><?php  } else { ?>市场支持<?php  } ?></h2><p><?php  if(!empty($daili["title11"])) { ?><?php  echo $daili["title11"];?><?php  } else { ?>合作商经验交流，月度交流会，线上 沙龙<?php  } ?></p></li>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title12'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title12'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico3.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title13"])) { ?><?php  echo $daili["title13"];?><?php  } else { ?>资源支持<?php  } ?></h2><p><?php  if(!empty($daili["title14"])) { ?><?php  echo $daili["title14"];?><?php  } else { ?>共享合伙人客户案例，市场推广建议<?php  } ?></p></li>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title15'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title15'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico4.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title16"])) { ?><?php  echo $daili["title16"];?><?php  } else { ?>培训支持<?php  } ?></h2><p><?php  if(!empty($daili["title17"])) { ?><?php  echo $daili["title17"];?><?php  } else { ?>专业的研发团队，优先处理合伙人的 反馈&需要&定制<?php  } ?></p></li>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title18'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title18'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico5.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title19"])) { ?><?php  echo $daili["title19"];?><?php  } else { ?>售后支持<?php  } ?></h2><p><?php  if(!empty($daili["title20"])) { ?><?php  echo $daili["title20"];?><?php  } else { ?>提供技术顾问7*24小时售后咨询<?php  } ?></p></li>
                	<li class="wow fadeInUp"><h3><img src="<?php  if(!empty($daili['title21'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $daili['title21'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/dl_ico6.png<?php  } ?>" /></h3><h2><?php  if(!empty($daili["title22"])) { ?><?php  echo $daili["title22"];?><?php  } else { ?>物料支持<?php  } ?></h2><p><?php  if(!empty($daili["title23"])) { ?><?php  echo $daili["title23"];?><?php  } else { ?>宣传海报/宣传彩页，产品手册，产品 操作/招商手册（电子版）<?php  } ?></p></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="ntitle"><h2><?php  if(!empty($daili["title24"])) { ?><?php  echo $daili["title24"];?><?php  } else { ?>我们需要这样的你<?php  } ?></h2><p><?php  if(!empty($daili["title25"])) { ?><?php  echo $daili["title25"];?><?php  } else { ?>NEED CONDITION<?php  } ?></p></div>
            <div class="xcxdl_xqbox wow fadeInUp">
            	<p class="xqp">① <?php  if(!empty($daili["title26"])) { ?><?php  echo $daili["title26"];?><?php  } else { ?>注册资金10万以上<?php  } ?></p>
            	<p class="xqp">② <?php  if(!empty($daili["title27"])) { ?><?php  echo $daili["title27"];?><?php  } else { ?>团队核心成员5人以上<?php  } ?></p>
            	<p class="xqp">③ <?php  if(!empty($daili["title28"])) { ?><?php  echo $daili["title28"];?><?php  } else { ?>优先考虑有设计能力或者拥有设计师团队的代理商<?php  } ?></p>
            	<p class="xqp">④ <?php  if(!empty($daili["title29"])) { ?><?php  echo $daili["title29"];?><?php  } else { ?>有互联网行业经验优先，具备管理经验者优先<?php  } ?></p>
            </div>
            <div class="xcxdl_jrbtn"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $setting['qq'];?>&site=qq&menu=yes" target="_blank">加入我们</a></div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>