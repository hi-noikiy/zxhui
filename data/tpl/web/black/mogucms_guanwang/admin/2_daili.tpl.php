<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
    
	
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">市场分析</label>
        <div class="col-sm-8">
            <input type="text" name="title1" class="form-control" value="<?php  echo $setting['title1'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">市场分析(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title2" class="form-control" value="<?php  echo $setting['title2'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">定制开发</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('title3', $setting['title3']);?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作，你能获得什么？</label>
        <div class="col-sm-8">
            <input type="text" name="title4" class="form-control" value="<?php  echo $setting['title4'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作，你能获得什么？(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title5" class="form-control" value="<?php  echo $setting['title5'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标1</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title6', $setting['title6'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题1</label>
        <div class="col-sm-8">
            <input type="text" name="title7" class="form-control" value="<?php  echo $setting['title7'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述1</label>
        <div class="col-sm-8">
            <input type="text" name="title8" class="form-control" value="<?php  echo $setting['title8'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标2</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title9', $setting['title9'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题2</label>
        <div class="col-sm-8">
            <input type="text" name="title10" class="form-control" value="<?php  echo $setting['title10'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述2</label>
        <div class="col-sm-8">
            <input type="text" name="title11" class="form-control" value="<?php  echo $setting['title11'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标3</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title12', $setting['title12'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题3</label>
        <div class="col-sm-8">
            <input type="text" name="title13" class="form-control" value="<?php  echo $setting['title13'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述3</label>
        <div class="col-sm-8">
            <input type="text" name="title14" class="form-control" value="<?php  echo $setting['title14'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标4</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title15', $setting['title15'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题4</label>
        <div class="col-sm-8">
            <input type="text" name="title16" class="form-control" value="<?php  echo $setting['title16'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述4</label>
        <div class="col-sm-8">
            <input type="text" name="title17" class="form-control" value="<?php  echo $setting['title17'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标5</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title18', $setting['title18'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题5</label>
        <div class="col-sm-8">
            <input type="text" name="title19" class="form-control" value="<?php  echo $setting['title19'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述5</label>
        <div class="col-sm-8">
            <input type="text" name="title20" class="form-control" value="<?php  echo $setting['title20'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-图标6</label>
        <div class="col-sm-8">
			图大小:72*72
            <?php  echo tpl_form_field_image('title21', $setting['title21'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-标题6</label>
        <div class="col-sm-8">
            <input type="text" name="title22" class="form-control" value="<?php  echo $setting['title22'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">合作-描述6</label>
        <div class="col-sm-8">
            <input type="text" name="title23" class="form-control" value="<?php  echo $setting['title23'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">我们需要这样的你</label>
        <div class="col-sm-8">
            <input type="text" name="title24" class="form-control" value="<?php  echo $setting['title24'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">我们需要这样的你(英文)</label>
        <div class="col-sm-8">
            <input type="text" name="title25" class="form-control" value="<?php  echo $setting['title25'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">条件1</label>
        <div class="col-sm-8">
            <input type="text" name="title26" class="form-control" value="<?php  echo $setting['title26'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">条件2</label>
        <div class="col-sm-8">
            <input type="text" name="title27" class="form-control" value="<?php  echo $setting['title27'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">条件3</label>
        <div class="col-sm-8">
            <input type="text" name="title28" class="form-control" value="<?php  echo $setting['title28'];?>" />
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">条件4</label>
        <div class="col-sm-8">
            <input type="text" name="title29" class="form-control" value="<?php  echo $setting['title29'];?>" />
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