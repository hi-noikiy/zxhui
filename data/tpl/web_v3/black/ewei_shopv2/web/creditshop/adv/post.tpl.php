<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>幻灯片 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['advname'];?>】<?php  } ?></small></span>
</div>
 
 <div class="page-content">
     <div class="page-sub-toolbar">
         <span class=''>
            <?php if(cv('creditshop.adv.add')) { ?>
                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('creditshop/adv/add')?>">添加新幻灯片</a>
            <?php  } ?>
        </span>
     </div>
    <form <?php if( ce('creditshop.adv' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
 
                <div class="form-group">
                    <label class="col-lg control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('creditshop.adv' ,$item) ) { ?>
                                <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                                <span class='help-block'>数字越大，排名越靠前</span>
                        <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $item['displayorder'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label must">幻灯片标题</label>
                    <div class="col-sm-9 col-xs-12 ">
                         <?php if( ce('creditshop.adv' ,$item) ) { ?>
                        <input type="text" id='advname' name="advname" class="form-control" value="<?php  echo $item['advname'];?>" data-rule-required="true" />
                         <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['advname'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">幻灯片图片</label>
                    <div class="col-sm-9 col-xs-12">
                         <?php if( ce('creditshop.adv' ,$item) ) { ?>
                        <?php  echo tpl_form_field_image2('thumb', $item['thumb'])?>
                        <span class='help-block'>建议尺寸:640 * 350 , 请将所有幻灯片图片尺寸保持一致</span>
                        <?php  } else { ?>
                            <?php  if(!empty($item['thumb'])) { ?>
                                  <a href='<?php  echo tomedia($item['thumb'])?>' target='_blank'>
                            <img src="<?php  echo tomedia($item['thumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                                  </a>
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">幻灯片链接</label>
                    <div class="col-sm-9 col-xs-12">
                         <?php if( ce('creditshop.adv' ,$item) ) { ?>
                        <input type="text" name="link" class="form-control" value="<?php  echo $item['link'];?>" data-rule-url="true" />
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['link'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">状态</label>
                    <div class="col-sm-9 col-xs-12">
                            <?php if( ce('creditshop.adv' ,$item) ) { ?>
                        <label class='radio-inline'>
                            <input type='radio' name='enabled' value=1' <?php  if($item['enabled']==1) { ?>checked<?php  } ?> /> 显示
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='enabled' value=0' <?php  if($item['enabled']==0) { ?>checked<?php  } ?> /> 隐藏
                        </label>
                     <?php  } else { ?>
                            <div class='form-control-static'><?php  if(empty($item['enabled'])) { ?>隐藏<?php  } else { ?>显示<?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>
            
            <div class="form-group">
                    <label class="col-lg control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                           <?php if( ce('creditshop.adv' ,$item) ) { ?>
                            <input type="submit" value="提交" class="btn btn-primary"  />
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('creditshop.adv')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
            </div>
 
    </form>

 </div>
<script language='javascript'>
    function formcheck() {
        if ($("#advname").isEmpty()) {
            Tip.focus("advname", "请填写幻灯片名称!");
            return false;
        }
        return true;
    }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
