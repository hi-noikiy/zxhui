<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  echo $info['title'];?></title>
<meta name="keywords" content="<?php  echo $info['keywords'];?>" />
<meta name="description" content="<?php  echo $info['description'];?>" />
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
    title: "<?php  echo $info['title'];?>",
    desc: "<?php  echo $info['keywords'];?>",
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
    <div id="banner" class="banner"><img src="<?php  if(!empty($banner['news'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['news'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/news_banner.jpg<?php  } ?>" /></div>
    <div class="news_content">
        <div class="wrapper">
            <div class="news_menu">
            	<ul>
                	<li <?php  if($cid==0) { ?>class="on"<?php  } ?>><a href="<?php  echo $this->mogucms_url('news')?>">全部</a></li>
					<?php  if(is_array($categorys)) { foreach($categorys as $c) { ?>
                	<li <?php  if($cid==$c['id']) { ?>class="on"<?php  } ?>><a href="<?php  echo $this->mogucms_url('news',array('cid'=>$c['id']))?>"><?php  echo $c['categoryname'];?></a></li>
                	<?php  } } ?>
                </ul>
            </div>
            <div class="news_detail_cont wow fadeInUp">
            	<div class="news_detail_cttitle">
                	<h2><?php  echo $info['title'];?></h2>
                    <p><?php  echo date("Y-m-d H:i:s",$info['addtime'])?></p>
                </div>
                <div class="news_detail_ctinfo">
                	<?php  echo html_entity_decode($info['content'])?>
                </div>
            </div>
            <div class="news_detail_fr wow fadeInUp animated delay-2s">
            	<div class="hd">推荐新闻</div>
                <div class="bd">
                	<ul>
						<?php  if(is_array($newstj)) { foreach($newstj as $tj) { ?>
                    	<li><em>·</em><a href="<?php  echo $this->mogucms_url('newsdetail',array('id'=>$tj['id']))?>"><?php  echo $tj['title'];?></a></li>
                    	<?php  } } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>