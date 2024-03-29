<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>购物优惠券<small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['couponname'];?>】<?php  } ?></small></span>
</div>

<div class="page-content">
	<div class="page-sub-toolbar">
		<span class=''>
			<?php if(mcv('sale.coupon.add')) { ?>
				<a class='btn btn-primary btn-sm' href="<?php  echo merchUrl('sale/coupon/add')?>"><i class='fa fa-plus'></i> 添加购物优惠券</a>
			<?php  } ?>
		</span>
	</div>
	<form <?php if( mce('sale.coupon' ,$item) ) { ?>action="" method='post'<?php  } ?> class='form-horizontal form-validate'>
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
	 <input type="hidden" name="tab" id='tab' value="<?php  echo $_GPC['tab'];?>" />
		<ul class="nav nav-arrow-next nav-tabs" id="myTab">
			<li <?php  if($_GPC['tab']=='basic' || empty($_GPC['tab'])) { ?>class="active"<?php  } ?> ><a href="#tab_basic">基本</a></li>
			<li <?php  if($_GPC['tab']=='center') { ?>class="active"<?php  } ?> ><a href="#tab_center">领取设置</a></li>
			<li <?php  if($_GPC['tab']=='limit') { ?>class="active"<?php  } ?> ><a href="#tab_limit">使用限制</a></li>
			<li <?php  if($_GPC['tab']=='resp') { ?>class="active"<?php  } ?> ><a href="#tab_resp">推送</a></li>
			<li <?php  if($_GPC['tab']=='usage') { ?>class="active"<?php  } ?> ><a href="#tab_usage">使用说明</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane  <?php  if($_GPC['tab']=='basic' || empty($_GPC['tab'])) { ?>active<?php  } ?>" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/post/basic', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/post/basic', TEMPLATE_INCLUDEPATH));?></div>
			<div class="tab-pane  <?php  if($_GPC['tab']=='center') { ?>active<?php  } ?>" id="tab_center"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/post/center', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/post/center', TEMPLATE_INCLUDEPATH));?></div>
			<div class="tab-pane  <?php  if($_GPC['tab']=='limit') { ?>active<?php  } ?>" id="tab_limit"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/post/limit', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/post/limit', TEMPLATE_INCLUDEPATH));?></div>
			<div class="tab-pane  <?php  if($_GPC['tab']=='resp') { ?>active<?php  } ?>" id="tab_resp" ><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/post/resp', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/post/resp', TEMPLATE_INCLUDEPATH));?></div>
			<div class="tab-pane  <?php  if($_GPC['tab']=='usage') { ?>active<?php  } ?>" id="tab_usage" ><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/post/usage', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/post/usage', TEMPLATE_INCLUDEPATH));?></div>
		</div>

		<div class="form-group"></div>
		<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					 <?php if( mce('sale.coupon' ,$item) ) { ?>
						<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />

					<?php  } ?>
				   <input type="button" name="back" onclick='history.back()' <?php if( mce('sale.coupon' ,$item) ) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
				</div>
		</div>
	</form>
</div>
<script language='javascript'>
      require(['bootstrap'],function(){
             $('#myTab a').click(function (e) {
                 e.preventDefault();
                $('#tab').val( $(this).attr('href'));
                 $(this).tab('show');
             })
     });

    function showbacktype(type){

        $('.backtype').hide();
        $('.backtype' + type).show();
    }
	$(function(){

		$('form').submit(function(){

			if($(':input[name=couponname]').isEmpty()){
				Tip.focus($(':input[name=couponname]'),'请输入优惠券名称!');
				return false;
			}
			var backtype = $(':radio[name=backtype]:checked').val();
			if(backtype=='0'){
				if($(':input[name=deduct]').isEmpty()){
					Tip.focus($(':input[name=deduct]'),'请输入立减多少!');
					return false;
				}
			}else if(backtype=='1'){
				if($(':input[name=discount]').isEmpty()){
					Tip.focus($(':input[name=discount]'),'请输入折扣多少!');
					return false;
				}
			}
			return true;
		})

	})
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
