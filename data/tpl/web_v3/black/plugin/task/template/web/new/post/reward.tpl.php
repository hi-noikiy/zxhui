<?php defined('IN_IA') or exit('Access Denied');?><style>
    .selected{
        background-color: #f0ad4e;
        border-color: #f0ad4e;
    }
</style>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php  echo $tradeSet['credittext'];?></label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">奖励</span>
                <input type="text" name="rewardcredit" class="form-control" value="<?php  echo $reward['credit'];?>">
                <span class="input-group-addon"> <?php  echo $tradeSet['credittext'];?></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php  echo $tradeSet['moneytext'];?></label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">奖励</span>
                <input type="text" name="rewardbalance" class="form-control" value="<?php  echo $reward['balance'];?>">
                <span class="input-group-addon"> <?php  echo $tradeSet['moneytext'];?></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">微信红包</label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon">奖励</span>
                <input type="text" name="rewardredpacket" class="form-control" value="<?php  echo $reward['redpacket'];?>">
                <span class="input-group-addon">元 红包</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">商城优惠券</label>
        <div class="col-sm-9 col-xs-12">
            <a class="btn btn-default" data-target="#selector" onclick="$('#selector').modal();"data-type="coupon">
                <i class="fa fa-plus"></i> 选择优惠券</a>
            <textarea name="rewardcoupon" class="hide"><?php  echo json_encode($reward['coupon'])?></textarea>
        </div>
    </div>
    <div id="couponreward"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">特价商品</label>
        <div class="col-sm-9 col-xs-12">
            <?php  echo tpl_goods_selector('rewardgoods',$task['native_data'],array('condition'=>' and deleted = 0 and status = 1 and total>0','option'=>false,'column'=>array(array('title'=>'现价','name'=>'price'),array('title'=>'奖励数量','name'=>'num'),array('title'=>'商品别名','name'=>'title'))));?>
        </div>
    </div>

