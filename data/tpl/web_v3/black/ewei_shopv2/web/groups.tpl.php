<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.tc{text-align: center;}
.groups_pointer{cursor: pointer;}
.ibox-title .label{
    margin-top: 15px;
}
    .summary_box .label{
        margin: 15px 0 0 30px;
    }
.summary_box h5{
    margin: 15px 30px 0 0px;
}
    .form-group-title{
        height:30px;
        line-height: 40px;
        border:none;
    }
.form-group-title:before{
    content: '';
    width:0;
    height: 0;
}
</style>
<div class="page-header">
    当前位置：
    <span class="text-primary">拼团概述</span>
</div>
<div class="page-content">
    <div class="form-group-title">拼团</div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="summary_box float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-success pull-left" style="margin:15px 0 0 30px">已成团</span>
                </div>
                <div class="summary flex">
                    <div class="flex1 flex column">
                        <div class=" groups_pointer" onclick="javascript:window.location.href='<?php  echo webUrl('groups/team', array('type' => success))?>'">
                            数量
                        </div>
                        <h2 class=" no-margins team-success-count">--</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="summary_box float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-primary pull-left" style="margin: 15px 0 0 30px">拼团中</span>
                </div>
                <div class="summary flex">

                    <div class="flex1 flex column">
                        <div class="col-md-12 text-center groups_pointer" onclick="javascript:window.location.href='<?php  echo webUrl('groups/team', array('type' => ing))?>'">
                            数量
                        </div>
                            <h2 class="no-margins team-ing-count">--</h2>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group-title">订单</div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="summary_box  float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-primary pull-left">今日成交</span>
                    <h5 class="pull-right">人均消费 : ¥ <span class="today-avg"></span></h5>
                </div>
                <div class="summary flex">
                    <div class="flex1 flex column" style="border-right: 1px solid #efefef">
                        <div class="">
                            成交量
                        </div>
                            <h2 class="no-margins today-count">--</h2>
                    </div>
                    <div class="flex1 flex column">
                        <div class="">
                            成交额
                        </div>
                            <h2 class="no-margins text-danger">¥ <span class="today-price">--</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="summary_box float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-success pull-left">昨日成交</span>
                    <h5 class="pull-right">人均消费 : ¥ <span class="yesterday-avg">--</span></h5>
                </div>
                <div class="summary flex">

                    <div class="flex1 flex column" style="border-right: 1px solid #efefef">
                        <div class="">
                            成交量
                        </div>
                            <h2 class="no-margins yesterday-count">--</h2>

                    </div>
                    <div  class="flex1 flex column">
                        <div class="">
                            成交额
                        </div>
                            <h2 class="no-margins text-danger">¥ <span class="yesterday-price">--</span></h2>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="summary_box float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-warning pull-left">近7日成交</span>
                    <h5 class="pull-right">人均消费 : ¥ <span class="seven-avg">--</span></h5>
                </div>
                <div class="summary flex">

                    <div class="flex1 flex column"  style="border-right: 1px solid #efefef">
                        <div class="">
                            成交量
                        </div>
                            <h2 class="no-margins seven-count">--</h2>
                    </div>
                    <div  class="flex1 flex column">
                        <div class="">
                            成交额
                        </div>
                            <h2 class="no-margins text-danger">¥ <span class="seven-price">--</span></h2>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="summary_box float-e-margins" style="border: 1px solid #e7eaec">
                <div class="summary_title">
                    <span class="label label-danger pull-left">近1个月成交</span>
                    <h5 class="pull-right">人均消费 : ¥ <span class="month-avg">--</span></h5>
                </div>
                <div class="summary flex">

                    <div class="flex1 flex column"  style="border-right: 1px solid #efefef">
                        <div class="">
                            成交量
                        </div>
                            <h2 class="no-margins month-count">--</h2>
                    </div>
                    <div class="flex1 flex column">
                        <div class="">
                            成交额
                        </div>
                        <h2 class="no-margins text-danger">¥ <span class="month-price">--</span></h2>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <?php  if(!empty($order_ok)) { ?>
            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                <div class="ibox-title">
                    <h5>用户购买待发货订单</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th class="col-sm-1 tc">状态</th>
                            <th class="col-sm-2 tc">日期</th>
                            <th class="col-sm-2 tc">金额</th>
                            <th class="col-sm-4">用户</th>
                            <th class="col-sm-2 tc">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  if(is_array($order_ok)) { foreach($order_ok as $key => $value) { ?>
                        <tr>
                            <td class="tc"><span class="label label-warning">待发货</span>
                            </td>
                            <td class="tc"><?php  echo date('Y-m-d H:i',$value['createtime'])?></td>
                            <td class="text-navy tc">¥ <?php  echo $value['price'];?></td>
                            <td><?php echo !empty($value['realname']) ? $value['realname'] : $value['nickname']?></td>
                            <td class="tc">
                                <?php if(cv('order.detail')) { ?>
                                    <a href="<?php  echo webUrl('groups/order/detail',array('orderid'=>$value['id']))?>" class="btn btn-xs btn-primary">查看详情</a></td>
                                <?php  } ?>
                        </tr>
                        <?php  } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php  } else { ?>
            <div class="panel panel-default">
                <div class="panel-body" style="text-align: center;padding:30px;">
                    暂时没有任何待处理订单!
                </div>
            </div>
            <?php  } ?>
        </div>
    </div>
</div>
<script>
    $(function(){
        /*
        * 拼团成功
        * */
        $.getJSON("<?php  echo webUrl('groups/order/ajaxteam');?>", { success: "1"}, function(json){
            $(".team-success-count").text(json.count);
            $(".team-success-price").text(json.price);
            /*
            * 拼团失败
            * */
            $.getJSON("<?php  echo webUrl('groups/order/ajaxteam');?>", { success: "0"}, function(json){
                $(".team-ing-count").text(json.count);
                $(".team-ing-price").text(json.price);
                $(".team-ing-avg").text(json.avg);
                /*
                * 今日订单成交
                * */
                $.getJSON("<?php  echo webUrl('groups/order/ajaxorder');?>", { day: "0"}, function(json){
                    $(".today-count").text(json.count);
                    $(".today-price").text(json.price);
                    $(".today-avg").text(json.avg);
                    /*
                    * 昨日订单成交
                    * */
                    $.getJSON("<?php  echo webUrl('groups/order/ajaxorder');?>", { day: "1"}, function(json){
                        $(".yesterday-count").text(json.count);
                        $(".yesterday-price").text(json.price);
                        $(".yesterday-avg").text(json.avg);
                        /*
                         * 近7天订单成交
                         * */
                        $.getJSON("<?php  echo webUrl('groups/order/ajaxorder');?>", { day: "6"}, function(json){
                            $(".seven-count").text(json.count);
                            $(".seven-price").text(json.price);
                            $(".seven-avg").text(json.avg);
                            /*
                             * 近30天订单成交
                             * */
                            $.getJSON("<?php  echo webUrl('groups/order/ajaxorder');?>",{ day: "30"},function(json){
                                $(".month-count").text(json.count);
                                $(".month-price").text(json.price);
                                $(".month-avg").text(json.avg);
                            });
                        });
                    });
                });
            });
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
