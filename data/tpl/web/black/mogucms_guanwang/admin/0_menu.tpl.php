<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
    
	
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">首页(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="home" class="form-control" value="<?php  echo $setting['home'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">关于我们</label>
        <div class="col-sm-8">
			<select name="about" class="col-sm-8">
                <option value="0" <?php  if($setting['about']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['about']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">关于我们(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="about2" class="form-control" value="<?php  echo $setting['about2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">新闻</label>
        <div class="col-sm-8">
			<select name="news" class="col-sm-8">
                <option value="0" <?php  if($setting['news']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['news']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">新闻(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="news2" class="form-control" value="<?php  echo $setting['news2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发</label>
        <div class="col-sm-8">
			<select name="dingzhi" class="col-sm-8">
                <option value="0" <?php  if($setting['dingzhi']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['dingzhi']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">定制开发(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="dingzhi2" class="form-control" value="<?php  echo $setting['dingzhi2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序</label>
        <div class="col-sm-8">
			<select name="xiaochengxu" class="col-sm-8">
                <option value="0" <?php  if($setting['xiaochengxu']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['xiaochengxu']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">小程序(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="xiaochengxu2" class="form-control" value="<?php  echo $setting['xiaochengxu2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">解决方案</label>
        <div class="col-sm-8">
			<select name="solve" class="col-sm-8">
                <option value="0" <?php  if($setting['solve']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['solve']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">解决方案(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="solve2" class="form-control" value="<?php  echo $setting['solve2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">联系我们</label>
        <div class="col-sm-8">
			<select name="contact" class="col-sm-8">
                <option value="0" <?php  if($setting['contact']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['contact']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">联系我们(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="contact2" class="form-control" value="<?php  echo $setting['contact2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">代理加盟</label>
        <div class="col-sm-8">
			<select name="daili" class="col-sm-8">
                <option value="0" <?php  if($setting['daili']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['daili']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">代理加盟(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="daili2" class="form-control" value="<?php  echo $setting['daili2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">帮助中心</label>
        <div class="col-sm-8">
			<select name="help" class="col-sm-8">
                <option value="0" <?php  if($setting['help']!="1") { ?>selected<?php  } ?>>开启</option>
                <option value="1" <?php  if($setting['help']=="1") { ?>selected<?php  } ?>>关闭</option>
            </select>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">帮助中心(自定义)</label>
        <div class="col-sm-8">
			<input type="text" name="help2" class="form-control" value="<?php  echo $setting['help2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">自定义外链-名称1</label>
        <div class="col-sm-8">
			<input type="text" name="defname1" class="form-control" value="<?php  echo $setting['defname1'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">自定义外链-链接1</label>
        <div class="col-sm-8">
			请加http://或者https://
			<input type="text" name="defurl1" class="form-control" value="<?php  echo $setting['defurl1'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">自定义外链-名称2</label>
        <div class="col-sm-8">
			<input type="text" name="defname2" class="form-control" value="<?php  echo $setting['defname2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">自定义外链-链接2</label>
        <div class="col-sm-8">
			请加http://或者https://
			<input type="text" name="defurl2" class="form-control" value="<?php  echo $setting['defurl2'];?>" />
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