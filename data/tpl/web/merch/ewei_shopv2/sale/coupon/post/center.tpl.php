<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
    .label-italic{font-weight: normal; font-style: italic;}
    .a-inline{margin-top: 6px}
    .input-sm{padding:2px;}
</style>
<div class="form-group">
    <label class="col-lg control-label">加入领券中心</label>
    <div class="col-sm-9 col-xs-12" >
        <?php if( mce('sale.coupon' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="gettype" value="1" <?php  if($item['gettype'] == 1) { ?>checked="true"<?php  } ?> onclick="$('.gettype').show()" /> 可以
        </label>
        <label class="radio-inline">
            <input type="radio" name="gettype" value="0" <?php  if($item['gettype'] == 0) { ?>checked="true"<?php  } ?>  onclick="$('.gettype').hide()"/> 不可以
        </label>
        <span class='help-block'>会员是否可以在领券中心直接领取或购买</span>

        <?php  } else { ?> <div class='form-control-static'>
        <?php  if($item['gettype']==1) { ?>可以<?php  } else { ?>不可以<?php  } ?>
    </div>
        <?php  } ?>
    </div>
</div>
<div class="gettype" <?php  if($item['gettype']!=1) { ?>style="display:none"<?php  } ?>>

<?php if( mce('sale.coupon' ,$item) ) { ?>

<div class="form-group gettype" >
    <label class="col-lg control-label">标签文字</label>
    <div class="col-sm-9 col-xs-12" >
        <div class="input-group">
            <?php if( mce('sale.coupon' ,$item) ) { ?>
            <input type='text' class='form-control' value="<?php  echo $item['tagtitle'];?>" name='tagtitle' maxlength="8"/>
            <?php  } else { ?>
            <?php  echo $item['title'];?>
            <?php  } ?>
        </div>
    </div>
</div>
<div class="form-group gettype">
    <label class="col-lg control-label">是否自定义标签颜色</label>
    <div class="col-sm-9 col-xs-12" >
        <?php if( mce('sale.coupon' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="settitlecolor" value="1" <?php  if($item['settitlecolor'] == 1) { ?>checked="true"<?php  } ?> onclick="$('.setcolor').show()" /> 可以
        </label>
        <label class="radio-inline">
            <input type="radio" name="settitlecolor" value="0" <?php  if($item['settitlecolor'] == 0) { ?>checked="true"<?php  } ?>  onclick="$('.setcolor').hide()"/> 不可以
        </label>

        <span class='help-block'>会员是否自定义领券中心标签文字的底色,如果不定义则使用默认颜色风格</span>
        <?php  } else { ?> <div class='form-control-static'>
        <?php  if($item['settitlecolor']==1) { ?>可以<?php  } else { ?>不可以<?php  } ?>
    </div>
        <?php  } ?>
    </div>
</div>

<div class="form-group setcolor" <?php  if($item['settitlecolor']!=1) { ?>style="display:none"<?php  } ?>>
<label class="col-lg control-label">标签颜色</label>
<div class="col-sm-3 col-xs-3" >
    <div class="input-group">

        <?php if( mce('sale.coupon' ,$item) ) { ?>
        <input  class="form-control input-sm diy-bind color" name="titlecolor" value="<?php  echo $item['titlecolor'];?>" type="color" />
        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#fafafa').trigger('propertychange')">重置</span>
        <?php  } else { ?>
        <span style="width:15px; background: <?php  echo $item['titlecolor'];?>"> </span>
        <?php  } ?>
    </div>
</div>
</div>

<div class="form-group gettype" >
    <label class="col-lg control-label">领取限制</label>
    <div class="col-sm-9 col-xs-12" >
        <div class="input-group fixsingle-input-group">
            <span class="input-group-addon">每个限领</span>
            <input type='text' class='form-control' value="<?php  echo $item['getmax'];?>" name='getmax'/>
            <span class="input-group-addon">张</span>
        </div>
    </div>
</div>
<div class="form-group gettype" >
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12" >

        <div class="input-group fixmore-input-group">

            <span class="input-group-addon">消耗</span>
            <input type='text' class='form-control' value="<?php  echo $item['credit'];?>" name='credit'/>
            <span class="input-group-addon">积分 + 花费</span>
            <input type='text' class='form-control' value="<?php  echo $item['money'];?>" name='money'/>
                                  <span class="input-group-addon">元&nbsp;&nbsp;
                                      <label class="checkbox-inline" style='margin-top:-8px;'>
                                          <input type="checkbox" name='usecredit2' value="1" <?php  if($item['usecredit2']==1) { ?>checked<?php  } ?> /> 优先使用余额支付
                                      </label>
                                  </span></div>
        <span class="help-block">每人限领，空不限制，领取方式可任意组合，可以单独积分兑换，单独现金兑换，或者积分+现金形式兑换, 如果都为空，则可以免费领取</span>

    </div>
</div>
<div class="form-group gettype" >
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12" >

    </div>
</div>
<?php  } else { ?>
<div class="form-group gettype" >
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12" >
        <div class='form-control-static'>消耗 <?php  echo $item['credit'];?> 积分 花费 <?php  echo $item['money'];?> 元现金</div>
    </div>
</div>
<?php  } ?>

</div>

