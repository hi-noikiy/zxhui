<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="../addons/ewei_shopv2/template/mobile/default/static/sendticket/css/style.css" rel="stylesheet" />

<div class="fui-page">
    <div class="fui-content">
        <div class="share_body">
            <div class="share_main">
                <div class="share_head_img">
                    <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/bg7s.png" alt="" width="100%">
                </div>
                <div class="content_bg">
                <div class="share_title">
                    <?php  if($close == 1) { ?>
                    <span class="share_title_text" style="font-size: 0.95rem"><b>抱歉，活动已过期</b></span>
                    <?php  } else { ?>
                    <?php  if(!empty($newCoupon)) { ?>
                    <span class="share_title_text" style="font-size: 0.95rem"><b>恭喜你，获得了<?php  echo $num;?>张优惠券！</b></span>
                    <?php  } else { ?>
                    <span class="share_title_text" style="font-size: 0.95rem"><b>你已经领取过了哦</b></span>
                    <?php  } ?>
                    <?php  } ?>

                </div>
                <div class="content_list">
                    <ul>
                        <?php  if($close == 1) { ?>
                        <li style="width:100%;height:10rem;">
                            <div style="width:50%;height:100%;text-align: center;font-size: 0.65rem;color:#999;margin:0 auto;padding-top: 1rem;padding-bottom:1rem">
                                <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/overdue.png" alt="" width="100%" height="100%">
                            </div>
                        </li>
                        <?php  } else { ?>
                        <?php  if(!empty($newCoupon)) { ?>
                        <?php  if(is_array($newCoupon)) { foreach($newCoupon as $cpid => $cp) { ?>
                        <?php  if($cp['backtype'] == 0) { ?>
                        <li>
                            <div class="conpou">
                                <div class="list_content1 text-center">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#CCA865;line-height: 2rem;height:60%;">
                                        <span style="font-size: 1.5rem"><?php  echo intval($cp['deduct'])?></span><span style="font-size: 0.5rem">元</span>
                                    </div>
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#A5A5A5;font-size: 0.5rem;line-height: 1.2rem;height:40%;">
                                        <?php  if(intval($cp['enough']) == 0) { ?>
                                        无金额门槛
                                        <?php  } else { ?>
                                        满<?php  echo intval($cp['enough'])?>元可用
                                        <?php  } ?>
                                    </div>
                                    <!--<span><?php  echo intval($cp['deduct'])?></span><span style="font-size: 0.8rem">元</span>-->
                                </div>
                                <div class="modify">
                                </div>
                                <div class="list_content2 text-left">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#373737;font-size: 0.8rem"><?php  echo $cp['couponname'];?></div>
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#8C8C8C;font-size: 0.7rem">数量：<?php  echo $cp['cpnum'];?></div>
                                </div>
                            </div>
                        </li>
                        <?php  } else if($cp['backtype'] == 1) { ?>
                        <li>
                            <div class="conpou">
                                <div class="list_content1 text-center">
                                    <span style="font-size: 1.5rem"><?php  echo sprintf('%.1f', (float)$cp['discount']*10); ?></span><span style="font-size: 0.5rem">折</span>
                                </div>
                                <div class="modify">
                                </div>
                                <div class="list_content2 text-left">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#373737;font-size: 0.8rem"><?php  echo $cp['couponname'];?></div>
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#8C8C8C;font-size: 0.7rem">数量：<?php  echo $cp['cpnum'];?></div>
                                </div>
                            </div>
                        </li>
                        <?php  } else if($cp['backtype'] == 2) { ?>
                        <li>
                            <div class="conpou">
                                <div class="list_content1 text-center">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#CCA865;line-height: 2rem;height:60%;">
                                        <?php  if(!empty($cp['backmoney']) && !empty($cp['backcredit']) && !empty($cp['backredpack']) ) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.5rem">元红包</span>
                                        <?php  } else if(!empty($cp['backmoney']) && !empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backmoney'];?></span><span style="font-size: 0.5rem">余额</span>
                                        <?php  } else if(!empty($cp['backmoney']) && empty($cp['backcredit']) && !empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.5rem">元红包</span>
                                        <?php  } else if(empty($cp['backmoney']) && !empty($cp['backcredit']) && !empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.5rem">元红包</span>
                                        <?php  } else if(empty($cp['backmoney']) && empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backredpack'];?></span><span style="font-size: 0.5rem">元红包</span>
                                        <?php  } else if(empty($cp['backmoney']) && !empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backcredit'];?></span><span style="font-size: 0.5rem">积分</span>
                                        <?php  } else if(!empty($cp['backmoney']) && empty($cp['backcredit']) && empty($cp['backredpack'])) { ?>
                                        <span style="font-size: 1.5rem"><?php  echo $cp['backmoney'];?></span><span style="font-size: 0.5rem">余额</span>
                                        <?php  } ?>
                                    </div>
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#A5A5A5;font-size: 0.5rem;line-height: 1.2rem;height:40%;">
                                        <?php  if(intval($cp['enough']) == 0) { ?>
                                        无金额门槛
                                        <?php  } else { ?>
                                        满<?php  echo intval($cp['enough'])?>元可用
                                        <?php  } ?>
                                    </div>
                                </div>
                                <div class="modify">
                                </div>
                                <div class="list_content2 text-left">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#373737;font-size: 0.8rem"><?php  echo $cp['couponname'];?></div>
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#8C8C8C;font-size: 0.7rem">数量：<?php  echo $cp['cpnum'];?></div>
                                </div>
                            </div>
                        </li>
                        <?php  } ?>

                        <?php  } } ?>
                        <?php  } else { ?>
                        <li style="width:100%;height:1rem;">
                            <div style="width:100%;height:25%;text-align: center;line-height: 1rem;font-size: 0.65rem;color:#999">优惠券已放入你的账户</div>
                        </li>
                        <li style="width:100%;height:4.2rem;">
                            <div style="width:50%;height:100%;text-align: center;font-size: 0.65rem;color:#999;margin:0 auto;margin-top: 1rem">
                                <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/get.png" alt="" width="100%" height="100%">
                            </div>
                        </li>
                        <?php  } ?>
                        <?php  } ?>
                    </ul>
                    <?php  if($close == 1) { ?>
                    <div class="share_button">
                        <a href="<?php  echo mobileUrl('index')?>" class="external" data-nocache="true">
                            <div class="button_c text-center">
                                返回首页
                            </div>
                        </a>
                    </div>
                    <?php  } else { ?>
                    <div class="share_button">
                        <a href="<?php  echo mobileUrl('sale/coupon/my')?>" class="external" data-nocache="true">
                            <div class="button_c text-center">
                                立即查看
                            </div>
                        </a>
                    </div>
                    <?php  } ?>

                </div>
                </div>
                <div class="share_firend">
                    <div class="firend_title">
                        <!--<div class="q_c" style="width:10%;"><img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/circle.png" style="" /></div>-->
                         <span class="q_t" style="width:100%;">
                            <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/circle.png" style="width:1rem;margin-top: 0.45rem">
                            <span style="margin-left:0.2rem;margin-right: 0.2rem">看看谁领了券</span>
                            <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/circle.png" style="width:1rem;margin-top: 0.45rem">
                        </span>
                        <!--<div class="q_c" style="width:10%"><img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/circle.png"></div>-->
                    </div>
                    <div class="firend_contents">
                        <ul>
                            <?php  if(!empty($firendlist)) { ?>
                            <?php  if(is_array($firendlist)) { foreach($firendlist as $listid => $list) { ?>
                            <li>
                                <div class="firend_contents_logo">
                                    <img src="<?php  echo $list['headimg'];?>" alt="" width="100%" height="100%">
                                </div>

                                <div class="firend_contents_info">
                                    <div style="width:100%;height:50%;line-height: 2rem">
                                        <span style="float:left;max-width:45%;height:100%;font-size: 0.75rem;color:#ffeb43;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php  echo $list['nickname'];?></span>
                                        <span style="width:50%;height:100%;color:#FCE3E4;float:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;padding-left: 0.6rem"><?php  echo date('m-d H:i',$list['gettime'])?></span>
                                    </div>
                                    <div style="width:100%;height:50%;color:#FCE3E4;font-size: 0.65rem;line-height: 1.6rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="motto"><?php  echo $list['text'];?></div>
                                </div>
                            </li>
                            <?php  } } ?>
                            <?php  } ?>


                        </ul>
                    </div>
                </div>
                <div class="bottom" style="text-align: center;line-height: 4rem">

                </div>
            </div>

        </div>

        <div class="share_img">
            <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/guide1.png" alt="">
        </div>
    </div>
</div>

<script language='javascript'>
    $(document).ready(function(){
        $(".unfold").click(function(){
            if($(this).children().attr('src') == '../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/unfold.png'){
                $(this).children().attr('src','../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/packup.png');
                $(this).parent().parent().next().css('display','block');
            }else{
                $(this).children().attr('src','../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/unfold.png');
                $(this).parent().parent().next().css('display','none');
            }
        });
    });

</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
