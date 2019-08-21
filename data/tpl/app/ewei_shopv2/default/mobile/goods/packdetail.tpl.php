<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.option{height:1.2rem;-webkit-appearance: none;padding:0 0.2rem;font-size:0.6rem;-webkit-border-radius: 0.2rem;-moz-border-radius: 0.2rem;border-radius: 0.2rem;background: #fff;
	display: inline-block;border:1px solid #666;line-height: 1.1rem;max-width: 100%;overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;}
	.dispatching-info i{margin:0.1rem;-webkit-border-radius: 0.2rem;border-radius: 0.2rem;}
	.dispatching-info i.active{border:1px solid #ef4f4f;background: #ef4f4f;color:#fff;}
	.goods_option{padding:0.2rem 0.5rem;background: #fff;border-bottom:1px solid #D9D9D9;font-size:0.6rem;color:#ef4f4f;}
	.fui-header .title{padding:0 10%;}
</style>
<div class='fui-page  fui-page-current member-cart-page member-cart-page2'>
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title"><?php  echo $package['title'];?></div>

	<div class="fui-header-right"></div>

    </div>

    <div class='fui-content navbar cart-list' style="bottom: 4.8rem">


	<!--<div class='content-empty' <?php  if(!empty($list)) { ?>style='display:none;'<?php  } ?>>
	     <i class='icon icon-cart'></i><br/>购物车空空如也~<br/><a href="<?php  echo mobileUrl()?>" class='btn btn-default-o external'>主人快去给我找点东西吧</a>
	</div>-->
	<?php  if(count($packgoods)>0) { ?>
	<div class="fui-list-group" id="container">
	    <?php  if(is_array($packgoods)) { foreach($packgoods as $index => $item) { ?>
		<div class="fui-list goods-item align-start" id="goodsid<?php  echo $index;?>" data-goodsid="<?php  echo $item['goodsid'];?>">
			<div class="fui-list-media image-media">
				<a href="<?php  echo mobileUrl('goods/detail',array('id'=>$item['goodsid']))?>">
					<img class="round package-goods-img" src="<?php  echo tomedia($item['thumb'])?>" data-lazyloaded="true">
				</a>
			</div>
			<div class="fui-list-inner">
				<a href="<?php  echo mobileUrl('goods/detail',array('id'=>$item['goodsid']))?>">
					<div class="text towline"><?php  echo $item['title'];?></div>
				</a>
				<?php  if(!empty($item['option'])) { ?>
				<div class="text cart-option cartmode">
					<span class="option optionbtn packoption<?php  echo $item['goodsid'];?>" data-goodsid="<?php  echo $item['goodsid'];?>">请选择规格</span>
					<input type="hidden" class="inputoption<?php  echo $item['goodsid'];?>" id="optionid<?php  echo $index;?>" value="">
				</div>
				<?php  } ?>
			</div>
			<div class="fui-list-angle">
				<span class="price">&yen;<span class="marketprice  marketprice<?php  echo $item['goodsid'];?>"><?php  echo $item['packageprice'];?></span></span>
				<span class="price" style="justify-content: flex-end"><span class="">x1</span></span>
			</div>
		</div>
	    <?php  } } ?>
		<script type="text/javascript">
			$(function(){
				$(".package-goods-img").height($(".package-goods-img").width());
			})
		</script>
	</div>
		<div class="goods_option" style="display: none;">
			如果商品不选择规格，则默认随机发送。
		</div>
		<?php  } ?>
    </div>

    <?php  if(!empty($packgoods)) { ?>
    <div class="fui-footer cartmode" style="bottom: 0rem">
	<div class="fui-list noclick" style="padding:0;">
	    <div class="fui-list-inner" style="padding:0.2rem 0.5rem 0.2rem 0.5rem;">
			<div class='subtitle'>
				套餐价格：<span class="text-danger bigprice">&yen;</span><span class='text-danger totalprice  bigprice'><?php  echo number_format($package['price'],2)?></span>
			</div>
			<div class='text' style="display: none;">
				<?php  if($package['freight']) { ?>(含邮费 &yen;<?php  echo number_format($package['freight'],2)?>)<?php  } else { ?>免邮费<?php  } ?>
			</div>
	    </div>
	    <div class='fui-list-angle package-buy' style="height: 2.45rem">
			<a href="javascript:void(0);" id="package-buy-a" class="package-buy-a">立即购买</a>
	    </div>
	</div>
    </div>
    <?php  } ?>
</div>

<div id='option-picker-modal' style="margin-top: -100%;display: none;">
	<div class='city-picker'>
		<div class="fui-cell-group fui-sale-group" style='margin-top:0;'>
			<div class="fui-cell">
				<div class="fui-cell-text dispatching">
					请选择规格:
					<div class="dispatching-info">

					</div>
				</div>
			</div>
			<div class='btn btn-danger block'>确定</div>
		</div>
	</div>
</div>

<script language='javascript'>
	require(['biz/goods/packdetail'], function (modal) {
	modal.init({packageid:"<?php  echo $package['id'];?>"});
});</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>