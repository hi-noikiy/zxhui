<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">样式选择</label>
        <div class="col-sm-8">
			自定义登录文件名login7.html 注册：register7.html(没有自定义过不要选择，否则登录地址失效)
            <select name="yangshi" class="col-sm-8">
                <option value="1" <?php  if($setting['yangshi']=="1") { ?>selected<?php  } ?>>视频版</option>
                <option value="2" <?php  if($setting['yangshi']=="2") { ?>selected<?php  } ?>>JS动画版</option>
                <option value="3" <?php  if($setting['yangshi']=="3") { ?>selected<?php  } ?>>背景图版</option>
				<?php  if($_SERVER['HTTP_HOST']=="trade.mogucms.com" || $_SERVER['HTTP_HOST']=="weil.xin") { ?>
                <option value="4" <?php  if($setting['yangshi']=="4") { ?>selected<?php  } ?>>定制版本(手机注册)</option>
				<?php  } ?>
                <option value="5" <?php  if($setting['yangshi']=="5") { ?>selected<?php  } ?>>手机注册版(需开通短信)</option>
				<?php  if($_SERVER['HTTP_HOST']=="trade.mogucms.com" || $_SERVER['HTTP_HOST']=="wq.zuoo.cn") { ?>
                <option value="6" <?php  if($setting['yangshi']=="6") { ?>selected<?php  } ?>>只有登录版</option>
				<?php  } ?>
				<option value="7" <?php  if($setting['yangshi']=="7") { ?>selected<?php  } ?>>自定义登录注册</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">是否开启注册</label>
        <div class="col-sm-8">
            <select name="iszhuche" class="col-sm-8">
                <option value="0" <?php  if($setting['iszhuche']=="0") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['iszhuche']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">短信接口</label>
        <div class="col-sm-8">
            <select name="sms" class="col-sm-8">
                <option value="weiqing" <?php  if($setting['sms']=="weiqing") { ?>selected<?php  } ?>>系统官方</option>
                <option value="yonghe" <?php  if($setting['sms']=="yonghe") { ?>selected<?php  } ?>>阿里聚合接口</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">页面标题</label>
        <div class="col-sm-8">
            <input type="text" name="title" class="form-control" value="<?php  echo $setting['title'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">中文标题</label>
        <div class="col-sm-8">
            <input type="text" name="zhongwen" class="form-control" value="<?php  echo $setting['zhongwen'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">英文标题</label>
        <div class="col-sm-8">
            <input type="text" name="yingwen" class="form-control" value="<?php  echo $setting['yingwen'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图片</label>
        <div class="col-sm-8">
			图片背景 建议尺寸>1366*768
            <?php  echo tpl_form_field_image('corp', $setting['corp'], '');?>
        </div>
    </div>
	 <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">视频</label>
        <div class="col-sm-8">
			支持远程视频，直接把地址复制到此即可。
            <?php  echo tpl_form_field_video('shipin', $setting['shipin'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">短信签名</label>
        <div class="col-sm-8">
            <input type="text" name="smssign" class="form-control" value="<?php  echo $setting['smssign'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">登录Logo</label>
        <div class="col-sm-8">
			有logo的登录注册模板才显示
            <?php  echo tpl_form_field_image('logo', $setting['logo'], '');?>
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