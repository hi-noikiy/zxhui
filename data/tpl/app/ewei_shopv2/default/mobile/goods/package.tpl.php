<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	.fui-goods-group .fui-goods-item .detail .name{max-height:2rem;height:auto;line-height: 1rem;overflow: hidden;  color: #000;display: block}
	.fui-goods-group .fui-goods-item .detail .price{font-size:0.6rem;padding-top:0.1rem;}
	.fui-goods-group .fui-goods-item .detail .price .text{font-size:0.6rem}
	.fui-goods-group .fui-goods-item{border-bottom: 0}
</style>
<div class='fui-page  fui-page-current member-cart-page'>
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title"><?php  if($goodsid) { ?>相关套餐<?php  } else { ?>所有套餐<?php  } ?></div>

	<div class="fui-header-right">
		<?php  if(!empty($list)) { ?><a class="btn-edit">编辑</a><?php  } ?>
	</div>

    </div>

    <div class='fui-content navbar cart-list' style="bottom: 2.4rem">
		<div class="fui-goods-group container">
			<?php  if(is_array($packages)) { foreach($packages as $item) { ?>
			<div class="fui-goods-item fui-list">
				<a href="<?php  echo mobileUrl('goods/package/detail',array('pid'=>$item['pid']))?>">
					<div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
				</a>
				<div class="detail fui-list-inner">
					<a href="<?php  echo mobileUrl('goods/package/detail',array('pid'=>$item['id']))?>">
						<div class="name"><?php  echo $item['title'];?></div>
						<div class="price">
							商品总价：<span class="text">&yen;<?php  echo $item['goodsprice'];?></span>
						</div>
						<div class="price">
							套餐价格：<span class="text">&yen;<?php  echo $item['price'];?></span>
						</div>
					</a>
				</div>
			</div>
			<?php  } } ?>

		</div>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		$(".package-goods-img").height($(".package-goods-img").width());
	})
</script>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
