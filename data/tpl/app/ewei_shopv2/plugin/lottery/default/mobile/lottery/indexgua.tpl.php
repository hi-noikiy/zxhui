<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script>document.title = "<?php  echo $lottery['lottery_title'];?>"; </script>

<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/lottery/static/style/mobilegua.css?<?php  echo time();?>" />

<div class='fui-page  fui-page-current'>

    <div class="fui-content lottery-content">
        <?php  if(!empty($lottery) ) { ?>
        <div class="lottery-title">
            <marquee direction=left scrollamount=6 style="color: #ffffff;background: #000000;opacity: 0.7;">
                <?php  if(!empty($log)) { ?>

                <?php  if(is_array($log)) { foreach($log as $key => $value) { ?>
                <?php  if(!empty($value['lottery_data'])) { ?>
                <?php  $value['lottery_data']=unserialize($value['lottery_data'])?>
                <?php  if(isset($value['lottery_data']['credit'])) { ?>
                <?php  $reward_name='积分';?>
                <?php  } else if(isset($value['lottery_data']['money'])) { ?>
                <?php  $reward_name='奖金';?>
                <?php  } else if(isset($value['lottery_data']['bribery'])) { ?>
                <?php  $reward_name='红包';?>
                <?php  } else if(isset($value['lottery_data']['goods'])) { ?>
                <?php  $reward_name='特惠商品';?>
                <?php  } else if(isset($value['lottery_data']['coupon'])) { ?>
                <?php  $reward_name='优惠券';?>
                <?php  } ?>
                <?php  echo $value['nickname'];?>[抽到<?php  echo $reward_name;?>,时间:<?php  echo date('Y-m-d',$value['addtime']);?>]
                <?php  } ?>
                <?php  } } ?>

                <?php  } else { ?>
                暂无中奖记录...
                <?php  } ?>
            </marquee>
        </div>
        <style>
            .lottery-content{
                background: url("<?php  echo $lottery['lottery_banner'];?>");
                background-size: 100% 100%;
            }
        </style>

        <div class="lottery" >
            <div class="result">
                <span class="result-span" id="result_span"></span>
            </div>
            <div class="inner">
                <img class="gua-img" id="gua-img" src="../addons/ewei_shopv2/plugin/lottery/static/images/gua2.png">
            </div>
        </div>

        <div class="lottery_footer">
            <img class="lottery_memberhead" src="<?php  echo $member['avatar'];?>">
            <p>剩余抽奖次数:<span id="left_changes" style="color: #ff3f4b"><?php  echo intval($has_changes);?></span>次</p>
            <div class="lottery_row">
                <div class="lottery_col_6">
                    <a class="btn btn-danger" href="<?php  echo mobileUrl('lottery/index/lottery_reward',array('id'=>$lottery['lottery_id']),true);?>" style="width: 6rem;">奖励说明</a>
                </div>
                <div class="lottery_col_6">
                    <a class="btn btn-primary" href="<?php  echo mobileUrl('lottery/index/myreward',array(),true);?>" style="background-color: #13afbe;border-color: #13afbe;">我的中奖记录</a>
                </div>
            </div>
        </div>

        <?php  } else { ?>
            <p class="text-white text-center" style="font-size: 2.5rem;">无活动</p>
        <?php  } ?>
    </div>

</div>

<div id="model" style="display: none;">
    <div class="task-model">
        <div class="task-model-content" ><h4 id="model-title">恭喜您!领取**任务成功!!</h4></div>
        <div class="task-model-footer task-btn-close">好的</div>
    </div>
</div>

<div id="failmodel" style="display: none;">
    <div class="task-model">
        <div class="task-model-faile-content" ><h4 id="model-failtitle">很遗憾!您没有抽奖次数!!</h4></div>
        <div class="task-model-footer task-btn-close">好的，我知道了</div>
    </div>
</div>
<?php  if(!empty($lottery) ) { ?>
<script type="text/javascript" src="../addons/ewei_shopv2/plugin/lottery/static/js/jquery.eraser.js"></script>
<script type="text/javascript">
    var is_login = <?php echo empty($_W['openid'])?0:1;?>;
    require(['../addons/ewei_shopv2/plugin/lottery/static/js/index.js'],function(modal){modal.init({changes:<?php  echo intval($has_changes);?>,is_login:is_login,id:<?php  echo $lottery['lottery_id'];?>,toast:'<?php  echo $lottery['lottery_cannot'];?>'});});
    function tabInfo(obj) {
        var tab_id = $(obj).data('value');
        if(tab_id=='rewardinfo'){
            $('#lotteryinfo').hide();
            $('#myreward').hide();
            $('a[data-value="lotteryinfo"]').removeClass('active');
            $('a[data-value="myreward"]').removeClass('active');
            $(obj).addClass('active')
            $('#rewardinfo').show();
        }
        if(tab_id=='lotteryinfo'){
            $('#rewardinfo').hide();
            $('#myreward').hide();
            $('a[data-value="rewardinfo"]').removeClass('active');
            $('a[data-value="myreward"]').removeClass('active');
            $(obj).addClass('active');
            $('#lotteryinfo').show();
        }
        if(tab_id=='myreward'){
            $('#rewardinfo').hide();
            $('#lotteryinfo').hide();
            $('a[data-value="rewardinfo"]').removeClass('active');
            $('a[data-value="lotteryinfo"]').removeClass('active');
            $(obj).addClass('active');
            $('#myreward').show();
        }
    }
    $(document).ready(function () {
        if (localStorage.getItem('refreshed') == 'false') {
            localStorage.setItem('refreshed', 'true')
        }else{
            localStorage.setItem('refreshed', 'false');
            window.location.reload();
        }
        var haschanges = <?php  echo intval($has_changes);?>;

        <?php  if(!empty($has_changes)) { ?>
        $('#gua-img').eraser({
            completeRatio: 0.5,
            completeFunction: function (p) {

                if(haschanges<=0){

                    $('#model-failtitle').html('<?php  echo $lottery['lottery_cannot'];?>');
                    taskget = new FoxUIModal({
                        content: $('#failmodel').html(),
                        extraClass: 'picker-modal',
                        maskClick: function () {
                            taskget.close();
                        }
                    });
                    taskget.container.find('.task-btn-close').click(function () {
                        taskget.close();
                    });
                    taskget.show();
                    return false;
                }
                haschanges--;
                $('#left_changes').html(haschanges);
                $.post('<?php  echo mobileUrl("lottery/index/getreward");?>',{lottery:<?php  echo $lottery['lottery_id'];?>},function (data) {
                    console.log(data);
                    if(data.status==1){
                        if(data.is_reward){
                            //领取成功
                            $('#result_span').html('恭喜您中奖了');
                            $.post('<?php  echo mobileUrl("lottery/index/reward");?>',{reward:data.id,lottery:<?php  echo $lottery['lottery_id'];?>},function (res) {
                                if(res.status==1){
                                    $('#model-title').html(res.info);
                                    taskget = new FoxUIModal({
                                        content: $('#model').html(),
                                        extraClass: 'picker-modal',
                                        maskClick: function () {
                                            window.location.reload();
                                        }
                                    });
                                    taskget.container.find('.task-btn-close').click(function () {
                                        window.location.reload();
                                    });
                                    taskget.show();
                                }else{
                                    $('#model-failtitle').html(res.info);
                                    taskget = new FoxUIModal({
                                        content: $('#failmodel').html(),
                                        extraClass: 'picker-modal',
                                        maskClick: function () {
                                            window.location.reload();
                                        }
                                    });
                                    taskget.container.find('.task-btn-close').click(function () {
                                        window.location.reload();
                                    });
                                    taskget.show();
                                }
                                return;
                            },'json');
                        }else{
                            //无奖励
                            $('#result_span').html('未中奖');
                            $('#model-failtitle').html(data.info);
                            taskget = new FoxUIModal({
                                content: $('#failmodel').html(),
                                extraClass: 'picker-modal',
                                maskClick: function () {
                                    window.location.reload();
                                }
                            });
                            taskget.container.find('.task-btn-close').click(function () {
                                window.location.reload();
                            });
                            taskget.show();
                            return ;
                        }

                    }else{
                        $('#result_span').html('无法抽奖');
                        $('#model-failtitle').html('<?php  echo $lottery['lottery_cannot'];?>');
                        taskget = new FoxUIModal({
                            content: $('#failmodel').html(),
                            extraClass: 'picker-modal',
                            maskClick: function () {
                                window.location.reload();
                            }
                        });
                        taskget.container.find('.task-btn-close').click(function () {
                            window.location.reload();
                        });
                        taskget.show();
                        return false;
                    }
                },'json');
            }
        });



        <?php  } ?>

        

    });

</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

