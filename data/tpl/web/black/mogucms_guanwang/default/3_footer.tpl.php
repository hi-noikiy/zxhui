<?php defined('IN_IA') or exit('Access Denied');?><div class="footer">
	<!--<div class="footer_link">
		<div class="wrapper" style="text-align:left">
    	<strong>友情链接：</strong><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a><a href="#" target="_blank">xxxxxxxxx</a>
        </div>
    </div>-->
	<div class="wrapper">
    	<div class="fl">
        	<div class="foot_menu"><?php  if($menu['dingzhi'] != "1") { ?><a href="<?php  echo $this->mogucms_url('customize')?>"><?php  if(!empty($menu['dingzhi2'])) { ?><?php  echo $menu['dingzhi2'];?><?php  } else { ?>定制开发<?php  } ?></a><span>|</span><?php  } ?><?php  if($menu['news'] != "1") { ?><a href="<?php  echo $this->mogucms_url('news')?>"><?php  if(!empty($menu['news2'])) { ?><?php  echo $menu['news2'];?><?php  } else { ?>新闻资讯<?php  } ?></a><span>|</span><?php  } ?><?php  if($menu['xiaochengxu'] != "1") { ?><a href="<?php  echo $this->mogucms_url('xiaochengxu')?>"><?php  if(!empty($menu['xiaochengxu2'])) { ?><?php  echo $menu['xiaochengxu2'];?><?php  } else { ?>小程序<?php  } ?></a><span>|</span><?php  } ?><?php  if($menu['solve'] != "1") { ?><a href="<?php  echo $this->mogucms_url('solve')?>"><?php  if(!empty($menu['solve2'])) { ?><?php  echo $menu['solve2'];?><?php  } else { ?>解决方案<?php  } ?></a><span>|</span><?php  } ?><?php  if($menu['about'] != "1") { ?><a href="<?php  echo $this->mogucms_url('about')?>"><?php  if(!empty($menu['about2'])) { ?><?php  echo $menu['about2'];?><?php  } else { ?>关于我们<?php  } ?></a><?php  } ?></div>
            <div class="foot_contact">
            	<span><img src="../addons/mogucms_guanwang/template/style/images/foot_icotel.png">Tel： <?php  echo $setting['dianhua'];?></span>
            	<span><img src="../addons/mogucms_guanwang/template/style/images/foot_icoemail.png">E-mai：<?php  echo $setting['email'];?></span>
            	<span><img src="../addons/mogucms_guanwang/template/style/images/foot_icomap.png">Add：<?php  echo $setting['dizhi'];?></span>
            </div>
            <div class="foot_copright"><?php  echo $setting['banquan'];?> &nbsp;<a href="http://www.miitbeian.gov.cn" target="_blank"><?php  echo $setting['beianhao'];?></a></div>
            <?php  if($setting['gonganhao'] && $setting['gonganhaourl']) { ?><div class="foot_copright"><?php  if(!empty($setting['gsimg'])) { ?><a href="<?php  echo $setting['gsurl'];?>" target="_blank"><img src="<?php  echo $_W['attachurl'];?><?php  echo $setting['gsimg'];?>" width="14px" height="14px" style="margin-top:-3px;"></a><?php  } ?>&nbsp;<img src="../addons/mogucms_guanwang/template/style/images/ga.png" width="14px" height="14px" style="margin-top:-3px;"> <a href="<?php  echo $setting['gonganhaourl'];?>" target="_blank"><?php  echo $setting['gonganhao'];?></a></div><?php  } ?>
        </div>
        <div class="foot_ewm">
        	<h3><img src="<?php  if(!empty($setting['erweima'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['erweima'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/foot_ewm.png<?php  } ?>"></h3>
            <p>扫一扫 关注我</p>
        </div>
    </div>
</div>
<!--右侧浮动-->
<div class="fix_link">
	<ul>
    	<li class="fix_tel">
        	<div class="fix_info"><a href="tel:<?php  echo $setting['shouji'];?>"><?php  echo $setting['shouji'];?></a><span></span></div>
        </li>
    	<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php  echo $setting['qq'];?>&site=qq&menu=yes" target="_blank"><li class="fix_qq"></li></a>
    	<li class="fix_wx">
        	<div class="fix_info"><img src="<?php  if(!empty($setting['erweima'])) { ?><?php  echo $_W['attachurl'];?><?php  echo $setting['erweima'];?><?php  } else { ?>../addons/mogucms_guanwang/template/style/images/foot_ewm.png<?php  } ?>"><span></span></div>
        </li>
    	<li class="fix_top top"></li>
    </ul>
</div>
</body>
</html>