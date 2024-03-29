<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/groups/template/mobile/default/css/style.css?v=2018530" />
<style type="text/css">
.order_goods_img img {border: 1px solid rgb(215, 215, 215); border-image: none; width: 60px; height: 60px; display: block;}
.order_goods_price i {font-size: 9px;}
.order_goods_grab .order_goods_grab_txt {background: 0px 0px rgb(238, 51, 17); padding: 2px 3px; border-radius: 2px; color: rgb(255, 255, 255); display: inline-block;}
.tuan_g_price b {font-size: 18px; font-weight: 400; margin-right: 2px; margin-left: 5px;}
.tuan_g_price span {vertical-align: 1px;}
.order_status {height: 30px; color: rgb(221, 0, 0); line-height: 40px; float: left;}
.order_btn a {border-radius: 3px; width: 80px; height: 30px; text-align: center; color: rgb(255, 255, 255); line-height: 30px; margin-left: 5px; float: left; background-color: rgb(75, 75, 75); -webkit-border-radius: 3px;
}
#container{margin:0;background: none;}
.fui-list-angle span.text-danger{color: #ef4f4f;}
</style>
<div class='fui-page order-list-page'>
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back" href="<?php  echo mobileUrl('order')?>"></a>
	</div>
	<div class="title">我的团</div>
	<div class="fui-header-right">&nbsp;</div>
    </div>
	<div class="fui-tab fui-tab-danger" id="tab">
		<a class="active" data-tab='success'>组团中</a>
		<a href="javascript:void(0)" data-tab='success0'>组团成功</a>
		<a href="javascript:void(0)" data-tab='success1'>组团失败</a>
	</div>
    <div class='fui-content navbar order-list' style="padding-bottom:0;">
		<div class='fui-content-inner'>
			<div class='content-loading'>
				<span class='fui-preloader'></span>
				<span class='text'>正在加载...</span>
			</div>
			<div class='content-empty'>
				<i class='icon icon-lights'></i><br/>暂时没有参加任何团
			</div>
			<div class="fui-according-group" id="container"></div>
		</div>
    </div>
	<script id='tpl_groups_team_list' type='text/html'>
		<%each list as order%>
		<div class='lynn_order_item'>
			<a href="<?php  echo mobileUrl('groups/team/detail');?>&orderid=<%order.id%>&teamid=<%order.teamid%>" class="external">
				<div class='lynn_order_title'>
					订单号: <%order.orderno%>
					<span class="order_status" style="float:right;">
						<%if order.itemnum == order.groupnum%>
							团购已成功
						<%else%>
							<%if order.success == 1%>
							团购已成功
							<%else%>
								<%if order.lasttime >0%>
									<%if order.status==0%>
										未支付
									<%else if order.itemnum < order.groupnum%>
										<%if order.status > 0%>
										团购进行中
										<%else%>
										团购已取消
										<%/if%>
									<%/if%>
								<%else%>
									团购已过期
								<%/if%>
							<%/if%>
						<%/if%>
					</span>
				</div>
				<div class="fui-list lynn_order_list">
					<div class="fui-list-media">
						<img src="<%order.thumb%>" class="round">
					</div>
					<div class="fui-list-inner">
						<div class="lynn_order_list_title"><%order.title%></div>
						<div class="lynn_order_list_subtitle"><?php  echo $order['option_name'];?></div>
						<%if order.more_spec =='1'%><div class="lynn_order_list_subtitle"><%order.option_name%></div><%/if%>
						<%if order.is_ladder =='1'%><div class="lynn_order_list_subtitle"><%order.ladder_num%>人团</div><%/if%>
					</div>
					<div class='fui-list-angle'>
						<span class='marketprice text-danger'>¥ <%order.groupsprice%></span>/<%if order.units%><%order.goodsnum%><%order.units%><%else%>1件<%/if%><br/>
						x1
					</div>
				</div>
				<div class='lynn_order_price'>
					<span class='status'>
						共 <span class='text-danger'>1</span> 个商品
						总额: <span class='text-danger'>¥ <%order.amount%></span>元
					</span>
				</div>
			</a>
			<div class='lynn_order_bottom'>
				<span class="status">
				<%if order.status == 3 || order.status == -1%>
					<a class="lynn_btn lynn_btn_danger" href="<?php  echo mobileUrl('groups/goods');?>&id=<%order.goodid%>">再拼一单</a>
				<%/if%>
					<a class="external lynn_btn lynn_btn_danger" href="<?php  echo mobileUrl('groups/team/detail');?>&orderid=<%order.id%>&teamid=<%order.teamid%>">查看团详情</a>
				</span>
			</div>
		</div>
		<%/each%>
	</script>
	<script language='javascript'>
		require(['../addons/ewei_shopv2/plugin/groups/static/js/team.js'], function (modal) {
			modal.init({fromDetail:false});
		});
	</script>
</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>