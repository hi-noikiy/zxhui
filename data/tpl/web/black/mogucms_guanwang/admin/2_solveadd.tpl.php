<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<form action="" method="post" class="article-post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php  echo $id;?>">
	<div class="form-group">
        <label for="" class="control-label col-sm-2">类型</label>
        <div class="form-controls col-sm-8">
            <select class="form-control" name="category">
				<?php  if(is_array($categorynews)) { foreach($categorynews as $cn) { ?>
				<option value="<?php  echo $cn['id'];?>" <?php  if($cn['id']==$list['category']) { ?>selected<?php  } ?>><?php  echo $cn['categoryname'];?></option>
				<?php  } } ?>
			</select>

        </div>
    </div>
    <div class="form-group">
        <label for="" class="control-label col-sm-2">标题</label>
        <div class="form-controls col-sm-8">
            <input type="text" class="form-control" name="title" value="<?php  echo $list['title'];?>">
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">访问量</label>
        <div class="form-controls col-sm-8">
			<input type="text" class="form-control" name="count" value="<?php  echo $list['count'];?>">
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">图片</label>
        <div class="form-controls col-sm-8">
			大小：274*254
            <?php  echo tpl_form_field_image('image', $list['image'], '');?>
        </div>
    </div>
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">二维码</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_form_field_image('erweima', $list['erweima'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label for="" class="control-label col-sm-2">内容</label>
        <div class="form-controls col-sm-8">
            <?php  echo tpl_ueditor('content', $list['content']);?>
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">keywords</label>
        <div class="form-controls col-sm-8">
            <input type="text" class="form-control" name="keywords" value="<?php  echo $list['keywords'];?>">
        </div>
    </div>
	<div class="form-group">
        <label for="" class="control-label col-sm-2">description</label>
        <div class="form-controls col-sm-8">
            <input type="text" class="form-control" name="description" value="<?php  echo $list['description'];?>">
        </div>
    </div>
    <input name="submit" value="发布" class="btn btn-primary btn-submit" type="submit">
    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	<?php  if($_GPC['act']=="edit") { ?>
	<input type="hidden" name="url" value="<?php  echo str_replace('&act=edit&mid='.$_GPC['mid'],'',$_W['siteurl'])?>" />
	<?php  } else { ?>
	<input type="hidden" name="url" value="<?php  echo str_replace('&act=solveadd','',$_W['siteurl'])?>" />
	<?php  } ?>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>