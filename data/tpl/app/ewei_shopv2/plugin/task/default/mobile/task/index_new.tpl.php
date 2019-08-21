<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/task.css?v=<?php  echo time();?>"/>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/iconfont.css?v=<?php  echo time();?>"/>

<title>任务中心</title>
<div class="fui-page">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">任务中心</div>
        <div class="fui-header-right">
            <!--<a href="<?php  echo mobileUrl('')?>">商城首页</a>-->
        </div>
    </div>
    <div class="fui-content navbar" style="padding-bottom: 0;">
        <div class="taskhead" style="background: url(<?php  echo tomedia($set);?>) no-repeat;">
            <img src="<?php  echo tomedia($info['avatar'])?>" alt="" />
            <div class="title"><?php  echo $info['nickname'];?></div>
        </div>
        <div class="tasktabs">
            <a href="<?php  echo mobileUrl('task.reward');?>" class="external">
                <i class="iconfont icon-jilu"></i>奖励记录
            </a>
            <a href="<?php  echo mobileUrl('task.mine');?>" class="external">
                <i class="iconfont icon-gift"></i>我的任务
            </a>
        </div>
        <?php  if(empty($list)) { ?>
        <div style="height: 7rem;line-height:7rem;width: 100%;text-align: center;color: #d0d0d0;font-size: 1rem">暂时没有任何任务</div>
        <?php  } ?>
        <div class="task-list-group">
            <?php  if(is_array($list)) { foreach($list as $li) { ?>
            <!--解析奖励-->
            <?php  $li['reward'] = json_decode($li['reward'],true)?>
            <div class="task-list">
                <a href="<?php  echo mobileUrl('task.detail',array('id'=>$li['id'],'rid'=>$li['rid']))?>" class="task-list-media">
                    <img src="<?php  echo $li['image'];?>" alt="" />
                </a>
                <a href="<?php  echo mobileUrl('task.detail',array('id'=>$li['id'],'rid'=>$li['rid']))?>" class="task-list-inner">
                    <div class="title"><?php  echo $li['title'];?></div>
                    <!--显示奖励小图标-->
                    <div class="task-icon-group">
                        <?php  if(!empty($li['reward']['credit'])) { ?><i class="iconfont icon-jifen"></i><?php  } ?>
                        <?php  if(!empty($li['reward']['balance'])) { ?><i class="iconfont icon-yue"></i><?php  } ?>
                        <?php  if(!empty($li['reward']['redpacket'])) { ?><i class="iconfont icon-hongbao"></i><?php  } ?>
                        <?php  if(!empty($li['reward']['goods'])) { ?><i class="iconfont icon-shangpin"></i><?php  } ?>
                        <?php  if(!empty($li['reward']['coupon'])) { ?><i class="iconfont icon-youhuiquan"></i><?php  } ?>
                        <?php  if(!empty($li['info']['getmesg'])) { ?>
                        <br>
                            <span>奖励商品库存不足</span>
                        <?php  } ?>
                        <?php  if(!empty($li['getinfo']['getmesg'])) { ?>
                        <br>
                            <span>购买商品库存不足</span>
                        <?php  } ?>
                    </div>
                </a>
                <div class="task-list-right">
                    <?php  if(empty($li['task_demand'])) { ?>
                        <?php  if($li['info']['enough'] && $li['getinfo']['enough']) { ?>
                            <a class="pickit" data-id="<?php  echo $li['id'];?>">做任务</a>
                        <?php  } else { ?>
                            <a class="message" data-id="<?php  echo $li['id'];?>">无法领取</a>
                        <?php  } ?>
                    <?php  } ?>
                    <?php  if(!empty($li['task_demand']) && $li['task_demand'] > $li['task_progress']) { ?>
                        <div class="progress">
                            <div class="progress-inner" style="width: <?php  echo $li['task_progress']/$li['task_demand']*100?>%"></div>
                        </div>
                        <div class="times">
                            <?php  echo $li['task_progress'];?>/<?php  echo $li['task_demand'];?>
                        </div>
                    <?php  } ?>
                    <?php  if(!empty($li['task_demand']) && $li['task_demand'] == $li['task_progress']) { ?>
                        已完成
                    <?php  } ?>
                </div>
                <div class="task-list-mask"></div>
            </div>
            <?php  } } ?>
        </div>
    </div>
</div>

<script>
    require(['../addons/ewei_shopv2/plugin/task/static/js/index.js'],function (model) {
        model.init();
    });
</script>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>