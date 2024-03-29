<?php defined('IN_IA') or exit('Access Denied');?><script id="tpl_cards" type="text/html">
	<!--<div class='card-list-modal in'></div>-->
	<div class='card-list-group in'>
		<div class='card-list-title'>选择会员卡</div>
		<div class='card-list-cancel'>
			<div class='text'>不使用会员卡</div>
			<div class='btn-card-cancel icon '><i class="icon icon-wancheng"></i></div>
		</div>
		<div class='card-list-content card-picker'>
			<%each cards as card%>
			<div class='item <%card.card_style%>'>
				<div  class='iconselect'  data-cardnname="<%card.name%>"  data-cardprice="<%card.price%>" data-cardid="<%card.id%>"><i class="icon icon-roundcheckfill"></i></div>
				<i class="iconbg icon icon-huangguan-line"></i>
				<div class='content'>
					<div class='title'><i class="icon icon-huangguan"></i><%card.name%></div>
					<%if card.expire_time==-1%>
					<div class='date'>有效期：永久有效</div>
					<%else%>
					<div class='date'>有效期至：<% card.expire_time%></div>
					<%/if%>
					<div class='tip'>
						<%if card.member_discount>0%>
						<div class='tip-item'><% card.discount_rate %>折</div>
						<%/if%>
						<%if card.shipping==1%>
						<div class='tip-item'>包邮</div>
						<%/if%>
						<%if card.is_card_coupon||card.is_month_coupon%>
						<div class='tip-item'>优惠券</div>
						<%/if%>
						<%if card.is_card_points%>
						<div class='tip-item'>积分</div>
						<%/if%>

					</div>
				</div>
			</div>
			<%/each%>
			<div class="fui-loading empty">
				<div class="text" style="background: #fff;">没有更多了</div>
			</div>
		</div>
	</div>
</script>