<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(!empty($title['solve'])) { ?><?php  echo $title['solve'];?><?php  } else { ?>解决方案-<?php  echo $setting['company'];?><?php  } ?></title>
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
    title: "<?php  if(!empty($title['solve'])) { ?><?php  echo $title['solve'];?><?php  } else { ?>首页-<?php  echo $setting['company'];?><?php  } ?>",
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
    <div id="banner" class="banner" style="background:url(<?php  if(!empty($banner['solve'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $banner['solve'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/jjfa_banner.jpg<?php  } ?>) no-repeat center center; background-size:cover;">
    	<div class="wrapper">
        	<div class="jjfa_bantxt">
            	<h2 class="wow fadeInUp"><?php  if(!empty($banner['solvetitle'])) { ?><?php  echo $banner['solvetitle'];?><?php  } else { ?>解决方案<?php  } ?><span></span></h2>
               <div class="wow fadeInUp animated delay-2s bannerp">
			   <?php  echo $content?>
			   </div>
            </div>
        </div>
    </div>
    <div class="n_mnu">
    	<div class="wrapper">
        	<ul>
            	<li <?php  if($cid==0) { ?>class="on"<?php  } ?>><a href="<?php  echo $this->mogucms_url('solve')?>">全部</a></li>
				<?php  if(is_array($categorys)) { foreach($categorys as $c) { ?>
            	<li <?php  if($cid==$c['id']) { ?>class="on"<?php  } ?>><a href="<?php  echo $this->mogucms_url('solve',array('cid'=>$c['id']))?>"><?php  echo $c['categoryname'];?></a></li>
            	<?php  } } ?>
            </ul>
        </div>
    </div>
    <div class="solve_content bgf4">
        <div class="wrapper">
            <div class="jjfa_list">
                <ul>
					<?php  if(is_array($lists)) { foreach($lists as $ls) { ?>
                    <li class="wow fadeInUp">
                        <a href="<?php  echo $this->mogucms_url('solvedetail',array('id'=>$ls['id']))?>"><h1><img src="<?php  echo $_W['attachurl'];?><?php  echo $ls['image'];?>" /><?php  if(!empty($ls['erweima'])) { ?><span><img src="<?php  echo $_W['attachurl'];?><?php  echo $ls['erweima'];?>"></span><?php  } ?></h1></a>
                        <h2><a href="<?php  echo $this->mogucms_url('solvedetail',array('id'=>$ls['id']))?>"><?php  echo $ls['title'];?></a></h2>
                        <p><?php  echo $ls['categoryname'];?>服务类型</p>
                        <!--<h3><span class="fl"><?php  echo $ls['count'];?></span><span class="fr"><?php  echo $ls['num'];?></span></h3>-->
                    </li>
                    <?php  } } ?>
                </ul>
            </div>
   			<div class="page">
			<?php  if($pindex>1) { ?>
				<a href="<?php  echo $this->mogucms_url('solve',array('page'=>($pindex-1)))?>"><img src="../addons/mogucms_guanwang/template/style/images/page_lico.png"></a>
				<?php  } ?>
				<?php  for($i=1;$i<=$allpage;$i++){?>
				<a <?php  if($pindex==$i) { ?>class="on"<?php  } ?> href="<?php  echo $this->mogucms_url('solve',array('page'=>$i))?>"><?php  echo $i;?></a>
				<?php  }?>
				
				<?php  if($pindex<$allpage) { ?>
				<a href="<?php  echo $this->mogucms_url('solve',array('page'=>($pindex+1)))?>"><img src="../addons/mogucms_guanwang/template/style/images/page_rico.png"></a>
				<?php  } ?>
			</div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('default/footer', TEMPLATE_INCLUDEPATH)) : (include template('default/footer', TEMPLATE_INCLUDEPATH));?>