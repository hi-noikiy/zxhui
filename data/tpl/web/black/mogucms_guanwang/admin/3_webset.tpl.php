<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
	
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">启用伪静态</label>
        <div class="col-sm-8">
            <select name="rewrite" class="col-sm-8">
                <option value="1" <?php  if($setting['rewrite']=="1") { ?>selected<?php  } ?>>开启</option>
                <option value="0" <?php  if($setting['rewrite']!="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">只要登录注册页</label>
        <div class="col-sm-8">
            <select name="onlylogin" class="col-sm-8">
                <option value="1" <?php  if($setting['onlylogin']=="1") { ?>selected<?php  } ?>>开启</option>
                <option value="0" <?php  if($setting['onlylogin']!="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页显示解决方案</label>
        <div class="col-sm-8">
            <select name="showsolve" class="col-sm-8">
                <option value="1" <?php  if($setting['showsolve']=="1") { ?>selected<?php  } ?>>开启</option>
                <option value="0" <?php  if($setting['showsolve']!="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">模板选择</label>
        <div class="col-sm-8">
			可以自己写模板或者复制一份官方模板修改，不会被覆盖，官方default 创始人moban目录 
            <select name="moban" class="col-sm-8">
                <option value="default" <?php  if($setting['moban']=="default") { ?>selected<?php  } ?>>官方模板</option>
                <option value="moban" <?php  if($setting['moban']=="moban") { ?>selected<?php  } ?>>创始人模板(没有自定义的不要选择)</option>
            </select>
        </div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公司名字</label>
        <div class="col-sm-8">
            <input type="text" name="company" class="form-control" value="<?php  echo $setting['company'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">域名</label>
        <div class="col-sm-8">
            <input type="text" name="domain" class="form-control" value="<?php  echo $setting['domain'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">电话</label>
        <div class="col-sm-8">
            <input type="text" name="dianhua" class="form-control" value="<?php  echo $setting['dianhua'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">手机</label>
        <div class="col-sm-8">
            <input type="text" name="shouji" class="form-control" value="<?php  echo $setting['shouji'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">QQ</label>
        <div class="col-sm-8">
            <input type="text" name="qq" class="form-control" value="<?php  echo $setting['qq'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">Email</label>
        <div class="col-sm-8">
            <input type="text" name="email" class="form-control" value="<?php  echo $setting['email'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">地址</label>
        <div class="col-sm-8">
            <input type="text" name="dizhi" class="form-control" value="<?php  echo $setting['dizhi'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">交通路线</label>
        <div class="col-sm-8">
            <input type="text" name="luxian" class="form-control" value="<?php  echo $setting['luxian'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">白色底logo</label>
        <div class="col-sm-8">
			尺寸:115*43
            <?php  echo tpl_form_field_image('logo1', $setting['logo1'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">icon</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('icon', $setting['icon'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">蓝色底logo</label>
        <div class="col-sm-8">
			尺寸:115*43
            <?php  echo tpl_form_field_image('logo2', $setting['logo2'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">二维码</label>
        <div class="col-sm-8">
			尺寸:110*110
            <?php  echo tpl_form_field_image('erweima', $setting['erweima'], '');?>
        </div>
    </div>
	<!--<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">联系我们地图</label>
        <div class="col-sm-8">
			尺寸:110*110
            <?php  echo tpl_form_field_image('ditu', $setting['ditu'], '');?>
        </div>
    </div>-->
	<div class="form-group">
        <label for="" class="control-label col-sm-2">联系我们地图(动态地图)</label>
        <div class="form-controls col-sm-8">
			使用编辑器的地图插入即可
            <?php  echo tpl_ueditor('ditu', $setting['ditu']);?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">底部版权</label>
        <div class="col-sm-8">
            <input type="text" name="banquan" class="form-control" value="<?php  echo $setting['banquan'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">备案号</label>
        <div class="col-sm-8">
            <input type="text" name="beianhao" class="form-control" value="<?php  echo $setting['beianhao'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">公司简介</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('intro', $setting['intro']);?>
        </div>
    </div>

	<div class="form-group">
        <label for="" class="control-label col-sm-2">解决方案</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('solve', $setting['solve']);?>
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">代理加盟</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('daili', $setting['daili']);?>
        </div>
    </div>

	<div class="form-group">
        <label for="" class="control-label col-sm-2">微信小程序</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('xiaochengxu', $setting['xiaochengxu']);?>
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">定制开发</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('dingzhi', $setting['dingzhi']);?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制服务流程图</label>
        <div class="col-sm-8">
			尺寸:1200*329
            <?php  echo tpl_form_field_image('dzt', $setting['dzt'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">全局keywords</label>
        <div class="col-sm-8">
            <input type="text" name="keywords" class="form-control" value="<?php  echo $setting['keywords'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">全局description</label>
        <div class="col-sm-8">
            <input type="text" name="description" class="form-control" value="<?php  echo $setting['description'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页案例个数</label>
        <div class="col-sm-8">
			4的倍数
            <input type="text" name="homeanlinum" class="form-control" value="<?php  echo $setting['homeanlinum'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序页案例个数</label>
        <div class="col-sm-8">
			4的倍数
            <input type="text" name="xcxanlinum" class="form-control" value="<?php  echo $setting['xcxanlinum'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">登录链接地址</label>
        <div class="col-sm-8">
			如果不想用系统带的登录，可以链接到其他地址,请加http://或者https://
            <input type="text" name="loginurl" class="form-control" value="<?php  echo $setting['loginurl'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">注册链接地址</label>
        <div class="col-sm-8">
			如果不想用系统带的注册，可以链接到其他地址,请加http://或者https://
            <input type="text" name="regurl" class="form-control" value="<?php  echo $setting['regurl'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页-我们的服务</label>
        <div class="col-sm-8">
            <input type="text" name="titleourservice" class="form-control" value="<?php  echo $setting['titleourservice'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页-开发流程</label>
        <div class="col-sm-8">
            <input type="text" name="titlekflc" class="form-control" value="<?php  echo $setting['titlekflc'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页-案例</label>
        <div class="col-sm-8">
            <input type="text" name="titleanli" class="form-control" value="<?php  echo $setting['titleanli'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页-解决方案</label>
        <div class="col-sm-8">
            <input type="text" name="titlesolve" class="form-control" value="<?php  echo $setting['titlesolve'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页-新闻资讯</label>
        <div class="col-sm-8">
            <input type="text" name="titlexwzx" class="form-control" value="<?php  echo $setting['titlexwzx'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-小程序入口</label>
        <div class="col-sm-8">
            <input type="text" name="titlexcxrk" class="form-control" value="<?php  echo $setting['titlexcxrk'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-小程序入口(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="titlexcxrken" class="form-control" value="<?php  echo $setting['titlexcxrken'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-部分案例展示</label>
        <div class="col-sm-8">
            <input type="text" name="titlebfanzs" class="form-control" value="<?php  echo $setting['titlebfanzs'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-部分案例展示(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="titlebfanzsen" class="form-control" value="<?php  echo $setting['titlebfanzsen'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-适用客户</label>
        <div class="col-sm-8">
            <input type="text" name="titlesykh" class="form-control" value="<?php  echo $setting['titlesykh'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序-适用客户(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="titlesykhen" class="form-control" value="<?php  echo $setting['titlesykhen'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-我们能为您做什么</label>
        <div class="col-sm-8">
            <input type="text" name="title31" class="form-control" value="<?php  echo $setting['title31'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-我们能为您做什么(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title32" class="form-control" value="<?php  echo $setting['title32'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-我们的优势</label>
        <div class="col-sm-8">
            <input type="text" name="title33" class="form-control" value="<?php  echo $setting['title33'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-我们的优势(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title34" class="form-control" value="<?php  echo $setting['title34'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-定制服务流程</label>
        <div class="col-sm-8">
            <input type="text" name="title35" class="form-control" value="<?php  echo $setting['title35'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发-定制服务流程(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title36" class="form-control" value="<?php  echo $setting['title36'];?>" />
        </div>
    </div>
	<?php  if($_W['isfounder']=="1") { ?>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">百度商桥</label>
        <div class="col-sm-8">
            <textarea type="text" name="shangqiao" class="form-control"><?php  echo $setting['shangqiao'];?></textarea>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">商桥所有页显示</label>
        <div class="col-sm-8">
            <select name="isshangqiao" class="col-sm-8">
                <option value="1" <?php  if($setting['isshangqiao']=="1") { ?>selected<?php  } ?>>开启</option>
                <option value="0" <?php  if($setting['isshangqiao']!="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<?php  } ?>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公安备案号</label>
        <div class="col-sm-8">
            <input type="text" name="gonganhao" class="form-control" value="<?php  echo $setting['gonganhao'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公安备案链接</label>
        <div class="col-sm-8">
            <input type="text" name="gonganhaourl" class="form-control" value="<?php  echo $setting['gonganhaourl'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">工商网监图片</label>
        <div class="col-sm-8">
			20*20px
            <?php  echo tpl_form_field_image('gsimg', $setting['gsimg'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">工商网监链接</label>
        <div class="col-sm-8">
            <input type="text" name="gsurl" class="form-control" value="<?php  echo $setting['gsurl'];?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
            <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </div>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>