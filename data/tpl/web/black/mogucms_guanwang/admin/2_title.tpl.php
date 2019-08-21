<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
    
	
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页</label>
        <div class="col-sm-8">
            <input type="text" name="home" class="form-control" value="<?php  echo $setting['home'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">关于我们</label>
        <div class="col-sm-8">
            <input type="text" name="about" class="form-control" value="<?php  echo $setting['about'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">新闻</label>
        <div class="col-sm-8">
            <input type="text" name="news" class="form-control" value="<?php  echo $setting['news'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发</label>
        <div class="col-sm-8">
            <input type="text" name="dingzhi" class="form-control" value="<?php  echo $setting['dingzhi'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序</label>
        <div class="col-sm-8">
            <input type="text" name="xiaochengxu" class="form-control" value="<?php  echo $setting['xiaochengxu'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">解决方案</label>
        <div class="col-sm-8">
            <input type="text" name="solve" class="form-control" value="<?php  echo $setting['solve'];?>" />
        </div>
    </div>

	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">联系我们</label>
        <div class="col-sm-8">
            <input type="text" name="contact" class="form-control" value="<?php  echo $setting['contact'];?>" />
        </div>
    </div>

	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">代理加盟</label>
        <div class="col-sm-8">
            <input type="text" name="daili" class="form-control" value="<?php  echo $setting['daili'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">帮助中心</label>
        <div class="col-sm-8">
            <input type="text" name="help" class="form-control" value="<?php  echo $setting['help'];?>" />
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