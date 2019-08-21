<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['home'])) { ?><?php  echo $title['home'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?></title>
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
<script src="../addons/mogucms_guanwang/template/style/js/TouchSlide.1.1.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/wow.min.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/jquery.lazyload.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/comloding.js"></script>
<script src="../addons/mogucms_guanwang/template/style/js/common.js"></script>
<!--[if lt IE 9]>
<script src="../addons/mogucms_guanwang/template/style/js/html5.js"></script>
<![endif]-->
<?php  if($this->isWeixin()) { ?>
<script>
if(window.location.pathname=="/"){
	window.location.href="<?php  echo $dizhi;?>";
}
</script>
<?php  } ?>
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
    title: "<?php  if(!empty($title['home'])) { ?><?php  echo $title['home'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
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
<?php  if(!empty($setting['shangqiao'])) { ?><?php  echo html_entity_decode($setting['shangqiao'])?><?php  } ?>
</head>

<body>
<div class="header">
	<div class="wrapper">
    	<a class="logo" href="<?php  echo $this->mogucms_url()?>"><span><img src="<?php  if($setting['logo1']) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['logo1'];?><?php  } else if($fdset['logo1']) { ?><?php  echo $_W['attachurl'];?><?php  echo $fdset['logo1'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/logo.png<?php  } ?>"></span><em><img src="<?php  if($setting['logo2']) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['logo2'];?><?php  } else if($fdset['logo2']) { ?><?php  echo $_W['attachurl'];?><?php  echo $fdset['logo2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/logo2.png<?php  } ?>"></em></a>
        <div class="nav">
			<a class="navico" href="javascript:;"><span><img src="../addons/mogucms_guanwang/template/style/images/nav_ico2.png"></span><em><img src="../addons/mogucms_guanwang/template/style/images/nav_ico.png"></em></a>
        	<ul>
            	<li class="on"><a href="<?php  echo $this->mogucms_url()?>"><?php  if(!empty($menu['home'])) { ?><?php  echo $menu['home'];?><?php  } else { ?>首页<?php  } ?></a></li>
            	<?php  if($menu['solve'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('solve')?>"><?php  if(!empty($menu['solve2'])) { ?><?php  echo $menu['solve2'];?><?php  } else { ?>解决方案<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['xiaochengxu'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('xiaochengxu')?>"><?php  if(!empty($menu['xiaochengxu2'])) { ?><?php  echo $menu['xiaochengxu2'];?><?php  } else { ?>小程序<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['dingzhi'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('customize')?>"><?php  if(!empty($menu['dingzhi2'])) { ?><?php  echo $menu['dingzhi2'];?><?php  } else { ?>定制开发<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['daili'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('daili')?>"><?php  if(!empty($menu['daili2'])) { ?><?php  echo $menu['daili2'];?><?php  } else { ?>代理加盟<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['news'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('news')?>"><?php  if(!empty($menu['news2'])) { ?><?php  echo $menu['news2'];?><?php  } else { ?>新闻资讯<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['about'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('about')?>"><?php  if(!empty($menu['about2'])) { ?><?php  echo $menu['about2'];?><?php  } else { ?>关于我们<?php  } ?></a></li><?php  } ?>
            	<?php  if($menu['contact'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('contact')?>"><?php  if(!empty($menu['contact2'])) { ?><?php  echo $menu['contact2'];?><?php  } else { ?>联系我们<?php  } ?></a></li><?php  } ?>
				<?php  if($menu['help'] != "1") { ?><li><a href="<?php  echo $this->mogucms_url('help')?>"><?php  if(!empty($menu['help2'])) { ?><?php  echo $menu['help2'];?><?php  } else { ?>帮助中心<?php  } ?></a></li><?php  } ?>
				<?php  if(!empty($menu['defname1'])) { ?><li><a href="<?php  echo $menu['defurl1'];?>" target="_blank"><?php  echo $menu['defname1'];?></a></li><?php  } ?>
				<?php  if(!empty($menu['defname2'])) { ?><li><a href="<?php  echo $menu['defurl2'];?>" target="_blank"><?php  echo $menu['defname2'];?></a></li><?php  } ?>
            </ul>
        </div>
        <div class="loginreg"><a href="<?php  if(!empty($setting['loginurl'])) { ?><?php  echo $setting['loginurl'];?><?php  } else { ?><?php  echo $this->mogucms_url('login')?><?php  } ?>">登录</a><?php  if($loginset['iszhuche']!="1") { ?>|<a href="<?php  if(!empty($setting['regurl'])) { ?><?php  echo $setting['regurl'];?><?php  } else { ?><?php  echo $this->mogucms_url('register')?><?php  } ?>">注册</a><?php  } ?></div>
    </div>
</div>
<div id="banner" class="banner">
    <div class="hd">
        <ul><?php  if($banner['home']) { ?>
		<?php  if(is_array($banner['home'])) { foreach($banner['home'] as $k => $b) { ?>
		<li><?php  echo $k+1?></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li>1</li><li>2</li><li>3</li>
		<?php  } ?></ul>
    </div>
    <div class="bd">
        <ul>
			<?php  if(!empty($banner['home1'])) { ?>
			<li><a href="<?php  echo $banner['homeurl1'];?>" target="_blank"><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $banner['home1'];?>" /></span><em><img src="<?php  if(!empty($banner['homemob1'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['homemob1'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/mod_banner.jpg<?php  } ?>" /></em></a></li>
			<li><a href="<?php  echo $banner['homeurl2'];?>" target="_blank"><span><img src="<?php  if(!empty($banner['home2'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['home2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/banner.jpg<?php  } ?>" /></span><em><img src="<?php  if(!empty($banner['homemob2'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['homemob2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/mod_banner.jpg<?php  } ?>" /></em></a></li>
			<li><a href="<?php  echo $banner['homeurl3'];?>" target="_blank"><span><img src="<?php  if(!empty($banner['home3'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['home3'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/banner.jpg<?php  } ?>" /></span><em><img src="<?php  if(!empty($banner['homemob3'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['homemob3'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/mod_banner.jpg<?php  } ?>" /></em></a></li>
			<?php  } else if($banner['home']) { ?>
			<?php  if(is_array($banner['home'])) { foreach($banner['home'] as $k => $b) { ?>
			<li><a href="javascript:;"><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $b;?>" /></span><em><img src="<?php  if($banner['homemob'][$k]) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['homemob'][$k];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/mod_banner.jpg<?php  } ?>" /></em></a></li>
			<?php  } } ?>
			<?php  } else { ?>
			<li><a href="javascript:;"><span><img src="../addons/mogucms_guanwang/template/style/images/banner.jpg" /></span><em><img src="../addons/mogucms_guanwang/template/style/images/mod_banner.jpg" /></em></a></li>
            <li><a href="javascript:;"><span><img src="../addons/mogucms_guanwang/template/style/images/banner.jpg" /></span><em><img src="../addons/mogucms_guanwang/template/style/images/mod_banner.jpg" /></em></a></li>
            <li><a href="javascript:;"><span><img src="../addons/mogucms_guanwang/template/style/images/banner.jpg" /></span><em><img src="../addons/mogucms_guanwang/template/style/images/mod_banner.jpg" /></em></a></li>
			<?php  } ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
TouchSlide({ 
		slideCell:"#banner",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"left", 
		autoPlay:true,//自动播放
		autoPage:true, //自动分页
		switchLoad:"_src" //切换加载，真实图片路径为"_src" 
	});
</script>
<div class="content">
	<div class="wrapper">
    	<div class="title"><h2><span></span><?php  if(!empty($setting["titleourservice"])) { ?><?php  echo $setting["titleourservice"];?><?php  } else { ?>我们的服务<?php  } ?></h2></div>
        <div class="iservice_ui<?php  if(!empty($service['image4'])) { ?> uibox4<?php  } ?>">
        	<ul>
            	<li class="wow fadeInUp animated delay-1s">
                	<h3><img src="<?php  if(!empty($service['image1'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $service['image1'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/sevice_icon1.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($service['title1'])) { ?><?php  echo $service['title1'];?><?php  } else { ?>微信公众号<?php  } ?></h2>
                    <p><?php  if(!empty($service['miaoshu1'])) { ?><?php  echo $service['miaoshu1'];?><?php  } else { ?>资深研发团队，提供高品质微信开发服务<?php  } ?></p>
                </li>
            	<li class="wow fadeInUp animated delay-2s">
                	<h3><img src="<?php  if(!empty($service['image2'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $service['image2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/sevice_icon2.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($service['title2'])) { ?><?php  echo $service['title2'];?><?php  } else { ?>小程序开发<?php  } ?></h2>
                    <p><?php  if(!empty($service['miaoshu2'])) { ?><?php  echo $service['miaoshu2'];?><?php  } else { ?>专业技术团队,专业设计流程,全行业定制开发<?php  } ?></p>
                </li>
            	<li class="wow fadeInUp animated delay-3s">
                	<h3><img src="<?php  if(!empty($service['image3'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $service['image3'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/sevice_icon3.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($service['title3'])) { ?><?php  echo $service['title3'];?><?php  } else { ?>APP开发<?php  } ?></h2>
                    <p><?php  if(!empty($service['miaoshu3'])) { ?><?php  echo $service['miaoshu3'];?><?php  } else { ?>专业定制IOS/安卓APP软件，专业APP设计服务<?php  } ?></p>
                </li>
				<?php  if(!empty($service['image4'])) { ?>
				<li class="wow fadeInUp animated delay-4s">
                	<h3><img src="<?php  if(!empty($service['image4'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $service['image4'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/sevice_icon4.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($service['title4'])) { ?><?php  echo $service['title4'];?><?php  } else { ?>PC建站<?php  } ?></h2>
                    <p><?php  if(!empty($service['miaoshu4'])) { ?><?php  echo $service['miaoshu4'];?><?php  } else { ?>公司官网,外贸网站,电子商务网站<?php  } ?></p>
                </li>
				<?php  } ?>

            </ul>
        </div>
    </div>
</div>
<div class="ilc_bg">
	<div class="wrapper">
    	<div class="title"><h2><span></span><?php  if(!empty($setting["titlekflc"])) { ?><?php  echo $setting["titlekflc"];?><?php  } else { ?>开发流程<?php  } ?></h2></div>
        <div class="ilc_ui">
        	<ul>
            	<li class="wow fadeInUp animated delay-1s">
                	<h3><img src="<?php  if(!empty($development['image1'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $development['image1'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/lc_ico1.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($development['title1'])) { ?><?php  echo $development['title1'];?><?php  } else { ?>需求沟通<?php  } ?></h2>
                    <p><?php  if(!empty($development['miaoshu1'])) { ?><?php  echo $development['miaoshu1'];?><?php  } else { ?>客户提出需求，进行功能分析，确定功能需求<?php  } ?></p>
                    <em></em>
                </li>
            	<li class="wow fadeInUp animated delay-2s">
                	<h3><img src="<?php  if(!empty($development['image2'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $development['image2'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/lc_ico2.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($development['title2'])) { ?><?php  echo $development['title2'];?><?php  } else { ?>交互设计<?php  } ?></h2>
                    <p><?php  if(!empty($development['miaoshu2'])) { ?><?php  echo $development['miaoshu2'];?><?php  } else { ?>根据已确定的需求功能确认原型，UI设计稿<?php  } ?></p>
                    <em></em>
                </li>
            	<li class="wow fadeInUp animated delay-3s">
                	<h3><img src="<?php  if(!empty($development['image3'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $development['image3'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/lc_ico3.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($development['title3'])) { ?><?php  echo $development['title3'];?><?php  } else { ?>技术开发<?php  } ?></h2>
                    <p><?php  if(!empty($development['miaoshu3'])) { ?><?php  echo $development['miaoshu3'];?><?php  } else { ?>根据功能需求，完成前后端的开发<?php  } ?></p>
                    <em></em>
                </li>
            	<li class="wow fadeInUp animated delay-4s">
                	<h3><img src="<?php  if(!empty($development['image4'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $development['image4'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/lc_ico4.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($development['title4'])) { ?><?php  echo $development['title4'];?><?php  } else { ?>发布上架<?php  } ?></h2>
                    <p><?php  if(!empty($development['miaoshu4'])) { ?><?php  echo $development['miaoshu4'];?><?php  } else { ?>与客户确定验收无误后发布上架<?php  } ?></p>
                    <em></em>
                </li>
            	<li class="wow fadeInUp animated delay-5s">
                	<h3><img src="<?php  if(!empty($development['image5'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $development['image5'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/lc_ico5.png<?php  } ?>" /></h3>
                    <h2><?php  if(!empty($development['title5'])) { ?><?php  echo $development['title5'];?><?php  } else { ?>后续服务<?php  } ?></h2>
                    <p><?php  if(!empty($development['miaoshu5'])) { ?><?php  echo $development['miaoshu5'];?><?php  } else { ?>后续持续跟进服务<?php  } ?></p>
                    <em></em>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="content">
	<div class="wrapper">
    	<div class="title"><h2><span></span><?php  if(!empty($setting["titleanli"])) { ?><?php  echo $setting["titleanli"];?><?php  } else { ?>案例<?php  } ?></h2></div>
        <div class="icase_menu"><a class="active" href="javascript:;">全部</a><?php  if(is_array($categorys)) { foreach($categorys as $c) { ?><a href="<?php  echo $this->mogucms_url('xiaochengxu',array('cid'=>$c['id'].'#cate'))?>" <?php  if($cid==$c['id']) { ?>class="active"<?php  } ?>><?php  echo $c['categoryname'];?></a><?php  } } ?></div>
        <div class="icase_ui">
        	<ul>
				<?php  if(is_array($cases)) { foreach($cases as $c) { ?>
            	<li class="wow fadeInUp">
					<?php  if(!empty($c['myurl'])) { ?>
                	<a href="<?php  echo $c['myurl'];?>" target="_blank"><h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $c['image'];?>" class="anlianli"/><?php  if(!empty($c['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $c['erweima'];?>" /></span><?php  } ?></h3></a>
                    <p><a href="<?php  echo $c['myurl'];?>" target="_blank"><?php  echo $c['title'];?></a></p>
					<?php  } else { ?>
					<h3><img src="<?php  echo $_W['attachurl'];?><?php  echo $c['image'];?>" class="anlianli"/><?php  if(!empty($c['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $c['erweima'];?>" /></span><?php  } ?></h3>
                    <p><?php  echo $c['title'];?></p>
					<?php  } ?>
                </li>
				<?php  } } ?>
            </ul>
        </div>
    </div>
</div>
<?php  if($setting['showsolve'] == 1) { ?>
<div class="content">
	<div class="wrapper">
    	<div class="title"><h2><span></span><?php  if(!empty($setting["titlesolve"])) { ?><?php  echo $setting["titlesolve"];?><?php  } else { ?>解决方案<?php  } ?></h2></div>
        <div class="icase_menu"><a class="active" href="javascript:;">全部</a><?php  if(is_array($categorys)) { foreach($categorys as $c) { ?><a href="<?php  echo $this->mogucms_url('solve',array('cid'=>$c['id']))?>" <?php  if($cid==$c['id']) { ?>class="active"<?php  } ?>><?php  echo $c['categoryname'];?></a><?php  } } ?></div>
       <div class="jjfa_list">
			<ul>
				<?php  if(is_array($slists)) { foreach($slists as $ls) { ?>
				<li class="wow fadeInUp">
					<a href="<?php  echo $this->mogucms_url('solvedetail',array('id'=>$ls['id']))?>"><h1><img src="<?php  echo $_W['attachurl'];?><?php  echo $ls['image'];?>" /><?php  if(!empty($ls['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $ls['erweima'];?>"></span><?php  } ?></h1></a>
					<h2><a href="<?php  echo $this->mogucms_url('solvedetail',array('id'=>$ls['id']))?>"><?php  echo $ls['title'];?></a></h2>
					<p><?php  echo $ls['categoryname'];?>服务类型</p>
				</li>
				<?php  } } ?>
			</ul>
		</div>
    </div>
</div>
<?php  } ?>
<div class="content inew_bg">
	<div class="wrapper">
    	<div class="title"><h2><span></span><?php  if(!empty($setting["titlexwzx"])) { ?><?php  echo $setting["titlexwzx"];?><?php  } else { ?>新闻资讯<?php  } ?></h2></div>
        <div class="inew_ui">
        	<ul>
				<?php  if(is_array($news)) { foreach($news as $n) { ?>
            	<li class="wow fadeInUp animated delay-1s">
                	<div class="dt"><span><?php  echo date("m-d",$n['addtime'])?></span><em><?php  echo date("Y",$n['addtime'])?></em></div>
                    <div class="dd">
                    	<a href="<?php  echo $this->mogucms_url('newsdetail',array('id'=>$n['id']))?>">
                    	<span><?php  echo $n['title'];?></span>
                        <em><?php  echo $n['abstract'];?></em>
                        </a>
                    </div>
                </li>
				<?php  } } ?>
            </ul>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>