<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    <span class="text-primary">入口设置</span>
</div>
<div class="page-content">
<form class="form-horizontal form-validate" role="form" method="post" novalidate="novalidate">
    <div class="form-group">
        <label class="col-sm-2 control-label">直接链接</label>
        <div class="col-sm-9 col-xs-12">
            <p class='form-control-static'>
                <a href='javascript:;' class="js-clip" title='点击复制链接' data-url="<?php  echo mobileUrl('task',array(),1)?>" >
                    <?php  echo mobileUrl('task',array(),1)?>
                </a>
                <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true"
                      data-content="<img src='<?php  echo m('qrcode')->createQrcode(mobileUrl('task',array(),1))?>'
                      width='130' alt='链接二维码'>" data-placement="auto right">
                    <i class="glyphicon glyphicon-qrcode"></i>
                </span>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">背景图</label>
        <div class="col-sm-9 col-xs-12">
            <?php  echo tpl_form_field_image('bg_img', tomedia($set['bg_img']))?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">会员中心入口</label>
        <div class="col-sm-9 col-xs-12">
            <label class="radio-inline">
                <input type="radio" name="entrance" value="1" <?php  if($set['entrance'] == 1) { ?>checked<?php  } ?>>开启
            </label>
            <label class="radio-inline">
                <input type="radio" name="entrance" value="0" <?php  if($set['entrance'] == 0) { ?>checked<?php  } ?>>关闭
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label must">关键词</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" class="form-control" name="keyword" value="<?php  echo $set['keyword'];?>" data-rule-required="true" aria-required="true">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面标题</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" class="form-control" name="cover_title" value="<?php  echo $set['cover_title'];?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面图片</label>
        <div class="col-sm-9 col-xs-12">
            <?php  echo tpl_form_field_image('cover_img', tomedia($set['cover_img']))?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面描述</label>
        <div class="col-sm-9 col-xs-12">
            <textarea name="cover_desc" class="form-control"><?php  echo $set['cover_desc'];?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10 col-xs-12">
            <button type="submit" class="btn btn-primary">保存</button>
        </div>
    </div>
</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>