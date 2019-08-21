<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图1</label>
        <div class="col-sm-8">
			尺寸:78*78
            <?php  echo tpl_form_field_image('image1', $setting['image1'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">标题1</label>
        <div class="col-sm-8">
            <input type="text" name="title1" class="form-control" value="<?php  echo $setting['title1'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">描述1</label>
        <div class="col-sm-8">
            <input type="text" name="miaoshu1" class="form-control" value="<?php  echo $setting['miaoshu1'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图2</label>
        <div class="col-sm-8">
			尺寸:78*78
            <?php  echo tpl_form_field_image('image2', $setting['image2'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">标题2</label>
        <div class="col-sm-8">
            <input type="text" name="title2" class="form-control" value="<?php  echo $setting['title2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">描述2</label>
        <div class="col-sm-8">
            <input type="text" name="miaoshu2" class="form-control" value="<?php  echo $setting['miaoshu2'];?>" />
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图3</label>
        <div class="col-sm-8">
			尺寸:78*78
            <?php  echo tpl_form_field_image('image3', $setting['image3'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">标题3</label>
        <div class="col-sm-8">
            <input type="text" name="title3" class="form-control" value="<?php  echo $setting['title3'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">描述3</label>
        <div class="col-sm-8">
            <input type="text" name="miaoshu3" class="form-control" value="<?php  echo $setting['miaoshu3'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图4</label>
        <div class="col-sm-8">
			尺寸:78*78
            <?php  echo tpl_form_field_image('image4', $setting['image4'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">标题4</label>
        <div class="col-sm-8">
            <input type="text" name="title4" class="form-control" value="<?php  echo $setting['title4'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">描述4</label>
        <div class="col-sm-8">
            <input type="text" name="miaoshu4" class="form-control" value="<?php  echo $setting['miaoshu4'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图5</label>
        <div class="col-sm-8">
			尺寸:78*78
            <?php  echo tpl_form_field_image('image5', $setting['image5'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">标题5</label>
        <div class="col-sm-8">
            <input type="text" name="title5" class="form-control" value="<?php  echo $setting['title5'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">描述5</label>
        <div class="col-sm-8">
            <input type="text" name="miaoshu5" class="form-control" value="<?php  echo $setting['miaoshu5'];?>" />
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