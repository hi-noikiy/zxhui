<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    /*装修组件的复制*/
    .diy-toolbar{
        width: 132px;
        height: 48px;
        background: rgba(0,0,0,0.4);
        border-radius: 6px;
        position: absolute;
        left: 0;
        top: -59px;
        padding: 0 10px;

    }
    .diy-toolbar .item{
        width: 56px;
        height: 100%;
        text-align: center;
        color: #fff;
        font-size: 12px;
        float: left;
        cursor: pointer;
    }
    .diy-toolbar .item p{
        width: 100%;
    }
    .diy-toolbar .item p.icow{
        margin-top: 7px;
        margin-bottom: 6px;
    }
    .diy-toolbar .item p.txt{
        line-height: 1;
    }
</style>
<link href="../addons/ewei_shopv2/plugin/app/static/css/web.css?v=20170911" rel="stylesheet" type="text/css"/>
<link href="../addons/ewei_shopv2/plugin/app/static/css/diy.min.css?v=201609291000" rel="stylesheet" type="text/css"/>
<link href="../addons/ewei_shopv2/plugin/app/static/css/foxui.diy.css?v=201612141111" rel="stylesheet" type="text/css"/>
<link href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="../addons/ewei_shopv2/plugin/app/static/fonts/iconfont.css" rel="stylesheet" type="text/css">
<div class="page-header">
    当前位置：
    <span class="text-primary"><?php  if(empty($item)) { ?>新建<?php  } else { ?>编辑<?php  } ?>页面 <?php  if(!empty($item)) { ?><small>(名称: test)</small><?php  } ?></span>
</div>

<div class="page-content">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/_tab', TEMPLATE_INCLUDEPATH)) : (include template('app/_tab', TEMPLATE_INCLUDEPATH));?>
    <div class="row relative w840">

        <div class='alert alert-primary' id="advanced_alert">
            <p>温馨提示：小程序最多只支持10级页面跳转，超过10级无法跳转</p>
        </div>
        <?php  if(is_array($release) && !is_error($release)) { ?>
        <div class="qrcode-layer">
            <?php  if($release['audit_status']==1) { ?>
            <div class="layer">未提交</div>
            <?php  } ?>
            <img src="<?php echo $release['audit_status']==1? '../addons/ewei_shopv2/plugin/app/static/images/qrcode.png': $release['xcx_qrcode_url']?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
            <span>扫码预览</span>
        </div>
        <?php  } ?>

        <div class="diy-phone" data-merch="<?php  echo intval($_W['merchid'])?>">
            <div class="phone-head"></div>
            <div class="phone-body">
                <div class="phone-title" id="page">loading...</div>
                <div class="phone-main" id="phone">
                    <p style="text-align: center; line-height: 400px">您还没有添加任何元素</p>
                </div>
            </div>
            <div class="phone-foot"></div>
        </div>

        <div class="diy-editor form-horizontal" style="position: relative;" id="diy-editor">
            <div class="diy-toolbar">
                <div class="item copy btn-copy">
                    <p class="icow icow-fuzhilianjie1"></p>
                    <p class="txt">复制</p>
                </div>
                <div class="item delete btn-del">
                    <p class="icow icow-shanchu2"></p>
                    <p class="txt ">删除</p>
                </div>
            </div>
            <div class="editor-arrow"></div>
            <div class="inner"></div>
        </div>

        <div class="diy-menu">
            <div class="navs" id="navs"></div>
            <div class="action">
                <nav class="btn btn-default btn-sm" style="float: left; display: none" id="gotop"><i class="icon icon-top" style="font-size: 12px"></i> 返回顶部</nav>
                <nav class="btn btn-success btn-sm btn-save" data-type="isdefault" data-id="2" style="<?php  if(($_GPC['type']!=2 && $_GPC['type']!=20)||$page['type']!=2 && $page['type']!=20 || !empty($page['isdefault'])) { ?>display: none;<?php  } ?>">保存并设为默认首页</nav>
                <nav class="btn btn-success btn-sm btn-save" data-type="isdefault" data-id="3" style="<?php  if($_GPC['type']!=3 || $page['type']!=3 || !empty($page['isdefault'])) { ?>display: none;<?php  } ?>">保存并设为默认会员页</nav>
                <nav class="btn btn-success btn-sm btn-save" data-type="isdefault" data-id="4" style="<?php  if($_GPC['type']!=4 || $page['type']!=4 || !empty($page['isdefault'])) { ?>display: none;<?php  } ?>">保存并设为默认商品详情页</nav>
                <nav class="btn btn-success btn-sm btn-save" data-type="cancel_default" style="<?php  if(empty($page['isdefault']) || ($page['type'] == 2 || $page['type'] == 20 || $_GPC['type']==2 || $_GPC['type']==20)) { ?>display:none<?php  } ?>">取消默认</nav>
                <nav class="btn btn-primary btn-sm btn-save" data-type="save">保存页面</nav>
            </div>
        </div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/page/tpl/_template', TEMPLATE_INCLUDEPATH)) : (include template('app/page/tpl/_template', TEMPLATE_INCLUDEPATH));?>
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/page/tpl/_template_edit', TEMPLATE_INCLUDEPATH)) : (include template('app/page/tpl/_template_edit', TEMPLATE_INCLUDEPATH));?>
</div>

<script type="text/javascript" src="./resource/components/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="./resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>
<link rel="stylesheet" href="../addons/ewei_shopv2/static/js/dist/select2/select2.css">
<link rel="stylesheet" href="../addons/ewei_shopv2/static/js/dist/select2/select2-bootstrap.css">

<script language="javascript">
    myrequire(['../../plugin/app/static/js/diy.min','tpl','web/biz'],function(modal,tpl){
        window.tpl = tpl;
        modal.init(<?php  echo $json;?>);
    });

    function callbackGoods(data) {
        myrequire(['../../plugin/app/static/js/diy.min'],function(modal) {
            modal.callbackGoods(data);
        });
    }
    function callbackCategory (data) {
        myrequire(['../../plugin/app/static/js/diy.min'],function(modal) {
            modal.callbackCategory(data);
        });
    }
    function callbackGroup (data) {
        myrequire(['../../plugin/app/static/js/diy.min'],function(modal) {
            modal.callbackGroup(data);
        });
    }
    function callbackCoupon (data) {
        myrequire(['../../plugin/app/static/js/diy.min'],function(modal) {
            modal.callbackCoupon(data);
        });
    }
    function callbackData(data) {
        myrequire(['../../plugin/app/static/js/diy.min'],function(modal) {
            modal.callbackData(data);
        });
    }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>