<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/groups/template/mobile/default/css/style.css?v=2018530" />
<style type="text/css">
	#container{margin:0;background: none;}
	.fui-list-angle span.text-danger{color: #ef4f4f;}
	.order-list-page .order-list .status:after{content: none;}
</style>
<div class='fui-page order-list-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back" href="<?php  echo mobileUrl('orders')?>"></a>
		</div>
		<div class="title">我的订单</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>
	<div class="fui-tab fui-tab-danger" id="tab">
		<a class="active" data-tab='status'>全部</a>
		<a href="javascript:void(0)" data-tab='status0'>待付款</a>
		<a href="javascript:void(0)" data-tab='status1'>待发货</a>
		<a href="javascript:void(0)" data-tab='status2'>待收货</a>
		<a href="javascript:void(0)" data-tab='status3'>已完成</a>
	</div>
	<div class='fui-content navbar order-list' style="padding-bottom:0;">
		<div class='fui-content-inner'>
			<div class='content-loading'>
				<span class='fui-preloader'></span>
				<span class='text'>正在加载订单...</span>
			</div>
			<div class='content-empty'>
				<i class='icon icon-lights'></i><br/>暂时没有任何订单
			</div>
			<div class="fui-according-group" id="container"></div>
		</div>
	</div>
	<script id='tpl_groups_order_list' type='text/html'>
		<%each list as order%>
		<div class='lynn_order_item'>
			<a href="<?php  echo mobileUrl('groups/orders/detail');?>&orderid=<%order.id%>&teamid=<%order.teamid%>">
				<div class='lynn_order_title'>
					订单号: <%order.orderno%>
					<span class="status <%order.statuscss%>"><%order.statusstr%></span>
				</div>
				<div class="fui-list lynn_order_list">
					<div class="fui-list-media">
						<img src="<%order.thumb%>" class="round" alt="<%order.title%>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg'">
					</div>
					<div class="fui-list-inner">
						<div class="lynn_order_list_title"><%order.title%></div>
						<%if order.is_ladder =='1' %>
						<%/if%>
						<%if order.more_spec == '1' %>
						<span style="font-size: 0.6rem;color: #999"> <%order.option_name%></span>
						<%/if%>
					</div>
					<div class='fui-list-angle'>
						<span class='marketprice text-danger'>
							¥ <%if order.is_team > 0%><%order.groupsprice%><%else%><%order.singleprice%><%/if%>
						</span>/<%if order.units%><%order.goodsnum%><%order.units%><%else%>1件<%/if%><br/>
						x1
					</div>
				</div>
				<div class='lynn_order_price'>
					<span class='status'>
						共 <span class='text-danger'><%if order.units%><%order.goodsnum%><%else%>1<%/if%></span> 件商品
						总额: <span class='text-danger'>¥ <%order.amount%></span>元
					</span>
				</div>
			</a>
			<div class='lynn_order_bottom'>
				<%if order.status==0%>
				<span class='status'>
					<div class="lynn_btn lynn_btn_cancel order-cancel">取消订单
						<select data-orderid="<%order.id%>">
							<option value="">不取消了</option>
							<option value="我不想买了">我不想买了</option>
							<option value="信息填写错误，重新拍">信息填写错误，重新拍</option>
							<option value="同城见面交易">同城见面交易</option>
							<option value="其他原因">其他原因</option>
						</select>
					</div>
					<a class="lynn_btn lynn_btn_danger" href="<?php  echo mobileUrl('groups/pay');?>&orderid=<%order.id%>&teamid=<%order.teamid%>">去付款</a>
				</span>
				<%/if%>
				<%if order.status == 3 || order.status == -1%>
				<span class="status">
					<div class="lynn_btn lynn_btn_cancel order-delete" data-orderid="<%order.id%>">
						删除订单
					</div>
				</span>
				<%/if%>
				<%if order.status==2 && order.isverify==0%>
				<span class='status'>
					<a class="lynn_btn lynn_btn_finish order-finish" data-orderid="<%order.id%>" href="">确认收货</a>
				</span>
				<%/if%>
				<%if order.isverify == 1 && order.status >0 && (order.success == 1 || order.is_team == 0) && order.vnum > 0 %>
				<span class='status'>
					<a class="lynn_btn lynn_btn_cancel order-verify" data-nocache="true" data-orderid="<%order.id%>" data-verifytype="<%order.verifytype%>" style="margin-left:.5rem;" >
						<i class="icon icon-qrcode" style="vertical-align: middle;"></i>
						<span>我要使用</span>
					</a>
				</span>
				<%/if%>
			</div>
		</div>
		<%/each%>
	</script>
	<script type='text/javascript'>
        require(['../addons/ewei_shopv2/plugin/groups/static/js/orders.js'], function (modal) {
            modal.init({fromDetail:false});
        });
	</script>
	<?php  if(com('verify')) { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('groups/orders/verify', TEMPLATE_INCLUDEPATH)) : (include template('groups/orders/verify', TEMPLATE_INCLUDEPATH));?>
	<?php  } ?>
</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>