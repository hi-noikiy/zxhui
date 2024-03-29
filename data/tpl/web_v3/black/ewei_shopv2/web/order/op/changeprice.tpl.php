<?php defined('IN_IA') or exit('Access Denied');?>
<form class="form-horizontal form-validate" action="<?php  echo webUrl('order/op/changeprice')?>" method="post" enctype="multipart/form-data">
	<input type='hidden' name='id' value='<?php  echo $id;?>' />
	<input type='hidden' id='changeprice-orderprice' value="<?php  echo $item['price']-$item['dispatchprice']?>"/>
	<input type='hidden' id='changeprice-dispatchprice' value="<?php  echo $item['dispatchprice'];?>"/> 
	<div class="modal-dialog"  style="width:800px;">
		<div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">订单改价</h4>
            </div>
            <div class="modal-body">
				<table class="table" style='table-layout:fixed'>
					<tr>
						<th style="width:200px;" >商品名称</th>
						<th >单价</th>
						<th>数量</th>
						<th style="width: 150px">小计</th>
						<th>加价或减价</th>
						<th>运费 - <a href='javascript:;' onclick="$('#changeprice_dispatchprice').val('0');mc_calc()" >免运费</a></th>
					</tr>
					<tbody>
						<?php  if(is_array($order_goods)) { foreach($order_goods as $key => $goods) { ?>
						<tr>
							<td style='overflow:hidden;'><?php  echo $goods['title'];?></td>
							<td class='realprice'><?php  echo number_format($goods['oldprice']/$goods['total'],2)?></td>
							<td><?php  echo $goods['total'];?></td>
							<td>
								<?php  echo $goods['realprice'];?>
								<?php  if($goods['realprice']!=$goods['oldprice']) { ?>
								<label class='label label-danger'>改价</label>
								<?php  } ?>
							</td>

							<td valign="top" >
								<input type='number' class='form-control changeprice_orderprice' name="changegoodsprice[<?php  echo $goods['id'];?>]"  /></td>

							<?php  if($key==0) { ?>
							<td valign="top" rowspan='<?php  echo count($order_goods)?>' style='vertical-align: top;' >
								<input type='number' class='form-control' id='changeprice_dispatchprice' value="<?php  echo $item['dispatchprice'];?>" name='changedispatchprice' />
								
							</td>
							<?php  } ?>
						</tr>
						<?php  } } ?>

						<tr>
							<td colspan='2'></td>
							<td colspan='' style='color:green'>应收款</td>
							<td colspan='' style='color:green'><?php  echo number_format($item['price'],2)?></td>
							<td colspan='2'  style='color:red'>改价后价格不能小于0元</td>
						</tr>
					</tbody>

				</table>

				<div class="form-group">

					<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
						<div class="form-control-static">

							<b>购买者信息</b>  <?php  echo $item['addressdata']['address'];?> <?php  echo $item['addressdata']['realname'];?> <?php  echo $item['addressdata']['mobile'];?><br/>
							<b>买家实付</b>： <span id='orderprice'><?php  echo number_format( $item['price']-$item['dispatchprice'],2)?></span> + <span id='dispatchprice'><?php  echo $item['dispatchprice'];?></span> <span id='changeprice'></span> = <span id='lastprice'><?php  echo $item['price'];?></span><br/>
							<b>买家实付</b> = 原价 + 运费 + 涨价或减价<br/><br/>
							<b><span style='color:red'>*</span>该订单最多支持99次改价，您已经修改 <span style='color:red'><?php  echo $item['ordersn2'];?></span> 次<br/>
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" onclick="return mc_check()">提交</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
            </div>
        </div>
</form>

<script language='javascript'>
	var order_price = 0;
	var dispatch_price = 0;

	mc_init();
	 

	function mc_init() {

		order_price = parseFloat($('#changeprice-orderprice').val());
		dispatch_price = parseFloat($('#changeprice-dispatchprice').val());
		$('input', $('#ajaxModal')).blur(function () {
			if($.isNumber($(this).val())){
				mc_calc();
			}
		});

	}

	function mc_calc() {
		 
		var change_dispatchprice = parseFloat($('#changeprice_dispatchprice').val());
		if(!$.isNumber($('#changeprice_dispatchprice').val())){
			 change_dispatchprice = dispatch_price;
		}
		var dprice = change_dispatchprice;
		if (dprice <= 0) {
			dprice = 0;
		} 
		$('#dispatchprice').html(dprice.toFixed(2));
 
		var oprice = 0;
		$('.changeprice_orderprice').each(function () { 
			var p = 0;
			if ($.trim($(this).val()) != '') {
				p = parseFloat($.trim($(this).val()));
			}
			oprice += p;
		});
		if(Math.abs(oprice)>0){
			if (oprice < 0) {
				$('#changeprice').css('color', 'red');
				$('#changeprice').html( " - " + Math.abs(oprice));
			} else {
				$('#changeprice').css('color', 'green');
				$('#changeprice').html( " + " + Math.abs(oprice));
			}
		}
		var lastprice =  order_price + dprice + oprice;
		
		$('#lastprice').html( lastprice.toFixed(2) );

	}
	function mc_check(){
		var can = true;
		var lastprice = 0;
		 $('.changeprice_orderprice').each(function () {
			 if( $.trim( $(this).val())==''){
				 return true;
			 }
			var p = 0;
			if ( !$.isNumber($(this).val())) {
				$(this).select();
				tip.msgbox.err('请输入数字!');
				can =false;
				return false;
			}
			var val  = parseFloat( $(this).val() );
			if(val<=0 && Math.abs(val) > parseFloat( $(this).parent().prev().html())) {
				$(this).select();
				tip.msgbox.err('单个商品价格不能优惠到负数!');
				can =false;
				return false;
			}
			lastprice+=val;
		});
		var op = order_price + dispatch_price+ lastprice;
		if( op <0){
			tip.msgbox.err('订单价格不能小于0元!');
			return false;
		}
		if(!can){
			return false;
		}
		return true;
	}
</script>

