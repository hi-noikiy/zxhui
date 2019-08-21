<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary"><?php  echo m('plugin')->getName('quick')?></span>
</div>
<div class="page-content">
<div class="row" style="padding: 0;">
    <div class="col-sm-12">
        <div style="border: 1px solid #e7eaec;" class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php  echo m('plugin')->getName('quick')?>介绍</h5>
            </div>
            <div class="ibox-content">
                <p></p>
                <p>功能：<?php  echo m('plugin')->getName('quick')?>是实现商品快速浏览、快速加入购物车、快速购买的功能</p>
                <p>适用：适用于O2O、本地配送、点餐、生鲜、超市等行业</p>
                <p></p>
                <p></p>
            </div>
        </div>
    </div>
</div>

<?php if(mcv('quick.pages')) { ?>
    <a href="<?php  echo webUrl('quick/pages')?>" class="btn btn-default ">查看<?php  echo m('plugin')->getName('quick')?>页面</a>
<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>