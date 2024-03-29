<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
    .order-container{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .order-container-left,.order-container-right{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
    }
	.ordertable { width:100%;position: relative;margin-bottom:10px}
	.ordertable tr td:first-child { text-align: right }
	.ordertable tr td {padding:8px 5px 0;vertical-align: top}
	.ordertable1 tr td { text-align: right; }
	.ops .btn { padding:5px 10px;}
    <?php  if(count($step_array)>4) { ?>.ui-step-4 li { width:20%;}<?php  } ?>
    .order-container-right{
        padding:30px 0 0 15px ;
    }
    .trorder td{
        text-align: center;
    }
    .navbar-inner tr th{
        text-align: center
    }
    .table .trorder td{
        border-right:1px solid #efefef;
    }
    .table .trorder td:nth-of-type(1){
        border:none;
    }
</style>
<div class="page-header"> <span class="text-primary">维权处理</span></div>
<div class="page-content">
<?php  if(!empty($step_array)) { ?>
<div class="step-region" >
	<ul class="ui-step ui-step-4" >

        <?php  if(is_array($step_array)) { foreach($step_array as $k1 => $v1) { ?>
        <li <?php  if($v1['done']==1) { ?>class="ui-step-done"<?php  } ?>>
            <div class="ui-step-number"><?php  echo $v1['step'];?></div>
            <div class="ui-step-title"><?php  echo $v1['title'];?></div>
            <div class="ui-step-meta"><?php  if(!empty($v1['time'])) { ?><?php  echo date('Y-m-d',$v1['time'])?><br/><?php  echo date('H:i:s',$v1['time'])?><?php  } ?></div>
        </li>
        <?php  } } ?>


	</ul>
</div>
<?php  } ?>
   <form class="form-horizontal form" action="" method="post">
        <input type="hidden" name="id" value="<?php  echo $item['ordergoodsid'];?>" />
        
        <input type="hidden" name="dispatchid" value="<?php  echo $dispatch['id'];?>" />

	<div  class='row order-container'>
		<div class="order-container-left" style="border-right: 1px solid #efefef">
			<div class='panel-body' >
				 <h4 class="m-t-none m-b">维权信息</h4>
				 <div class="form-group" style='padding:0 10px;'>


                     <div style="display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;margin:10px">
                         <img src="<?php  echo tomedia($goods['thumb'])?>" style='width:70px;height:70px;border:1px solid #efefef; padding:1px;'onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'">
                         <a target="_blank" href="<?php  echo merchUrl('goods/edit', array('id' => $goods['id']))?>"title="查看" style="display: block;line-height: 22px;max-width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                             <div style="-webkit-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;margin-left: 10px;margin-top:2px;text-align: left;display: flex;align-items: center">

                                     <div class="title">
                                         <?php  echo $goods['title'];?><br>
                                         <?php  if(!empty($goods['optionname'])) { ?><span class="label label-info"><span style="color: #999"><?php  echo $goods['optionname'];?></span><br></span><?php  } ?>
                                         <span style="color: #999;width:130px;">￥<?php  echo $goods['orderprice'];?>x<?php  echo $goods['total'];?></span>
                                     </div>

                             </div>
                         </a>
                     </div>

					 <table class='ordertable' style='table-layout:fixed'>
						 <tr>
							 <td style='width:80px'>维权类型：</td>
						            <td><?php  echo $r_type[$refund['rtype']];?></td>
						 </tr>

                         <?php  if($refund['rtype']!=2) { ?>
                         <tr>
                             <td style='width:80px'>退款金额：</td>
                             <td><?php  echo $refund['applyprice'];?>(元)</td>
                         </tr>
                         <?php  } ?>

                         <tr>
                             <td style='width:80px'>维权原因：</td>
                             <td><?php  echo $refund['reason'];?></td>
                         </tr>

                         <tr>
                             <td style='width:80px'>维权说明：</td>
                             <td style="white-space: normal;"><?php  echo $refund['content'];?></td>
                         </tr>

                         <?php  if(!empty($refund['imgs'])) { ?>
                         <tr>
                             <td style='width:80px'>图片凭证：</td>
                             <td>
                                 <?php  if(is_array($refund['imgs'])) { foreach($refund['imgs'] as $k1 => $v1) { ?>
                                 <a target='_blank' href='<?php  echo tomedia($v1)?>'><img style='width:100px;;padding:1px;border:1px solid #ccc' src='<?php  echo tomedia($v1)?>'></a>
                                 <?php  break;?>
                                 <?php  } } ?>
                                 &nbsp;
                                 <?php  if(count($refund['imgs']) > 1) { ?>
                                 <a data-toggle='popover' data-html='true' data-placement='right'
                                    data-content="<table style='width:100%;'>
                        <?php  if(is_array($refund['imgs'])) { foreach($refund['imgs'] as $k1 => $v1) { ?>
                        <tr>
                        <td  style='border:none;text-align:right;padding:5px;'>
                            <a target='_blank' href='<?php  echo tomedia($v1)?>'><img style='width:100px;;padding:1px;border:1px solid #ccc' src='<?php  echo tomedia($v1)?>'></a>
                        </td>
                        </tr>
                        <?php  } } ?>
                </table>
">查看全部</a>
<?php  } ?>
                             </td>
                         </tr>
                         <?php  } ?>

                         <tr>
                             <td style='width:80px'>维权编号：</td>
                             <td><?php  echo $refund['refundno'];?></td>
                         </tr>

                         <tr>
                             <td style='width:80px'>订单编号：</td>
                             <td><a href="<?php  echo merchUrl('order/detail', array('id' => $item['id']))?>" target="_blank" title=""><?php  echo $item['ordersn'];?></a></td>
                         </tr>

						 <tr>
							<td>订单金额：</td>
							<td>￥<?php  echo number_format($item['price'],2)?></td>
						 </tr>

                         <tr>
                             <td>买家：</td>
                             <td><?php  echo $member['nickname'];?> <a data-toggle='popover' data-html='true' data-trigger="hover" data-placement='right'
                                                          data-content="<table style='width:100%;'>
                <tr>
                    <td  style='border:none;text-align:right;' colspan='2'><img src='<?php  echo $member['avatar'];?>' style='width:100px;height:100px;padding:1px;border:1px solid #ccc' /></td>
                </tr>
                                <tr>
                    <td  style='border:none;text-align:right;'>昵称：</td>
                    <td  style='border:none;text-align:right;'><?php  echo $member['nickname'];?></td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>姓名：</td>
                    <td  style='border:none;text-align:right;'><?php  echo $member['realname'];?></td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>ID：</td>
                    <td  style='border:none;text-align:right;'><?php  echo $member['id'];?></td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>手机号：</td>
                    <td  style='border:none;text-align:right;'><?php  echo $member['mobile'];?></td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>微信号：</td>
                    <td  style='border:none;text-align:right;'><?php  echo $member['weixin'];?></td>
                </tr>
                </table>
"><i class='icow icow-help' style="font-size: 13px;color: #2f3434;margin-left: -3px"></i></a></td>
                         </tr>

                         <tr>
                             <td style='width:80px'>付款时间：</td>
                             <td><?php  echo date('Y-m-d H:i:s', $item['paytime'])?></td>
                         </tr>

                         <tr>
                             <td style='width:80px'>付款方式：</td>
                             <td> <?php  if($item['paytype'] == 0) { ?>未支付<?php  } ?>
                                 <?php  if($item['paytype'] == 1) { ?>余额支付<?php  } ?>
                                 <?php  if($item['paytype'] == 11) { ?>后台付款<?php  } ?>
                                 <?php  if($item['paytype'] == 21) { ?>微信支付<?php  } ?>
                                 <?php  if($item['paytype'] == 22) { ?>支付宝支付<?php  } ?>
                                 <?php  if($item['paytype'] == 23) { ?>银联支付<?php  } ?>
                                 <?php  if($item['paytype'] == 3) { ?>货到付款<?php  } ?>
                             </td>
                         </tr>

                     </table>

                </div>
			</div>
		</div>

        <div class="order-container-right" >
            <div class='panel-body' style='height:450px;' >

                <div class='row'>
                    <div class='col-sm-3 control-label'>维权状态: </div>
                    <div class="col-sm-9 col-xs-12">
                        <h3 class="form-control-static">
                            <?php  if($refund['status'] == -2) { ?><span class="text-default">客户取消<?php  echo $r_type[$refund['rtype']];?></span>

                            <?php  } else if($refund['status'] == -1) { ?><span class="text-default">已拒绝<?php  echo $r_type[$refund['rtype']];?></span>

                            <?php  } else if($refund['status'] == 0) { ?><span class="text-warning">等待商家处理申请</span>

                            <?php  } else if($refund['status'] == 1) { ?><span class="text-default"><?php  echo $r_type[$refund['rtype']];?>完成</span>

                            <?php  } else if($refund['status'] == 3) { ?><span class="text-warning">等待客户退回物品</span>

                            <?php  } else if($refund['status'] == 4) { ?><span class="text-warning">客户退回物品，等待商家重新发货</span>

                            <?php  } else if($refund['status'] == 5) { ?><span class="text-warning">等待客户收货</span><?php  } ?>

                        </h3>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static ops">
                            <?php  if($item['merchid'] > 0) { ?>
                                <?php  if(($refund['status'] == 0 || $refund['status'] >1)) { ?>
                                <a class="btn btn-primary btn-xs" data-toggle="ajaxModal"  href="<?php  echo merchUrl('order/op/single_refund/submit', array('id' => $item['ordergoodsid']))?>">处理申请</a>
                                <?php  } ?>
                            <?php  } ?>
                        </p>
                    </div>
                </div>

                <?php  if($refund['rtype']>0 && !empty($refund['expresssn'])) { ?>
                <div class='row'>
                    <div class='col-sm-3 control-label' style='padding-top:10px;'>
                        客户退回物品 :
                    </div>
                    <div class="col-sm-9 col-xs-12">
                            <div class="form-control-static">
                                快递公司: <?php  if(empty($refund['expresscom'])) { ?>其他快递<?php  } else { ?><?php  echo $refund['expresscom'];?><?php  } ?><br>
                                快递单号: <?php  echo $refund['expresssn'];?> &nbsp;&nbsp;&nbsp;<a class='op' data-toggle="ajaxModal" href="<?php  echo merchUrl('util/express', array('id' => $item['ordergoodsid'],'express'=>$refund['express'],'expresssn'=>$refund['expresssn']))?>">查看物流</a><br>
                                退回时间: <?php  echo date('Y-m-d H:i:s', $refund['sendtime'])?>
                            </div>
                    </div>
                </div>
                <?php  } ?>

                <?php  if($refund['rtype']==2 && !empty($refund['rexpresssn'])) { ?>
                <div class='row'>
                    <div class='col-sm-3 control-label' style='padding-top:10px;'>
                        商家寄出物品 :
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static">
                            快递公司: <?php  if(empty($refund['rexpresscom'])) { ?>其他快递<?php  } else { ?><?php  echo $refund['rexpresscom'];?><?php  } ?><br>
                            快递单号: <?php  echo $refund['rexpresssn'];?> &nbsp;&nbsp;&nbsp;<a class='op' data-toggle="ajaxModal" href="<?php  echo merchUrl('util/express', array('id' => $item['ordergoodsid'],'express'=>$refund['rexpress'],'expresssn'=>$refund['rexpresssn']))?>">查看物流</a><br>
                            发货时间: <?php  echo date('Y-m-d H:i:s', $refund['returntime'])?>
                        </div>
                    </div>
                </div>
                <?php  } ?>

                <?php  if($refund['status'] == -1 && !empty($refund['reply'])) { ?>
                    <div class='row'>
                        <div class='col-sm-3 control-label'>拒绝原因: </div>
                        <div class="col-sm-9 col-xs-12">
                            <h3 class="form-control-static">
                                <?php  echo $refund['reply'];?>

                            </h3>
                        </div>
                    </div>
                <?php  } ?>


            </div>

        </div>
</div>
   </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
