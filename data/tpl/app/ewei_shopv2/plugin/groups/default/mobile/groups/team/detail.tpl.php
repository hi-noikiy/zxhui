<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php  if($groupsset['followbar'] ==1) { ?>
<?php  $this->followBar()?>
<?php  } ?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/groups/template/mobile/default/css/style.css?v=2018530" />
<style type="text/css">
	i{font-style: normal;}
	.order_goods_img img {border: 1px solid rgb(215, 215, 215); border-image: none; width: 60px; height: 60px; display: block;}
	.order_goods_price i {font-size: 9px;}
	#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
	#guide{display:none;position:absolute;right:18px;top:5px;z-index:19999;}
	#guide img{width:260px;height:180px;}

	.pp_tips {padding: 10px 5px; text-align: center; font-size: 14px;}
	.pp_tips b {margin: 0px 5px; color: rgb(223, 33, 39); font-size: 18px;}

	#shareit img {max-width: 100%;}
	.mod_footer_lk a {height: 12px; color: rgb(153, 153, 153); line-height: 12px; overflow: hidden; padding-right: 8px; margin-right: 8px; border-right-color: rgb(215, 215, 215); border-right-width: 1px;
		border-right-style: solid;}
	.mod_footer_lk a:last-child {padding-right: 0px; margin-right: 0px; border-right-color: currentColor; border-right-width: 0px; border-right-style: none;}
	.address_new button {border-radius: 2px; border: 0px currentColor; border-image: none; width: 100%; height: 40px; color: rgb(255, 255, 255); line-height: 40px; font-size: 16px; margin-bottom: 10px; display: block; background-color: rgb(56, 132, 255);
	}
	.fui-tab.detail-tab {margin: 0;margin-top: 0.5rem;}

	.fui-tab.detail-tab:before {content: '';position: absolute;left: 0;top: 0;width: 200%;border-top: 1px solid #d0d0d0;display: block;
		-webkit-transform-origin: 0 0;transform-origin: 0 0;-webkit-transform: scale(.5, .5);transform: scale(.5, .5);}
	.fui-tab.detail-tab:after {-webkit-transform-origin: 0 0;-ms-transform-origin: 0 0;transform-origin: 0 0;-webkit-transform: scaleY(0.5);-ms-transform: scaleY(0.5);
		transform: scaleY(0.5);}
	.detail-block > div{display: none;background: #fff;padding:0.2rem;border-bottom:1px solid #f0f0f0;}
	.tab-basic img{max-width:100%;}
	.groupstime{
		height:1.8rem;
		width:100%;
		background:#fff4f4;
		font-size:0.6rem;
		font-weight:bold;
		line-height:1.8rem;
		color:#ff5555;
		text-align:center;
	}
	.lynn_opengroups_head{
	border-bottom:none;
	}
</style>
<div class='fui-page creditshop-detail-page order-list-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back" href="<?php  echo mobileUrl('order')?>"></a>
		</div>
		<div class="title">团详情</div>
		<div class="fui-header-right">
			<span class="icon icon-group" onclick="location.href='<?php  echo mobileUrl('groups/team')?>'" style="font-size:1.1rem;"></span>
		</div>
	</div>
	<div class='fui-content' style="padding-bottom:0;top:2.2rem;">
		<?php  if(!empty($thumb)) { ?>
		<div class="lynn_team_detail_head">
			<div class="fui-swipe lynn_swipe" data-speed="5000" data-gap="5">
				<div class="fui-swipe-wrapper">
					<?php  if(is_array($goods['thumb_url'])) { foreach($goods['thumb_url'] as $thumb) { ?>
					<div class="fui-swipe-item"><img src="<?php  echo tomedia($thumb)?>" alt="<?php  echo $goods['title'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg'"></div>
					<?php  } } ?>
				</div>
				<div class="fui-swipe-page">
					<?php  if(is_array($goods['thumb_url'])) { foreach($goods['thumb_url'] as $thumb) { ?>
					<div class="fui-swipe-bullet"></div>
					<?php  } } ?>
				</div>
			</div>
			<?php  if($order['success']==1) { ?>
			<img class="team_img" src="../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/success.png" alt="组团成功">
			<?php  } else if($lasttime2 > 0 && $order['success']==0) { ?>
			<img class="team_img" src="../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/frightin.png" alt="等待成团">
			<?php  } else if($order['success']==-1) { ?>
			<img class="team_img" src="../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/fail.png" alt="团购失败">
			<?php  } ?>
			<input type="hidden" name="title" value="<?php  echo $goods['title'];?>" id="gname">
			<h2 class="lynn_team_detail_title"><?php  echo $goods['title'];?></h2>
			<p class="lynn_team_detail_goods_info">
				拼团价：¥<strong><?php  echo $goods['groupsprice'];?></strong>/<?php  if($goods['units']) { ?><?php  echo $goods['goodsnum'];?><?php  echo $goods['units'];?><?php  } else { ?>1件<?php  } ?><del><?php  echo $goods['price'];?></del>
			</p>
		</div>
		<?php  } ?>
		<?php  if($lasttime2 > 0 && $n > 0 ) { ?>
		<div class="groupstime">
			<div class='fui-labeltext fui-labeltext-danger fui-timer'
				 data-now="<?php  echo date('Y-m-d H:i:s')?>"
				 data-start="<?php  echo date('Y-m-d H:i:s', $tuan_first_order['starttime'])?>"
				 data-end="<?php  echo date('Y-m-d H:i:s', $tuan_first_order['endtime'])?>"
				 data-end-label='拼团剩余' data-start-label='距离开始还有'>
				<div class='label' style="color: #ff5555;"></div>
				<div class='text' style="padding: 0">
					<span class="day number text-danger" >-</span><span class="time">天</span>
					<span class="hour number text-danger">-</span><span class="time">小时</span>
					<span class="minute number text-danger">-</span><span class="time">分</span>
					<span class="second number text-danger">-</span><span class="time">秒</span>
				</div>
			</div>
		</div>
		<?php  } else if($n>0) { ?>
			<div class="groupstime">
				<div class='text' style="padding: 0">
					<span class="day number text-danger" ></span><span class="time">拼团已过期</span>
				</div>
			</div>
		<?php  } ?>
			<?php  if($n ==0) { ?>
				<div class="groupstime">
				<div class='text' style="padding: 0">
					<span class="day number text-danger" ></span><span class="time">拼团成功</span>
				</div>
				</div>
			<?php  } ?>
		<div class="lynn_opengroups_head fui-list">
			<a href="" class="lynn_index_list_a fui-list-media">
				<img src="<?php  echo $goods['thumb'];?>" alt="<?php  echo $goods['title'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg'">
			</a>
			<div class="fui-list-inner lynn_opengroups_head_goods ">
				<h2><?php  echo $goods['title'];?></h2>
				<div class="person" style="margin: 0.6rem 0">
					<?php  if($goods['is_ladder'] ==1) { ?>
					阶梯团
					<?php  } else { ?>
					<?php  echo $goods['groupnum'];?>人团
					<?php  } ?>
				</div>
				<div class="price" style="font-size:0.65rem;color:#ff5555;">
					¥<?php  echo $goods['groupsprice'];?>/<?php  if($goods['units']) { ?><?php  echo $goods['goodsnum'];?><?php  echo $goods['units'];?><?php  } else { ?>1件<?php  } ?>
					<span class="pull-right" style="font-size: 0.6rem;color: #999;"></span>
				</div>
			</div>
		</div>

		<div class="pp">
			<div id="" style="clear: both;"></div>
			<?php  if($n ==0) { ?>
			<!--<div class="num"><b>拼团成功</b></div>-->
			<?php  } else { ?>
			<div class="num">还差<?php  echo $n;?>人拼团成功</div>
			<?php  } ?>
			<div class="pp_users" id="pp_users">
				<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
					<?php  if($order['openid'] == $tuan_first_order['openid']) { ?>
					<a href="javascript:void(0);" class="pp_users_item pp_users_normal"><img src="<?php  echo $order['avatar'];?>" onerror="this.src='../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/avatar.png'"></a>
					<?php  } else { ?>
					<a href="javascript:void(0);" class="pp_users_item pp_users_normal"><img src="<?php  echo $order['avatar'];?>" onerror="this.src='../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/avatar.png'"></a>
					<?php  } ?>
				<?php  } } ?>

				<?php  if(is_array($arr)) { foreach($arr as $ar) { ?>
				<a href="javascript:void(0);" class="pp_users_item"><img src="../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/avatar.png"></a>
				<?php  } } ?>
			</div>
			<!--<div class="pp_tips" id="flag_0_a" >-->
				<!--<div class="groups_info">-->
					<?php  if($lasttime2 >0 && $n > 0 ) { ?>
					<!--快邀请好友一起来拼团吧！-->
					<?php  } else { ?>
					<!--团购已结束-->
					<?php  } ?>
				<!--</div>-->
			<!--</div>-->
		</div>
			<div>
				<div class="progress">
					<text class="icox icox-1">1</text>
					下单开团/参团
					<text class="line">---------</text>
					<text class="icox icox-2">2</text>
					邀请好友参团
					<text class="line">---------</text>
					<text class="icox icox-3">3</text>
					人满拼团成功
				</div>
				<div class="fui-tab fui-tab-danger detail-tab" id="detailTab" style="position: initial;margin-top: 0">
					<a data-tab="team" class="active">拼团详情</a>
					<a data-tab="basic">商品详情</a>
				</div>
				<div class="detail-block">
					<div class="block block-team tab-team" id="team" style="display: block;">
						<dl class="lynn_team_list">
							<dt class="lynn_team_list_top" style="display: none;">
								<b></b>
								<p>查看全部团详情 <i class="iconfont icon lynn_icon">&#xe764;</i></p>
							</dt>
							<?php  if(is_array($orders)) { foreach($orders as $order) { ?>
							<?php  if($order['openid'] == $tuan_first_order['openid']) { ?>
							<dd class="lynn_team_list_dd row">
								<img src="<?php  echo $order['avatar'];?>" alt="<?php  echo $order['nickname'];?>" onerror="this.src='../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/avatar.png'">
								<span class="fl"><?php  echo $order['nickname'];?><?php  if($order['status'] == -1) { ?>[已取消]<?php  } ?></span>
								<span class="fr"><?php  echo date('Y-m-d H:i:s', $order['paytime'])?> 开团</span>
							</dd>
							<?php  } else { ?>
							<dd class="lynn_team_list_dd row">
								<img src="<?php  echo $order['avatar'];?>" alt="<?php  echo $order['nickname'];?>" onerror="this.src='../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/avatar.png'">
								<span class="fl"><?php  if($order['nickname']) { ?><?php  echo $order['nickname'];?><?php  } else { ?>匿名<?php  } ?><?php  if($order['status'] == -1) { ?>[已取消]<?php  } ?></span>
								<span class="fr"><?php  echo date('Y-m-d H:i:s', $order['paytime'])?> 参团</span>
							</dd>
							<?php  } ?>
							<?php  } } ?>
						</dl>
					</div>
					<div class="block block-basic tab-basic" id="basic">
					<?php  if($groupsset['description']) { ?>
					<?php  echo htmlspecialchars_decode($groupsset['groups_description'])?>
					<?php  } else if($goods['content']) { ?>
					<?php  echo htmlspecialchars_decode($goods['content'])?>
					<?php  } else { ?>
					<div style="font-size:0.7rem;padding:0.2rem">暂无商品详情</div>
					<?php  } ?>
				</div>
				</div>

				<div style="height:2.5rem;"></div>
			</div>
		</div>
	<div class="fui-navbar lynn_footer">
		<a class="home" href="<?php  echo mobileUrl('groups')?>">
			<p class="fa icon icon-home"></p>
			首页
		</a>
		<?php  if($n<=0) { ?>
		<a class="other" href="javascript:void(0);">
			<p class="">团购已成功</p>
		</a>
		<?php  } else { ?>
			<?php  if($lasttime2 > 0) { ?>
				<?php  if(!empty($myorder)) { ?>
					<?php  if($n<=0) { ?>
					<a class="other" href="javascript:void(0);">
						<p class="">团购已成功</p>
					</a>
					<?php  } else { ?>
					<a class="other" href="javascript:void(0);" id="invitation">
						<p class="">快邀请好友参团吧</p>
					</a>
					<?php  } ?>
				<?php  } else { ?>
						<?php  if($goods['more_spec'] ==1) { ?>
							<a href="javascript:void(0);" class=" other " onclick="more_spec(<?php  echo $goods['id'];?>,<?php  echo $teamid;?>)">我要参团</a>
						<?php  } else if($goods['is_ladder']==1) { ?>
						<a class="other" href="<?php  echo mobileUrl('groups/orders/confirm',array('id' => $goods['id'],'teamid' => $teamid,'type'=>'groups','ladder_id'=>$order['ladder_id']));?>">
							<p class="">我要参团</p>
						</a>
						<?php  } else { ?>
						<a class="other" href="<?php  echo mobileUrl('groups/orders/confirm',array('id' => $goods['id'],'teamid' => $teamid,'type'=>'groups'));?>">
							<p class="">我要参团</p>
						</a>
						<?php  } ?>
				<?php  } ?>
			<?php  } else { ?>
			<a class="other" href="javascript:void(0);">
				<p class="">本次团已过期</p>
			</a>
			<?php  } ?>
		<?php  } ?>
	</div>

	<div class='layer'style="display: none" ></div>
	<!--阶梯团弹窗  -->
	<div class='chosenum' style="display: none">
		<div class='title'>请选择拼团人数</div>
		<div class='laddernum' style="margin-bottom:15px;">价格</div>
		<div class='num'>

		</div>
		<div class='btn btn-danger btn-jieti'  disabled="disabled">确定</div>
		<div class='close1 icon icon-guanbi1'></div>
	</div>
	<!--多规格弹窗  -->
	<div class='fui-modal goods-picker in goodslist' style="display: none">
		<div class='option-picker'>
			<div class='option-picker-inner'>
				<div class='fui-list'>
					<div class='fui-list-media'>
						<image class='thumb' src=<?php  echo $goods['thumb'];?>></image>
					</div>
					<div class='fui-list-inner'>
						<div class='subtitle'><?php  echo $goods['title'];?></div>
						<div class='price'><?php  echo $goods['groupsprice'];?></div>
						<input class='stock' type="hidden" >
						<div class='option_id'style="display: none" ></div>
					</div>
				</div>
				<div class='option-picker-options'>
					<div class='option-picker-cell option spec'>

					</div>
				</div>
			</div>
			<div class='sure'><div class='btn btn-danger block'>确定</div></div>
		</div>
		<div class='icon icon-guanbi1' style='color:#fff;text-align:center;font-size:1.25rem;margin-top:0.75rem;' > </div>
	</div>
</div>

<div id="cover"></div>
<div id="guide"><img src="../addons/ewei_shopv2/plugin/groups/template/mobile/default/images/guide1.png"></div>

<script type="text/javascript">
	require(['core'],function(modal){
		$('.fui-timer').timer({
			onEnd: function(){
				$(".fui-navbar .btn").removeClass("btn-danger").addClass("btn-disabled").removeAttr("id").text("活动已结束");
			}
		});
	});
	$(function(){
		$("#invitation").on("click",function(){
			if($("#cover").css("display")=='none'){
				$("#cover").show();
				$("#guide").show();
			}
		})
		$("#cover").on("click",function(){
			$("#cover").hide();
			$("#guide").hide();
		})
		$("#detailTab a").unbind('click').click(function () {
			var tab = $(this).data('tab');
			$(this).addClass('active').siblings().removeClass('active');
			$("#"+tab).show().siblings().hide();
		});

	});
    function more_spec(goodid,teamid){
        core.json('groups/goods/goodsCheck', {'id':goodid, type: 'groups'}, function (postjson) {
            if (postjson.status == 1 && postjson.result.specArr.length>0) {
                // 多规格团
                $(".fui-modal").css("display","block");
                $(".layer").css("display","block");
                var specArr = postjson.result.specArr;
                var str = '';
                $.each(specArr,function (index,obj) {
                    str += "<div class='title'>"+obj.title+"</div>",
                        str += "<div class='select'>";
                    $.each(obj.item,function (index,itemobj) {
                        str += "  <div class='btn btn-default btn-sm nav spec-item' data-specs='"+itemobj.id+"'>"+itemobj.title+"</div>";
                    });
                    str += "   </div>";
                });
                $(".spec").html(str);
                var spec_id = new Array();
                $(".select").on('click','div',function(){
                    $(this).addClass('active').siblings('.spec-item').removeClass('active');
                    spec_id = [];
                    $.each($("div.active"),function( k , v){
                        spec_id.push($( v ).data( 'specs' ));
                    });
                    if(spec_id.length >0){
                        core.json('groups/goods/get_option', {'spec_id':spec_id}, function (spec_json) {
                            $(".subtitle").text(spec_json.result.data.title);
                            $(".price").text(spec_json.result.data.price);
                            $(".option_id").text(spec_json.result.data.goods_option_id);
                            $(".stock").text(spec_json.result.data.stock);
                        },true,true);
                    }
                });

                $("div.sure").bind("click", function () {
                    var option_id =  $(".option_id").html();
                    var stock =  $(".stock").text();
                    if(stock == 0){
                        FoxUI.toast.show('库存不足');
                    }
                    if(spec_id.length<specArr.length){
                        FoxUI.toast.show('请选择所有规格');
                        return;
                    }
                    location.href = core.getUrl('groups/orders/confirm', {
                        id: goodid,
                        type: 'groups',
                        teamid:teamid,
                        options_id: option_id
                    });
                    return
                });
                return
            } else {
                FoxUI.toast.show(postjson.result.message)
            }
        }, true, true)
    }

    $(".icon-guanbi1").bind("click", function () {
        $(".fui-modal").css("display","none");
        $(".layer").css("display","none");
        $(".subtitle").html("规格");
        $(".price").html("价格");
        $(".stock").html("库存");
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>