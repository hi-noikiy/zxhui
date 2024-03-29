<?php defined('IN_IA') or exit('Access Denied');?><div class="modal-dialog">
	<style>
		#selectUrl .modal-body {padding: 10px 15px;}
		#selectUrl .tab-pane {margin-top: 5px; min-height: 350px; max-height: 350px; overflow-y: auto;}
		#selectUrl .page-header {padding: 9px 0; margin-bottom: 8px;}
		#selectUrl .page-header h4 {margin: 0;}
		#selectUrl .btn {margin-bottom: 3px;}
		#selectUrl .modal-dialog {width: 820px;}
		#selectUrl .line {border-bottom: 1px dashed #ddd; color: #999; height: 36px; line-height: 36px;}
		#selectUrl .line .icon {height: 35px; width: 30px; position: relative; float: left;}
		#selectUrl .line .icon.icon-1:before {content: ""; width: 10px; height: 10px; border: 1px dashed #ccc; position: absolute; top: 12px; left: 10px;}
		#selectUrl .line .icon.icon-2 {width: 50px;}
		#selectUrl .line .icon.icon-2:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 20px;}
		#selectUrl .line .icon.icon-3 {width: 60px;}
		#selectUrl .line .icon.icon-3:before {content: ""; width: 10px; height: 10px; border-left: 1px dashed #ccc; border-bottom: 1px dashed #ccc; position: absolute; top: 12px; left: 30px;}
		#selectUrl .line .btn-sm {float: right; margin-top: 5px; margin-right: 5px; height: 24px; line-height: 24px; padding: 0 10px;}
		#selectUrl .line .text {display: block;}
		#selectUrl .line .label-sm {padding: 2px 5px;}
		#selectUrl .line.good {height: 60px; padding: 4px 0;}
		#selectUrl .line.good .image {height: 50px; width: 50px; border: 1px solid #ccc; float: left;}
		#selectUrl .line.good .image img {height: 100%; width: 100%;}
		#selectUrl .line.good .text {padding-left: 60px; height: 52px;}
		#selectUrl .line.good .text p {padding: 0; margin: 0;}
		#selectUrl .line.good .text .name {font-size: 15px; line-height: 32px; height: 28px;}
		#selectUrl .line.good .text .price {font-size: 12px; line-height: 18px; height: 18px;}
		#selectUrl .line.good .btn-sm {height: 32px; padding: 5px 10px; line-height: 22px; margin-top: 9px;}
		#selectUrl .tip {line-height: 250px; text-align: center;}
		#selectUrl .nav-tabs > li > a {padding: 8px 20px;}
	</style>
	<div class="modal-content">
		<div class="modal-header">
			<button data-dismiss="modal" class="close" type="button">×</button>
			<h4 class="modal-title">选择链接</h4>
		</div>
		<div class="modal-body">
			<ul class="nav nav-tabs" id="selectUrlTab">
				<?php  if(($type != 'topmenu' && $type != 'topmenu_data') || $platform == 'wxapp') { ?>
				<li class="active"><a href="#sut_shop">商城</a></li>
				<?php  } ?>
				<?php  if($platform!='wxapp_tabbar' && $type != 'topmenu' && $type != 'topmenu_data') { ?>
					<li class=""><a href="#sut_good">商品</a></li>
					<?php  if($syscate['level']!=-1 && !empty($categorys)) { ?>
					<li class=""><a href="#sut_cate">商品分类</a></li>
					<?php  } ?>
				<?php  } ?>

				<?php  if(p('diypage') && !$platform && $type != 'topmenu_data') { ?>
				<li class=""><a href="#sut_diypage"><?php  echo m('plugin')->getName('diypage')?></a></li>
				<?php  } ?>
				<?php  if($type == 'topmenu_data') { ?>
				<li class="active"><a href="#sut_goods_data" class="sut_goods_data">商品</a></li>
				<?php  } ?>
			</ul>
			<div class="tab-content ">
				<?php  if(($type != 'topmenu' && $type != 'topmenu_data') || $platform == 'wxapp') { ?>
				<div class="tab-pane active" id="sut_shop">

					<div class="page-header"><h4><i class="fa fa-folder-open-o"></i> 商城页面</h4></div>
					<nav data-href="<?php  echo mobileUrl(null, null, $full)?>" class="btn btn-default btn-sm" title="商城首页">主商城首页</nav>
					<nav data-href="<?php  echo mobileUrl('merch', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="商城首页">店铺首页</nav>
					<nav data-href="<?php  echo mobileUrl('shop/category', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="分类导航">分类导航</nav>
					<nav data-href="<?php  echo mobileUrl('goods', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="全部商品">全部商品</nav>
					<nav data-href="<?php  echo mobileUrl('shop/notice', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="公告页面">公告页面</nav>
					<nav data-href="<?php  echo mobileUrl('member/cart', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="购物车">购物车</nav>

					<div class="page-header"><h4><i class="fa fa-folder-open-o"></i> 商品属性</h4></div>
					<nav data-href="<?php  echo mobileUrl(goods, array('isrecommand'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="推荐商品">推荐商品</nav>
					<nav data-href="<?php  echo mobileUrl(goods, array('isnew'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="新品上市">新品上市</nav>
					<nav data-href="<?php  echo mobileUrl(goods, array('ishot'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="热卖商品">热卖商品</nav>
					<nav data-href="<?php  echo mobileUrl(goods, array('isdiscount'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="促销商品">促销商品</nav>
					<nav data-href="<?php  echo mobileUrl(goods, array('issendfree'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="卖家包邮">卖家包邮</nav>
					<nav data-href="<?php  echo mobileUrl(goods, array('istime'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="显示抢购">限时抢购</nav>

					<div class="page-header"><h4><i class="fa fa-folder-open-o"></i> 会员中心</h4></div>
					<nav data-href="<?php  echo mobileUrl('member', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="会员中心">会员中心</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的订单(全部)">我的订单(全部)</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('status'=>0, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="待付款订单">待付款订单</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('status'=>1, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="待发货订单">待发货订单</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('status'=>2, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="待收货订单">待收货订单</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('status'=>4, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="退换货订单">退换货订单</nav>
					<nav data-href="<?php  echo mobileUrl('order', array('status'=>3, 'merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="已完成订单">已完成订单</nav>
					<nav data-href="<?php  echo mobileUrl('member/favorite', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的收藏">我的收藏</nav>
					<nav data-href="<?php  echo mobileUrl('member/history', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的足迹">我的足迹</nav>
					<nav data-href="<?php  echo mobileUrl('member/recharge', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="会员充值">会员充值</nav>
					<nav data-href="<?php  echo mobileUrl('member/log', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="余额明细">余额明细</nav>
					<nav data-href="<?php  echo mobileUrl('member/withdraw', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="余额提现">余额提现</nav>
					<nav data-href="<?php  echo mobileUrl('member/address', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="收货地址">收货地址</nav>
					<nav data-href="<?php  echo mobileUrl('member/info', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的资料">我的资料</nav>
					<nav data-href="<?php  echo mobileUrl('member/rank', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="积分排行">积分排行</nav>
					<nav data-href="<?php  echo mobileUrl('member/rank/order_rank', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="消费排行">消费排行</nav>
					<!--<nav data-href="<?php  echo mobileUrl('member/notice', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="消息提醒设置">消息提醒设置</nav>-->
					<nav data-href="<?php  echo mobileUrl('member/address', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="收货地址管理">收货地址管理</nav>

					<?php  if(p('commission')) { ?>
					<div class="page-header"><h4><i class="fa fa-folder-open-o"></i> <?php  echo m('plugin')->getName('commission')?></h4></div>
					<nav data-href="<?php  echo mobileUrl('commission', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="分销中心">分销中心</nav>
					<nav data-href="<?php  echo mobileUrl('commission/register', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="成为分销商">成为分销商</nav>
					<nav data-href="<?php  echo mobileUrl('commission/myshop', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的小店">我的小店</nav>
					<?php  } ?>

					<div class="page-header"><h4><i class="fa fa-folder-open-o"></i> 超级券</h4></div>
					<nav data-href="<?php  echo mobileUrl('sale/coupon', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="领取优惠券">领取优惠券</nav>
					<nav data-href="<?php  echo mobileUrl('sale/coupon/my', array('merchid'=>$merchid), $full)?>" class="btn btn-default btn-sm" title="我的优惠券">我的优惠券</nav>

				</div>
				<?php  } ?>
				<?php  if($type != 'topmenu' && $type != 'topmenu_data') { ?>
				<div class="tab-pane" id="sut_good">
					<div class="input-group">
						<input type="text" placeholder="请输入商品名称进行搜索" id="select-good-kw" value="" class="form-control">
						<span class="input-group-addon btn btn-default select-btn" data-type="good">搜索</span>
					</div>
					<div id="select-good-list"></div>
				</div>
				<?php  } ?>
				<?php  if($type != 'topmenu' && $type != 'topmenu_data') { ?>
				<div class="tab-pane" id="sut_cate">
					<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
					<?php  if(empty($category['parentid'])) { ?>
					<div class="line">
						<div class="icon icon-1"></div>
						<nav title="选择" class="btn btn-default btn-sm" data-href="<?php  echo mobileUrl('goods',array('cate'=>$category['id'], 'merchid'=>intval($_W['merchid'])), $full)?>">选择</nav>
						<div class="text"><?php  echo $category['name'];?></div>
					</div>
					<?php  if(is_array($categorys)) { foreach($categorys as $category2) { ?>
					<?php  if($category2['parentid']==$category['id']) { ?>
					<div class="line">
						<div class="icon icon-2"></div>
						<nav title="选择" class="btn btn-default btn-sm" data-href="<?php  echo mobileUrl('goods',array('cate'=>$category2['id'], 'merchid'=>intval($_W['merchid'])), $full)?>">选择</nav>
						<div class="text"><?php  echo $category2['name'];?></div>
					</div>
					<?php  if(is_array($categorys)) { foreach($categorys as $category3) { ?>
					<?php  if($category3['parentid']==$category2['id']) { ?>
					<div class="line">
						<div class="icon icon-3"></div>
						<nav title="选择" class="btn btn-default btn-sm" data-href="<?php  echo mobileUrl('goods',array('cate'=>$category3['id'], 'merchid'=>intval($_W['merchid'])), $full)?>">选择</nav>
						<div class="text"><?php  echo $category3['name'];?></div>
					</div>
					<?php  } ?>
					<?php  } } ?>
					<?php  } ?>
					<?php  } } ?>
					<?php  } ?>
					<?php  } } ?>
				</div>
				<?php  } ?>

				<div class="tab-pane" id="sut_coupon">
					<div class="input-group">
						<input type="text" placeholder="请输入优惠券名称进行搜索" id="select-coupon-kw" value="" class="form-control">
						<span class="input-group-addon btn btn-default select-btn" data-type="coupon">搜索</span>
					</div>
					<div id="select-coupon-list"></div>
				</div>


				<?php  if(p('diypage') && !$platform) { ?>
				<div class="tab-pane" id="sut_diypage">
					<?php  if(!empty($diypage['list'])) { ?>
					<?php  if(is_array($diypage['list'])) { foreach($diypage['list'] as $item) { ?>
					<div class="line">
						<nav title="选择" class="btn btn-default btn-sm" data-href="<?php  echo mobileUrl('diypage',array('id'=>$item['id']))?>">选择</nav>
						<div class="text"><span class="label label-<?php  echo $allpagetype[$item['type']]['class'];?> label-sm"><?php  echo $allpagetype[$item['type']]['name'];?></span> <?php  echo $item['name'];?></div>
					</div>
					<?php  } } ?>
					<?php  } else { ?>
					<div class="tip">抱歉！未查询到DIY页面。</div>
					<?php  } ?>
				</div>
				<?php  } ?>

				<?php  if($type == 'topmenu_data') { ?>
				<div class="tab-pane active" id="sut_goods_data">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#goods_data_cate" class="goods_data_cate">分类</a></li>
						<li><a href="#goods_data_group" class="goods_data_group">分组</a></li>
						<li><a href="#goods_data_diy" class="goods_data_diy">自定义</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active"  id="goods_data_cate" style="">
							<?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
							<?php  if(empty($category['parentid'])) { ?>
							<div class="line">
								<div class="icon icon-1"></div>
								<nav title="选择" class="btn btn-default btn-sm" data-type="<?php  echo $type;?>" data-condition="<?php  echo $category['id'];?>" data-tab="category">选择</nav>
								<div class="text"><?php  echo $category['name'];?></div>
							</div>
							<?php  if(is_array($categorys)) { foreach($categorys as $category2) { ?>
							<?php  if($category2['parentid']==$category['id']) { ?>
							<div class="line">
								<div class="icon icon-2"></div>
								<nav title="选择" class="btn btn-default btn-sm" data-type="<?php  echo $type;?>" data-condition="<?php  echo $category2['id'];?>" data-tab="category">选择</nav>
								<div class="text"><?php  echo $category2['name'];?></div>
							</div>
							<?php  if(is_array($categorys)) { foreach($categorys as $category3) { ?>
							<?php  if($category3['parentid']==$category2['id']) { ?>
							<div class="line">
								<div class="icon icon-3"></div>
								<nav title="选择" class="btn btn-default btn-sm" data-type="<?php  echo $type;?>" data-condition="<?php  echo $category3['id'];?>" data-tab="category">选择</nav>
								<div class="text"><?php  echo $category3['name'];?></div>
							</div>
							<?php  } ?>
							<?php  } } ?>
							<?php  } ?>
							<?php  } } ?>
							<?php  } ?>
							<?php  } } ?>
						</div>
						<div class="tab-pane" id="goods_data_group" style="">
							<?php  if(!empty($groups)) { ?>
							<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
							<div class="line">
								<div class="icon icon-1"></div>
								<nav title="选择" class="btn btn-default btn-sm" data-type="<?php  echo $type;?>" data-condition="<?php  echo $group['id'];?>" data-tab="groups">选择</nav>
								<div class="text"><?php  echo $group['name'];?></div>
							</div>
							<?php  } } ?>
							<?php  } else { ?>
							<div class="tip">抱歉！未查询到商品分组。</div>
							<?php  } ?>
						</div>
						<div class="tab-pane" id="goods_data_diy" style="">
							<!--<div class="input-group">-->
							<!--<input type="text" placeholder="请输入商品名称进行搜索" id="select-goods_data_diy-kw" value="" class="form-control">-->
							<!--<span class="input-group-addon btn btn-default select-btn" data-type="goods_data_diy">搜索</span>-->
							<!--</div>-->
							<!--<div id="select-goods_data_diy-list"></div>-->
							<div class="form-group" style="margin-top: 15px;">
								<label class="col-lg control-label">选择商品</label>
								<div class="col-sm-9" >
									<div class="form-group" style="height: auto; display: block;">
										<div class="col-sm-12 col-xs-12">
											<?php if( mce('goods' ,$item) ) { ?>
											<div class="input-group">
												<input type="text" id="goodsid_text" name="goodsid_text" value="" class="form-control text" readonly="">
												<div class="input-group-btn">
													<button class="btn btn-primary select_goods" type="button">选择商品</button>
												</div>
											</div>
											<div class="input-group multi-img-details container ui-sortable goods_show">
												<?php  if(!empty($goods)) { ?>
												<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
												<div class="multi-item" data-id="<?php  echo $g['id'];?>" data-name="goodsid" id="<?php  echo $g['id'];?>">
													<img class="img-responsive img-thumbnail" src="<?php  echo tomedia($g['thumb'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" style="width:100px;height:100px;">
													<div class="img-nickname"><?php  echo $g['title'];?></div>
													<input type="hidden" value="<?php  echo $g['id'];?>" name="goodsids[]">
													<em onclick="remove(<?php  echo $g['id'];?>)" class="close">×</em>
													<div style="clear:both;"></div>
												</div>
												<?php  } } ?>
												<?php  } ?>
											</div>

											<script>
                                                $(function(){
                                                    var title = '';
                                                    $('.img-nickname').each(function(){
                                                        title += $(this).html()+';';
                                                    });
                                                    $('#goodsid_text').val(title);
                                                })
                                                myrequire(['web/goods_selector'],function (Gselector) {
                                                    $('.select_goods').click(function () {
                                                        var ids = select_goods_ids();
                                                        Gselector.open('goods_show','',0,true,'',ids);
                                                    });
                                                })
                                                function goods_show(data) {
                                                    if(data.act == 1){
                                                        var html = '<div class="multi-item" data-id="'+data.id+'" data-name="goodsid" id="'+data.id+'">'
                                                            +'<img class="img-responsive img-thumbnail" src="'+data.thumb+'" onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'" style="width:100px;height:100px;">'
                                                            +'<div class="img-nickname">'+data.title+'</div>'
                                                            +'<input type="hidden" value="'+data.id+'" name="goodsids[]">'
                                                            +'<em onclick="removeHtml('+data.id+')" class="close">×</em>'
                                                            +'</div>';

                                                        $('.goods_show').append(html);
                                                        var title = '';
                                                        $('.img-nickname').each(function(){
                                                            title += $(this).html()+';';
                                                        });
                                                        $('#goodsid_text').val(title);
                                                    }else if(data.act == 0){
                                                        remove(data.id);
                                                    }
                                                }
                                                function remove(id){
                                                    $("[id='"+id+"']").remove();
                                                    var title = '';
                                                    $('.img-nickname').each(function(){
                                                        title += $(this).html()+';';
                                                    });
                                                    $('#goodsid_text').val(title);
                                                }
                                                function select_goods_ids(){
                                                    var goodsids = [];
                                                    $(".multi-item").each(function(){
                                                        goodsids.push($(this).attr('data-id'));
                                                    });
                                                    return goodsids;
                                                }
											</script>
											<?php  } else { ?>
											<div class="input-group multi-img-details container ui-sortable">
												<?php  if(is_array($goods)) { foreach($goods as $item) { ?>
												<div data-name="goodsid" data-id="426" class="multi-item">
													<img src="<?php  echo tomedia($item['thumb'])?>" class="img-responsive img-thumbnail">
													<div class="img-nickname"><?php  echo $item['title'];?></div>
												</div>
												<?php  } } ?>
											</div>
											<?php  } ?>
										</div>
									</div>

								</div>
							</div>
							<!--<div class="form-group">-->
							<!--<nav title="选择"   style="width: 82px;height: 30px;" class="btn btn-default btn-sm" data-type="<?php  echo $type;?>" data-condition="" data-tab="goodsids">选择</nav>-->
							<!--</div>-->
						</div>
					</div>
				</div>
				<?php  } ?>
			</div>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn btn-default" type="button">关闭</button>
			<?php  if($type == 'topmenu_data') { ?>
			<nav title="确定"   style="width: 82px;height: 30px;display:none;" class="btn btn-primary btn-sm select_goods_diy" data-type="<?php  echo $type;?>" data-condition="" data-tab="goodsids">确定</nav>
			<nav title="选择" style=" width:  82px;height: 30px;display:none;" class="btn btn-primary btn-sm select_shop_data" data-type="<?php  echo $type;?>" data-condition="" data-tab="stores">确定</nav>
			<?php  } ?>
		</div>
		<!--<div class="modal-footer">-->
			<!--<button data-dismiss="modal" class="btn btn-default" type="button">关闭</button>-->
		<!--</div>-->

		<script>
            $(function(){

                $("#selectUrl").find('.nav-tabs a').click(function(e) {
                    $('#tab').val($(this).attr('href'));
                    e.preventDefault();
                    $(this).tab('show');
                });

                $(".select-btn").click(function(){
                    var type = $(this).data("type");
                    var kw = $.trim($("#select-"+type+"-kw").val());

                    if(!kw || kw==''){
                        tip.msgbox.err("请输入搜索关键字！");
                        return;
                    }


                    $("#select-"+type+"-list").html('<div class="tip">正在进行搜索...</div>');
                    $.ajax("<?php  echo webUrl('util/selecturl/query', array('full'=>$full, 'platform'=>$platform))?>", {
                        type: "get",
                        dataType: "html",
                        cache: false,
                        data: {kw:kw, type:type}
                    }).done(function (html) {
                        $("#select-"+type+"-list").html(html);
                    });
                });

                $('.goods_data_diy').click(function(){
                    $(".select_goods_diy").show();
                    var kw = 'all';
                    var type = 'goods_data_diy';
                    $.ajax("<?php  echo webUrl('util/selecturl/query', array('full'=>$full, 'platform'=>$platform))?>", {
                        type: "get",
                        dataType: "html",
                        cache: false,
                        data: {kw:kw, type:type}
                    }).done(function (html) {
                        $("#select-"+type+"-list").html(html);
                    });
                });
                $('.sut_shop_data').click(function(){
                    $(".select_shop_data").show();
                    $(".select_goods_diy").hide();
                });
                $('.sut_goods_data').click(function(){
                    $(".select_shop_data").hide();
                    $(".select_goods_diy").hide();
                });

                $('.goods_data_cate').click(function(){
                    $(".select_shop_data").hide();
                    $(".select_goods_diy").hide();
                });
                $('.goods_data_group').click(function(){
                    $(".select_shop_data").hide();
                    $(".select_goods_diy").hide();
                });
            });
		</script>
	</div>

</div>