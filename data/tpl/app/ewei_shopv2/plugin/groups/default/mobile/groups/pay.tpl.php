<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='fui-page order-pay-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back" onclick='history.back()'></a>
		</div>
		<div class="title" style='margin-right:-2rem;'>收银台</div>
		<div class="fui-header-right">
			<a href="<?php  echo mobileUrl('groups/orders')?>"><?php  if(!is_h5app()) { ?>我的<?php  } ?>订单</a>
		</div>
	</div>
	<div class='fui-content margin'>
		<div class="fui-cell-group">
			<div class="fui-cell">
				<div class="fui-cell-label">订单编号</div>
				<div class="fui-cell-info"></div>
				<div class="fui-cell-remark noremark"><?php  echo $order['orderno'];?></div>
			</div>
			<div class="fui-cell">
				<div class="fui-cell-label">订单金额</div>
				<div class="fui-cell-info"></div>
				<div class="fui-cell-remark noremark"><span class='text-danger'>¥ <?php  echo number_format($order['price'] - $order['creditmoney'] + $order['freight'],2)?></span></div>
			</div>
		</div>


		<div class='fui-list-group' style="margin-top:10px;">
			<?php  if($wechat['success'] || (is_h5app() && $payinfo['wechat'])) { ?>
			<div class='fui-list pay-btn' data-type='wechat'>
				<div class='fui-list-media'>
					<i class='icon icon-wechat wechat'></i>
				</div>
				<div class='fui-list-inner'>
					<div class="title">微信支付</div>
					<div class="subtitle">微信安全支付</div>
				</div>
				<div class='fui-list-angle'><span class="angle"></span></div>
			</div>
			<?php  } ?>
			<?php  if($credit['success']) { ?>
			<div class='fui-list pay-btn' data-type='credit'>
				<div class='fui-list-media'>
					<i class='icon icon-money credit'></i>
				</div>
				<div class='fui-list-inner'>
					<div class="title">余额支付</div>
					<div class="subtitle">当前余额: <span class='text-danger'>¥ <?php  echo number_format($member['credit2'],2)?></span></div>
				</div>
				<div class='fui-list-angle'>
		    <span class="angle">

		    </span>
				</div>
			</div>
			<?php  } ?>
			<?php  if($cash['success']) { ?>
			<div class='fui-list pay-btn' data-type='cash'>
				<div class='fui-list-media'>
					<i class='icon icon-deliver1 cash'></i>
				</div>
				<div class='fui-list-inner'>
					<div class="title">货到付款</div>
					<div class="subtitle">收到商品后进行付款</div>
				</div>
				<div class='fui-list-angle'><span class="angle"></span></div>
			</div>
			<?php  } ?>

		</div>
	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH)) : (include template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH));?>
	<script language='javascript'>
		require(['../addons/ewei_shopv2/plugin/groups/static/js/pay.js'], function (modal) {modal.init(<?php  echo json_encode($payinfo)?>); });
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
