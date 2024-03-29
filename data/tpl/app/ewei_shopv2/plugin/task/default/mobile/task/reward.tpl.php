<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/task.css?v=<?php  echo time();?>"/>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/iconfont.css?v=<?php  echo time();?>"/>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/task/static/css/foxui.extends.css">
<script src="../addons/ewei_shopv2/plugin/task/static/js/iscroll.js"></script>
<title>任务中心</title>
<div class="fui-page">
    <div class="fui-header" style="z-index: 99">
        <div class="fui-header-left">
            <a class="back" href="<?php  echo mobileUrl('task')?>"></a>
        </div>
        <div class="title">奖励记录</div>
    </div>
    <div class="fui-content navbar" style="padding-bottom: 0;">
        <?php  if(empty($list)) { ?>
        <div style="height: 7rem;line-height:7rem;width: 100%;text-align: center;color: #d0d0d0;font-size: 1rem">暂时没有任何奖励</div>
        <?php  } ?>
        <div class='fui-list-group'>
            <?php  if(is_array($list)) { foreach($list as $rk => $reward) { ?>
            <div class="reward-list">
                <div class="reward-list-inner">
                    <div class="title">
                        <!--奖励图标-->
                        <?php  if($reward['reward_type'] == 'redpacket') { ?>
                        <i class="iconfont icon-hongbao"></i>&yen<?php  echo $reward['reward_data'];?>红包
                        <?php  } else if($reward['reward_type'] == 'credit') { ?>
                        <i class="iconfont icon-jifen"></i><?php  echo (int)$reward['reward_data']?><?php echo empty($tradeSet['credittext']) ? "积分" : $tradeSet['credittext']?>
                        <?php  } else if($reward['reward_type'] == 'balance') { ?>
                        <i class="iconfont icon-yue"></i>&yen<?php  echo $reward['reward_data'];?><?php echo empty($tradeSet['moneytext']) ? "余额" : $tradeSet['moneytext']?>
                        <?php  } else if($reward['reward_type'] == 'coupon') { ?>
                        <i class="iconfont icon-youhuiquan"></i><?php  echo $reward['reward_title'];?>
                        <?php  } else if($reward['reward_type'] == 'goods') { ?>
                        <i class="iconfont icon-shangpin"></i><?php  echo $reward['reward_title'];?>
                        <?php  } ?>
                    </div>
                    <div class="des" style="color: #ccc">
                        <span style="display:block;"><?php  echo $reward['tasktitle'];?></span>
                        <?php  echo substr($reward['gettime'],0,-3)?>
                    </div>
                </div>
                <!--领取按钮-->
                <div class="reward-list-right">
                    <?php  if($reward['reward_type'] == 'credit' || $reward['reward_type'] == 'balance' || $reward['sent'] == 1) { ?>
                        已发放
                    <?php  } else if($reward['reward_type'] == 'coupon') { ?>
                        <a href="<?php  echo mobileUrl('sale.coupon.my.detail')?>">查看</a>
                    <?php  } else if($reward['reward_type'] == 'redpacket') { ?>
                        <a onclick="getRed(<?php  echo $reward['id'];?>)">领取</a>
                    <?php  } else if($reward['reward_type'] == 'goods') { ?>
                        <a href="<?php  echo mobileUrl('goods.detail',array('id'=>(int)$reward['reward_data'],'taskrewardgoodsid'=>$reward['id']))?>">去下单</a>
                    <?php  } ?>
                </div>
            </div>
            <?php  } } ?>
        </div>
    </div>
</div>
<script>
    function getRed(id) {
        FoxUI.loader.show('mini');
        $.ajax({
            url:'<?php  echo mobileUrl("task.getred")?>',
            type:'post',
            data:{id:id},
            success:function (data) {
                data = JSON.parse(data);
                if (data.status == 1){
                    FoxUI.loader.hide();
                    FoxUI.alert('请到微信查收红包','领取成功');
                }else{
                    FoxUI.loader.hide();
                    FoxUI.alert('红包发送失败','领取失败');
                }
            },
            error:function () {
                FoxUI.alert('请稍后重试','网络错误');
            }
        });
    }
</script>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>