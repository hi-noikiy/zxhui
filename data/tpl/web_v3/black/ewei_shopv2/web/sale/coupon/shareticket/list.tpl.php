<?php defined('IN_IA') or exit('Access Denied');?>
<?php  if(is_array($gifts)) { foreach($gifts as $item) { ?>
<tr>

    <td style='text-align:center;'>
        <?php if(cv('sale.coupon.shareticket')) { ?>
        <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('sale/sendticket/share/change',array('typechange'=>'order','id'=>$item['id']))?>" ><?php  echo $item['order'];?></a>
        <?php  } else { ?>
        <?php  echo $item['order'];?>
        <?php  } ?>
    </td>
    <!--<td>-->
        <!--<img src="<?php  echo tomedia($item['shareicon'])?>" style="width:40px;height:40px;padding:1px;border:1px solid #ccc;"  />-->
    <!--</td>-->
    <td class='full' style="overflow-x: hidden">
        <?php if(cv('sale.coupon.shareticket')) { ?>
        <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('sale/sendticket/share/change',array('typechange'=>'sharetitle','id'=>$item['id']))?>" ><?php  echo $item['sharetitle'];?></a>
        <?php  } else { ?>
        <?php  echo $item['sharetitle'];?>
        <?php  } ?>
    </td>
    <td>
        <?php if(cv('sale.coupon.shareticket')) { ?>
        满<a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('sale/sendticket/share/change',array('typechange'=>'enough','id'=>$item['id']))?>" ><?php  echo $item['enough'];?></a>
        <?php  } else { ?>
        <?php  echo $item['enough'];?>
        <?php  } ?>
    </td>
    <td>
        <span class='label <?php  if($item['state']=='已结束') { ?>label-default<?php  } else { ?>label-primary<?php  } ?>'><?php  echo $item['state'];?></span>
    </td>
    <td  style="overflow:visible;">
        <span class='label <?php  if($item['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
        <?php if(cv('sale.package.edit')) { ?>
        data-toggle='ajaxSwitch'
        data-confirm = "确认是<?php  if($item['status']==1) { ?>关闭<?php  } else { ?>开启<?php  } ?>？"
        data-switch-refresh='true'
        data-switch-value='<?php  echo $item['status'];?>'
        data-switch-value0='0|关闭|label label-default|<?php  echo webUrl('sale/coupon/shareticket/status',array('status'=>1,'id'=>$item['id']))?>'
        data-switch-value1='1|开启|label label-success|<?php  echo webUrl('sale/coupon/shareticket/status',array('status'=>0,'id'=>$item['id']))?>'
        <?php  } ?>>
        <?php  if($item['status']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?></span>
    </td>
    <td  style="overflow:visible;position:relative;text-align: center;">
        <?php if(cv('sale.coupon.shareticket')) { ?>
        <a  class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('sale/coupon/shareticket/edit', array('type'=>$_GPC['type'],'id' => $item['id'],'page'=>$page))?>" title="<?php if(cv('sale.sendticket.share.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
            <span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('sale.sendticket.share.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                <?php if(cv('sale.coupon.shareticket.edit')) { ?>
                    <i class='icow icow-bianji2'></i>
                <?php  } else { ?>
                 <i class='icow icow-chakan-copy'></i>
                <?php  } ?>
           </span>
        </a>
        <?php  } ?>
        <?php if(cv('sale.coupon.shareticket.delete1')) { ?>
        <a  class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('sale/coupon/shareticket/delete1', array('id' => $item['id']))?>" data-confirm='如果此活动存在记录，会无法关联到相关信息, 确认要删除吗?？'>
             <span data-toggle="tooltip" data-placement="top" data-original-title="删除">
                <i class='icow icow-shanchu1'></i>
           </span>
        </a>
        <?php  } ?>
    </td>
</tr>
<?php  } } ?>

