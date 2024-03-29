<?php defined('IN_IA') or exit('Access Denied');?><form class="form-horizontal form-validate" action="<?php  echo merchUrl('order/op/single_refund/submit')?>" method="post" enctype="multipart/form-data">
	<input type='hidden' name='id' value='<?php  echo $id;?>' />

	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">维权处理</h4>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">处理方式</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $r_type[$refund['rtype']];?></p>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">处理结果</label>
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <!--<label class='radio-inline'>-->
                        <!--<input type='radio' value='0' name='refundstatus' <?php  if($refund['status']==0) { ?>checked<?php  } ?>>暂不处理-->
                        <!--</label>-->

                        <?php  if(($refund['status'] < 4)) { ?>
                        <label class='radio-inline'>
                            <input type='radio' value='-1' name='refundstatus'>驳回申请
                        </label>
                        <?php  } ?>

                        <?php  if(($refund['rtype'] == 1 || $refund['rtype'] == 2)) { ?>
                            <?php  if($refund['status'] < 3) { ?>
                            <label class='radio-inline'>
                                <input type='radio' value='3' name='refundstatus' <?php  if($refund['status']==3 || $refund['status']==4) { ?>checked<?php  } ?>>通过申请(需客户寄回商品)
                            </label>
                            <?php  } ?>
                        <?php  } ?>

                        <?php  if(($refund['rtype'] == 0 || $refund['rtype'] == 1)) { ?>

                            <label class='radio-inline'>
                                <input type='radio' value='1' name='refundstatus'>
                                同意退款<?php  if($refund['rtype'] == 1 ) { ?>(<?php  if($refund['status'] <3) { ?>无需客户发货直接退款<?php  } else { ?>您已经收到客户寄出的快递<?php  } ?>)<?php  } ?>
                            </label>

                            <label class='radio-inline'>
                                <input type='radio' value='2' name='refundstatus'>手动退款
                            </label>

                            <div class="help-group" style="display: none;">
                                <span class="help-block">微信支付方式： 会返回到相应的的支付渠道(如零钱或银行卡）</span>
                                <span class="help-block">其他支付方式： 会返回到微信钱包(需商户平台余额充足)</span>
                                <span class="help-block">如有余额抵扣： 会返回金额到商城用户余额</span>
                                <span class="help-block">如有积分抵扣： 申请维权的订单抵扣积分不会退还</span>
                                <span class="help-block">手动退款： 订单会完成退款处理，您用其他方式进行退款</span>
                            </div>
                        <?php  } ?>

                        <?php  if($refund['rtype'] == 2) { ?>
                        <label class='radio-inline'>
                            <input type='radio' value='5' name='refundstatus' <?php  if($refund['status']==5) { ?>checked<?php  } ?>>确认发货<?php  if($refund['status']<3) { ?>(无需客户寄回商品，商家直接发换货商品)<?php  } ?>
                        </label>

                            <?php  if(($refund['status'] == 5)) { ?>
                            <label class='radio-inline'>
                                <input type='radio' value='10' name='refundstatus'>关闭申请(换货完成)
                            </label>
                            <?php  } ?>
                        <?php  } ?>


                    </div>
                </div>

                <?php  if($refund['rtype'] > 0) { ?>
                <div class="form-group refund-group" style="display: none;">
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">退货地址</label>
                    <div class="col-sm-9 col-xs-12">
                        <select class="form-control tpl-category-parent" id="raid" name="raid" style="width: 200px;">
                            <option value="0">默认地址</option>
                            <?php  if(is_array($refund_address)) { foreach($refund_address as $refund_address_item) { ?>
                            <option value="<?php  echo $refund_address_item['id'];?>" <?php  if($refund['refundaddressid'] == $refund_address_item['id']) { ?>selected="true"<?php  } ?>><?php  echo $refund_address_item['title'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <?php  } ?>

                <div class="form-group refund-group" style="display: none;">
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">留言</label>
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <textarea class="form-control" name="message" ><?php  echo $refund['message'];?></textarea>
                    </div>
                </div>

                <div class="form-group refuse-group" style="display: none;">
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">驳回原因</label>
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <textarea class="form-control" name="refundcontent" ></textarea>
                    </div>
                </div>

                <div class="form-group express-group" <?php  if($refund['status']!=5) { ?>style="display: none;"<?php  } ?>>
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label">快递公司</label>
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <select class="form-control" name="rexpress" id="rexpress">
                            <option value="" data-name="">其他快递</option>

                            <?php  if(is_array($express_list)) { foreach($express_list as $value) { ?>
                            <option value="<?php  echo $value['express'];?>" data-name="<?php  echo $value['name'];?>"><?php  echo $value['name'];?></option>
                            <?php  } } ?>

                        </select>
                        <input type='hidden' name='rexpresscom' id='rexpresscom' value="<?php  echo $refund['rexpresscom'];?>"/>
                    </div>
                </div>

                <div class="form-group express-group" <?php  if($refund['status']!=5) { ?>style="display: none;"<?php  } ?>>
                    <label class="col-xs-10 col-sm-3 col-md-3 control-label must">快递单号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="rexpresssn" class="form-control" value="<?php  echo $refund['rexpresssn'];?>" required/>
                    </div>
                </div>

    </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">提交</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
            </div>
        </div>
</form>
<script language='javascript'>
	$(function () {
        $(":radio[name=refundstatus]").change(function () {
            var refundstatus = $(this).val();

            if (refundstatus == -1) {
                $(".refuse-group").show();
                $(".refund-group").hide();
                $(".express-group").hide();
                $(".help-group").hide();
            } else if (refundstatus == 1) {
                $(".refuse-group").hide();
                $(".refund-group").hide();
                $(".express-group").hide();
                $(".help-group").show();
            } else if (refundstatus == 3) {
                $(".refuse-group").hide();
                $(".refund-group").show();
                $(".express-group").hide();
                $(".help-group").hide();
            } else if (refundstatus == 5) {
                $(".refuse-group").hide();
                $(".refund-group").hide();
                $(".express-group").show();
                $(".help-group").hide();
            } else {
                $(".refuse-group").hide();
                $(".refund-group").hide();
                $(".express-group").hide();
                $(".help-group").hide();
            }
        });

        $("select[name=rexpress]").val("<?php  echo $refund['rexpress'];?>");

        $("#rexpress").change(function () {
            var obj = $(this);
            var sel = obj.find("option:selected").attr("data-name");
            $("#rexpresscom").val(sel);
        });
    })
</script>