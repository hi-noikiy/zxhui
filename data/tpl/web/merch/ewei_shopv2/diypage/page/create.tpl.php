<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .dropdown-menu {
        /*width: 120px !important;*/
        background: none; border: none; box-shadow: none; padding: 0;
        left: 50%;
        margin-left: -60px;
    }
    .dropdown-menu li:last-child span {margin: 0}
    .dropdown-menu li {padding-top: 5px; width: 120px;}
    .dropdown-menu li span {background: #fff; width: 100%;}
    .btn-create {width: 120px;}
    center .fa-caret-up {display: none}
    center.open .fa-caret-down {display: none}
    center.open .fa-caret-up {display: inline-block}
    .ibox-content .inner {height: auto; width: 100%}
    .ibox-content .inner .ico {height: 120px; width: 120px; border-radius: 100px; color: #fff; text-align: center; line-height: 120px; margin: 25px auto 35px;}
    .ibox-content .inner .ico .icon {font-size: 70px;}
    .ibox-content .inner .text {width: 100%; height: 40px; margin: auto; padding-bottom: 0px; text-align: center;}
</style>

<div class="page-header">当前位置：<span class="text-primary">新建页面</span></div>

<?php $col=$_W['plugin']!='merch'?'col-md-3 col-sm-3':'col-md-4 col-sm-4'?>

<div class="row">
    <?php if(mcv('diypage.page.sys.add')) { ?>
        <div class="<?php  echo $col;?>">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>系统页面</h5>
                </div>
                <div class="ibox-content">
                    <div class="inner">
                        <div class="ico" style="background: #44abf7; ">
                            <i class="icon icon-shop"> </i>
                        </div>
                        <div class="text">此类型页面可替换商城系统页面</div>
                    </div>
                    <center style="position: relative; width: 100%">
                        <span class="btn btn-w-m btn-primary btn-create" data-toggle="dropdown"><i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>  立即创建</span>
                        <ul role="menu" class="dropdown-menu">
                            <li><span class="btn btn-w-m btn-block btn-outline btn-primary btn-jump" data-href="<?php  echo webUrl('diypage/page/sys/add', array('type'=>2))?>"><i class="fa fa-plus"></i> 商城首页</span></li>
                            <?php  if($_W['plugin']!='merch') { ?>
                                <li><span class="btn btn-w-m btn-block btn-outline btn-primary btn-jump" data-href="<?php  echo webUrl('diypage/page/sys/add', array('type'=>3, 'tid'=>$tid_member))?>"><i class="fa fa-plus"></i> 会员中心</span></li>
                                <li><span class="btn btn-w-m btn-block btn-outline btn-primary btn-jump" data-href="<?php  echo webUrl('diypage/page/sys/add', array('type'=>5, 'tid'=>$tid_detail))?>"><i class="fa fa-plus"></i> 商品详情页</span></li>
                            <?php  } ?>
                        </ul>
                    </center>
                </div>
            </div>
        </div>
    <?php  } ?>

    <?php  if($_W['plugin']!='merch') { ?>
        <?php if(mcv('diypage.page.plu.add')) { ?>
            <div class="col-md-3 col-sm-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>应用页面</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="inner">
                            <div class="ico" style="background: #ed5565; ">
                                <i class="icon icon-app"> </i>
                            </div>
                            <div class="text">此类型页面可替换商城应用页面</div>
                        </div>
                        <center style="position: relative; width: 100%">
                            <span class="btn btn-w-m btn-danger btn-create" data-toggle="dropdown"><i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>  立即创建</span>
                            <ul role="menu" class="dropdown-menu">
                                <?php  if(p('commission')) { ?>
                                    <li><span class="btn btn-w-m btn-block btn-outline btn-danger btn-jump" data-href="<?php  echo webUrl('diypage/page/plu/add', array('type'=>4, 'tid'=>$tid_commission))?>"><i class="fa fa-plus"></i> 分销中心</span></li>
                                <?php  } ?>
                                <?php  if(p('creditshop')) { ?>
                                    <li><span class="btn btn-w-m btn-block btn-outline btn-danger btn-jump" data-href="<?php  echo webUrl('diypage/page/plu/add', array('type'=>6, 'tid'=>$tid_creditshop))?>"><i class="fa fa-plus"></i> 积分商城</span></li>
                                <?php  } ?>
                                <?php  if(p('seckill')) { ?>
                                    <li><span class="btn btn-w-m btn-block btn-outline btn-danger btn-jump" data-href="<?php  echo webUrl('diypage/page/plu/add', array('type'=>7, 'tid'=>$tid_seckill))?>"><i class="fa fa-plus"></i> 整点秒杀</span></li>
                                <?php  } ?>
                                <?php  if(p('exchange')) { ?>
                                    <li><span class="btn btn-w-m btn-block btn-outline btn-danger btn-jump" data-href="<?php  echo webUrl('diypage/page/plu/add', array('type'=>8, 'tid'=>$tid_exchange))?>"><i class="fa fa-plus"></i> 兑换中心</span></li>
                                <?php  } ?>
                            </ul>
                        </center>
                    </div>
                </div>
            </div>
        <?php  } ?>
    <?php  } ?>

    <?php if(mcv('diypage.page.diy.add')) { ?>
        <div class="<?php  echo $col;?>">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>自定义页面</h5>
                </div>
                <div class="ibox-content">
                    <div class="inner">
                        <div class="ico" style="background: #54c952; ">
                            <i class="icon icon-paint"> </i>
                        </div>
                        <div class="text">此类型页面可通过链接或关键字进入</div>
                    </div>
                    <center>
                        <span class="btn btn-w-m btn-success btn-create btn-jump" data-href="<?php  echo webUrl('diypage/page/diy/add')?>"><i class="fa fa-plus"></i> 立即创建</span>
                    </center>
                </div>
            </div>
        </div>
    <?php  } ?>

    <?php if(mcv('diypage.temp')) { ?>
        <div class="<?php  echo $col;?>">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>通过模版创建</h5>
                </div>
                <div class="ibox-content">
                    <div class="inner">
                        <div class="ico" style="background: #ffc000 ; ">
                            <i class="icon icon-copy2"> </i>
                        </div>
                        <div class="text">可通过已有模板创建新的页面</div>
                    </div>
                    <center>
                        <span class="btn btn-w-m btn-warning btn-create btn-jump"  data-href="<?php  echo webUrl('diypage/temp')?>"><i class="fa fa-plus"></i> 立即选择模版</span>
                    </center>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>

<div class="row" style="padding: 0;">
    <div class="col-sm-12">
        <div class="summary_box" style="background: #fff">
            <div class="summary_title">
                <span class=" title_inner">页面类型介绍</span>
            </div>
            <div class="summary_lg">
                <p>系统页面：可根据自己需求、样式编辑好页面，替换系统默认模板，目前支持商城首页、商品详情页、会员中心。</p>
                <?php  if($_W['plugin']!='merch') { ?>
                <p>应用页面：可根据自己需求、样式编辑好页面，替换应用默认模板<?php  if(p('commission')||p('creditshop')||p('seckill')||p('exchange')) { ?>，目前支持<?php  if(p('commission')) { ?>分销中心<?php  } ?><?php  if(p('creditshop')) { ?>、积分商城<?php  } ?><?php  if(p('seckill')) { ?>、整点秒杀<?php  } ?><?php  if(p('exchange')) { ?>、兑换中心<?php  } ?>。<?php  } else { ?>。<?php  } ?></p>
                <?php  } ?>
                <p>自定义页面：可根据自己需求、样式编辑好页面，通过链接、关键字、或其他页面跳转进入，实现专题页面的需求。</p>
                <p>通过模板创建：可将喜欢的页面、使用率较高的页面保存成模板，根据已保存的模板一键创建页面，省时、省力、省心。</p>
            </div>
        </div>
    </div>
</div>

<?php if(mcv('diypage.shop.page')) { ?>
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-default btn-block" href="<?php  echo webUrl('diypage/shop/page')?>"><i class="fa fa-cogs"></i> 已有编辑好的页面？立即替换系统模板</a>
        </div>
    </div>
<?php  } ?>

<script type="text/javascript">
    $(function () {
        $(".btn-jump").click(function(){
            var href = $(this).data('href');
            if(!href) {
                tip.msgbox.err("暂未开放此类型！敬请期待。");
                return;
            }
            $(this).closest("center").find(".btn-create").html('<i class="fa fa-spinner fa-spin"></i> 加载中...');
            location.href = href;
        });
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>