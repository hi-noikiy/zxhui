<?php defined('IN_IA') or exit('Access Denied');?>

<link href="../addons/ewei_shopv2/template/mobile/default/static/sendticket/css/style.css" rel="stylesheet" />
<link href="//at.alicdn.com/t/font_fmr96shbrjrwwmi.css" rel="stylesheet" />



<div class="eject-outer">
    <div class="eject">
        <div class="eject1">
            <p class="icon_1">新人礼包</p>
            <p class="icon_2">优惠券已发送到您的账户</p>
        </div>
        <?php  if(is_array($cpinfos)) { foreach($cpinfos as $cpid => $cp) { ?>
        <a href="<?php  echo mobileUrl('sale/coupon/my/detail',array('id' => $cp['did']))?>">
        <div class="eject2"style="margin-top: 0.3rem">
            <div class="eject2_content">
                <div class="eject2_one">
                    <div class="icon_3" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php  echo $cp['couponname'];?></div>
                    <div class="icon_4" style="width:70%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#666">满<?php  echo $cp['enough'];?>元可用</div>
                    <div class="icon_5" style="color:#999">有效期：
                        <?php  if($cp['timelimit'] == 0) { ?>
                            <?php  echo date('Y-m-d',TIMESTAMP)?>至<?php  echo date('Y-m-d',TIMESTAMP+(60*60*24*intval($cp['timedays'])))?>
                        <?php  } else if($cp['timelimit'] == 1) { ?>
                            <?php  echo date('Y-m-d',$cp['timestart'])?>至<?php  echo date('Y-m-d',$cp['timeend'])?>
                        <?php  } ?>

                    </div>
                </div>
                <div class="eject2_two">
                    <?php  if($cp['backtype'] == 0) { ?>
                    <!--<i class="iconfont icon-jiage-copy icon_6"></i>-->
                    <span class="eject2_two1" >
                        <?php  echo floatval($cp['deduct'])?><span style="font-size: 0.6rem">元</span>
                    </span>
                    <?php  } else if($cp['backtype'] == 1) { ?>
                    <span class="eject2_two1">
                        <?php  echo sprintf('%.1f', floatval($cp['discount']))?><span style="font-size: 0.6rem">折</span>
                    </span>
                    <?php  } else if($cp['backtype'] == 2) { ?>
                    <!--<i class="iconfont icon-jiage-copy icon_6"></i>-->
                    <span class="eject2_two1" style="width: 60px;left:9.7rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <?php  if(!empty($cp['backmoney']) && !empty($cp['backcredit']) && !empty($cp['backredpack']) ) { ?>
                            <span><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.6rem">元</span>
                        <?php  } else if(!empty($cp['backmoney']) && !empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backmoney'];?></span><span style="font-size: 0.5rem">余额</span>
                        <?php  } else if(!empty($cp['backmoney']) && empty($cp['backcredit']) && !empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.6rem">元</span>
                        <?php  } else if(empty($cp['backmoney']) && !empty($cp['backcredit']) && !empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.6rem">元</span>
                        <?php  } else if(empty($cp['backmoney']) && empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.6rem">元</span>
                        <?php  } else if(empty($cp['backmoney']) && !empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backcredit'];?></span><span style="font-size: 0.6rem">积分</span>
                        <?php  } else if(!empty($cp['backmoney']) && empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                            <span><?php  echo $cp['backmoney'];?></span><span style="font-size: 0.5rem">余额</span>
                        <?php  } ?>
                    </span>
                    <?php  } ?>
                </div>
            </div>
        </div>
        </a>
        <?php  } } ?>

        <div class="eject3">
            <p class="icon_7"><a class="icon_7" href="#">知道了</a></p>
        </div>
        <!--<div data-dismiss="modal" class="eject4"><i class="iconfont icon-guanbi1 icon_8"></i></div>-->

    </div>
</div>


<script language='javascript'>
    $(document).ready(function(){
        require(['biz/sale/sendticket/index'], function (modal) {
            modal.init()
        });

        $(".eject3").click(function(){
            $('.fui-mask').fadeOut();
            $('.eject-outer').fadeOut();
        });
    });
</script>
