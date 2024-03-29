<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/index.css?v=1.0.0">
<style type="text/css">
	.fui-content{
		top: 2rem;
	}
	.fui-list-group{
		margin-top: 0;
	}
	.cav_list .fui-list{
		padding: 0.85rem 0.6rem;
	}
	.cav_list .fui-list-media img{
		width: 4rem;
		height: 4rem;
	}
	.fui-list-inner,.fui-list-angle{
		height:4rem;
		font-size: 0.6rem;
	}
	.fui-list-angle{
		width:5rem;
		text-align: right;
		margin-right: .1rem;
		font-size: .55rem;
		position: relative;
	}
	.use{
		height: 1.2rem;
		line-height: 1.2rem;
		position: absolute;
		border: 1px solid #ff5555;
		border-radius: 10px;
		color: #ff5555;
		text-align: center;
		font-size: 0.55rem;
		bottom:0.85rem;
		right: 0.6rem;
		padding:0 0.3rem;
	}
	.use i{
		display: inline-block;
		/*vertical-align: middle;*/
		font-size: 0.55rem;
	}
	.fui-list-inner .title,.fui-list-inner .subtitle{
		font-size: 0.65rem;
		line-height: 1.2rem;
	}
	.fui-list-inner .subtitle,.fui-list-inner .text{
		color: #999;

	}
	.fui-list-inner .text{
		font-size: 0.6rem;
	}
	.page-goods-detail .fui-tab:not(.detail-tab){
		width:100%;
		margin: 0;
		background: #fff;
		border-top:1px solid #efefef;
	}
</style>
<div class="fui-header">
	<div class="fui-header-left">
		<a class="back"></a>
	</div>
	<div class="title">记次时商品信息</div>
	<div class="fui-header-right">
		<a href="<?php  echo mobileUrl('sale/coupon/my')?>" class="external">
			<i class="icon icon-person2"></i>
		</a>
	</div>
</div>
<div class="fui-page page-goods-detail fui-page-current cav_list" style="top: 2.2rem;">
	<div id="cateTab" class="fui-tab fui-tab-danger">
		<a data-cate="" class="tab active">未完成</a>
		<a data-cate="used" class="tab">已完成</a>
		<a data-cate="past" class="tab">已过期</a>
	</div>


	<div class="fui-message fui-message-popup in content-empty" style="display: none; margin-top: 0; padding-top: 0; position: relative; height: auto; background: none;">
		<div class="icon ">
			<i class="icon icon-information"></i>
		</div>
		<div class="content">您还没有记次时商品</div>
	</div>

	<div class='infinite-loading' style="text-align: center; color: #666;">
		<span class='fui-preloader'></span>
		<span class='text'> 正在加载...</span>
	</div>

	<!--	<div  id="container" class="fui-content basic-block">
        </div>-->

	<div class="fui-content">
		<div class="coupon-list-group"  id="container" style="margin-top: 0.25rem">
		</div>
	</div>

	<script id='tpl_list_verifygood_my' type='text/html'>
		<%each list as verifygood%>
		<a class="coupon-list
			<%if  verifygood.expired == 1%>
			gray
			<%else%>
				<%if  verifygood.canuse == 1%>
					<% if verifygood.numlimit==1%>
						blue
						<%else%>
						green
					<%/if%>
				<%else%>
				 <% if verifygood.numlimit==1%>
					 blue
					<%else%>
					 green
					 <%/if%>
				 <%/if%><%/if%>"
		<%if verifygood.cangetcard%> href="javascript:;" onclick="addCard('<%=verifygood.card_id%>','<%=verifygood.cardcode%>')"<%else%>href="<?php  echo mobileUrl('verifygoods/detail')?>&id=<%verifygood.id%>" <%/if%>>
		<div class="coupon-left">
			<div class="coupon-title">
				<div class="coupon-list-media">
					<img src="<%=verifygood.thumb%>"/>
				</div>
				<div class="coupon-inner">
					<div>
						<%=verifygood.title%>
					</div>
				</div>
			</div>
			<div class="coupon-time">
				有效日期：<%=verifygood.termofvalidity%>
			</div>
		</div>
		<div class="coupon-right">
			<div class="text"><% if verifygood.numlimit==1%>可用次数<%else%>剩余天数<%/if%></div>
			<div class="num"><span><%=verifygood.surplusnum%></span></div>
		</div>
		<%if  verifygood.canuse == 1%>
		<%if verifygood.cangetcard%>
		<div class="mask">
			<span href="">点击激活</span>
		</div>
		<%/if%>
		<%/if%>

		</a>

		<%/each%>
	</script>
	<script language='javascript'>
        require(['biz/verifygoods/list'], function (modal) {modal.init();});


        function addCard(card_id,code) {

            var data = {'openid': '<?php  echo $_W["openid"]?>', 'card_id': card_id, 'code': code};
            $.ajax({
                url: "<?php  echo mobileUrl('sale/coupon/getsignature')?>",
                data: data,
                cache: false
            }).done(function (result) {
                var data = jQuery.parseJSON(result);
                if (data.status == 1) {
                    wx.addCard({
                        cardList: [
                            {
                                cardId: card_id,
                                cardExt: data.result.cardExt
                            }
                        ],
                        success: function (res) {
                            //alert('已添加卡券：' + JSON.stringify(res.cardList));
                        },
                        cancel: function (res) {
                            //alert(JSON.stringify(res))
                        }
                    });
                } else {
                    alert("微信接口繁忙,请稍后再试!");
                    alert(data.result.message);
                }
            });
        }


	</script>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>