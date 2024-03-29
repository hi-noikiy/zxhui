<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left = true?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
	.trhead td {  background:#efefef;text-align: center}
	.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #f2f2f2;overflow: hidden; font-size:12px;}
	.trorder { background:#f8f8f8;border:1px solid #f2f2f2;text-align:left;}
	.ops { border-right:1px solid #f2f2f2; text-align: center;}
	.panel-default .panel-heading {height: 34px; line-height: 34px; padding: 0 10px; color: #666;}
	.panel-default {margin-bottom: 10px;}
	.btn.btn-disabled,
	.btn.btn-disabled:hover,
	.btn.btn-disabled:focus {background: #ccc; color: #fff;}
	.select-1 .input-group-sm .btn {padding: 4px 6px;}
</style>
<div class="page-header">
	当前位置：<span class="text-primary">单个打印</span>
</div>
<div class="page-content">
	<div class="page-sub-toolbar">
		<span class="">
			<a href="<?php  echo webUrl('groups/exhelper')?>" class="btn btn-default ">返回拼团打印</a>
		</span>
	</div>
	<div class="tabs-container">
		<div class="tab-content ">
			<div class="tab-pane active" id="tab_sender">
				<div class="page-toolbar row m-b-sm m-t-sm">
					<div class="col-sm-12 select-1">

						<div class='input-group'>
							<select name="paytype" class="form-control" style="width:130px;padding:0 5px;">
								<option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>支付方式</option>
								<?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
								<option value="<?php  echo $key;?>"><?php  echo $type['name'];?></option>
								<?php  } } ?>
							</select>
							<select name="status" class="form-control" style="width:130px;padding:0 5px;">
								<option value="">订单状态</option>
								<?php  if(is_array($orderstatus)) { foreach($orderstatus as $key => $type) { ?>
								<option value="<?php  echo $key;?>" <?php  if($key==1) { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
								<?php  } } ?>
							</select>

							<select name="printstate" class="form-control" style="width:140px;padding:0 5px;">
								<option value="">快递单打印状态</option>
								<option value='0'>未打印</option>
								<option value='1'>部分打印</option>
								<option value='2'>打印完成</option>
							</select>

							<select name="printstate2" class="form-control " style="width:140px;padding:0 5px;">
								<option value="">发货单打印状态</option>
								<option value='0'>未打印</option>
								<option value='1'>部分打印</option>
								<option value='2'>打印完成</option>
							</select>

							<select name='searchtime'  class='form-control'   style="width:130px;padding:0 5px;"  >
								<option value=''>不按时间</option>
								<option value='create'>下单时间</option>
								<option value='pay'>付款时间</option>
								<option value='send'>发货时间</option>
							</select>

							<?php  echo tpl_form_field_eweishop_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>

						</div>
					</div>
				</div>

				<div class="page-toolbar row m-b-sm m-t-sm">
					<div class="col-sm-12">
						<div class='input-group input-group-sm'>
							<select name='searchfield'  class='form-control  input-sm select-md'   style="width:130px;padding:0 5px;"  >
								<option value='orderno'>订单号</option>
								<option value='member'>会员信息</option>
								<option value='address'>收件人信息</option>
								<option value='expresssn'>快递单号</option>
								<option value='goodstitle'>商品名称</option>
								<option value='goodssn'>商品编码</option>
							</select>
							<input type="text" class="form-control input-sm"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" style="width: 750px;"/>
							<span class="btn btn-primary" style="border-radius: 0; width: 90px;" onclick="search()" id="search-btn"> 搜索</span>

						</div>
					</div>
				</div>



			<div id="result">
				<p style="text-align: center; line-height: 100px;" id="result-tip">请先搜索您要打印的订单</p>
			</div>

			<script language='javascript' src="../addons/ewei_shopv2/plugin/groups/static/js/LodopFuncs.js"></script>
			<script src='<?php  echo $lodopUrl;?>'></script>


			<script language="javascript">
				$(function(){
					window.isCLodop = true;
					if(typeof getCLodop ==='undefined'){
						window.isCLodop = false;
						window.LodopTip = "打印控件错误：\r\n未开启打印控件或配置端口不正确！\r\n检查以上两项后刷新页面重试！";
						alert(LodopTip);
					}
				});
				// 执行搜索
				function search(){
					var data = {
						paytype: $.trim($("select[name='paytype'] option:selected").val()),
						status: $.trim($("select[name='status'] option:selected").val()),//
						printstate: $.trim($("select[name='printstate'] option:selected").val()),
						printstate2: $.trim($("select[name='printstate2'] option:selected").val()),//
						searchtime: $.trim($("select[name='searchtime'] option:selected").val()),
						starttime: $.trim($("input[name='time[start]']").val()),
						endtime: $.trim($("input[name='time[end]']").val()),//
						searchfield: $.trim($("select[name='searchfield'] option:selected").val()),
						keyword: $.trim($("input[name='keyword']").val())
					};

					$('#search-btn').html("<i class='fa fa-spinner fa-spin'></i> 正在搜索");
					$("#result-tip").html("<i class='fa fa-spinner fa-spin'></i> 正在搜索...");

					$.ajax({
						url: "<?php  echo webUrl('groups/exhelper/getdata')?>",
						data: data,
						type: "post",
						success:function(html){
							$('#search-btn').html("<i class='fa fa-search'></i> 搜索")
							$('#result').html(html);

							$('.result-item').click(function(){
								   $('#result-order').html("<p style='line-height: 100px; text-align: center;'><i class='fa fa-spinner fa-spin'></i> 正在加载...</p>")
								$.ajax({
									  url: "<?php  echo webUrl('groups/exhelper/getorder')?>",
									  data: {orderids: $(this).data('orderids')},
									  type: "post",
									  success:function(html){
										  $('#result-order').html(html);
										  require(['bootstrap'],function(){
											$("[data-toggle='popover']").popover({'container':$(document.body)});
										  })
									  }
								  });

							  })

						}
					});
				}
			</script>

			</div>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
