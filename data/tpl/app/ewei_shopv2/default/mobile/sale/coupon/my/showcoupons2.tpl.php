<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon.css?v=2.0.0">
<div class='fui-page  fui-page-current coupon-my-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">我的优惠券</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>
	<div class='fui-content'>

		<div class="coupon-headblock">
			<div class="top-layer"></div>
			<div class="line-layer"></div>
			<div class="bottom-layer"></div>
			<div class="gold"></div>
			<div class="link-text">请至【<a href="<?php  echo mobileUrl('sale/coupon/my')?>">我的优惠券</a>】查看</div>
			<div class="paper">
				<div class="title">恭喜获得</div>
				<div class="text">
					<i class="d1"></i>
					<i class="d2"></i>
					<p class="t1"><?php  echo $data['couponname']?></p>
				</div>
				<i class="line"></i>
				<i class="dot-top"></i>
				<i class="dot-left"></i>
				<i class="dot-right"></i>
				<i class="dot-1"></i>
				<i class="dot-2"></i>
				<i class="dot-3"></i>
				<i class="dot-4"></i>
				<i class="dot-5"></i>
				<i class="dot-6"></i>
			</div>
		</div>


		<div class="coupon-groupblock">
			<div class="group-top">
				<div class="inner">
					<div class="left"><?php  echo $title1?></div>
					<div class="right">
						<p class="title">优惠券</p>
						<p class="subtitle"><?php  echo $title2?></p>
					</div>
				</div>
			</div>
			<div class="coupon-items">
				<div class="container1">
					<?php  if(is_array($goods)) { foreach($goods as $good) { ?>
						<a href="<?php  echo mobileUrl('goods/detail',array('id'=>$good['id']))?>">
						<span class="item">
							<div class="image">
								<img src="<?php  echo $good['thumb'];?>">
							</div>
							<div class="title"><?php  echo $good['title'];?></div>
							<div class="price">
								<div class="product">&yen;<?php  echo $good['minprice'];?></div>
								<div class="market">&yen;<?php  echo $good['couponprice'];?> <span>
									<?php  if($good['minprice']<$data['enough']) { ?>
										满额用劵价
									<?php  } else { ?>
										用劵价
									<?php  } ?>
								</span></div>
							</div>
								<span  class="text-primary">请以实际价格为准!</span>
						</span>
					</a>
					<?php  } } ?>
					<span class="item">
						<a href="<?php  echo mobileUrl('sale/coupon/my/showcoupongoods',array('id'=>$id))?>"data-nocache="true" class="more" style="display: block;">
								查看更多>>
						</a>
					</span>
				</div>
			</div>
		</div>
		<a href="<?php  echo mobileUrl('sale/coupon')?>">
			<div class="btn btn-danger block" style="margin: 0 0.5rem 0.5rem">继续领取优惠券</div>
		</a>

		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>