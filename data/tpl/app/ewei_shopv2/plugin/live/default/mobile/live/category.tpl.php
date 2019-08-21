<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .shop-index-page .menu {height: auto; background: #fff;}
    .shop-index-page .menu .item {height: auto; width: 1%; padding: 0.5rem 0; margin: 0; font-size: 0.65rem; color: #636363; text-align: center; display: table-cell;position: relative;}
    .shop-index-page .menu .item:after  {font-size: 0.65rem;position: absolute;content: '';left:0;top:0.5rem;bottom:0.5rem;border-left:1px solid #d9d9d9;}
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/live/static/css/common.css?v=<?php  echo time()?>">

<div class="fui-page shop-index-page">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">
            全部分类
        </div>
        <div class="fui-header-right"></div>
    </div>
    <div class="fui-content">
        <div class="fui-list live-category-list" style="padding:0.5rem 0;">
            <div class="fui-list-inner" style="height: auto;">
                <div class="live-category-list-inner row" style="display: block;overflow-x: inherit;overflow-y: inherit;height: auto;">
                    <?php  if(is_array($categorys)) { foreach($categorys as $row) { ?>
                    <a href="<?php  echo mobileUrl('live/list',array('cate'=>$row['id']))?>" class="col-30" data-nocache="true" style="margin-bottom:0.4rem;">
                        <p><img src="<?php  echo tomedia($row['thumb'])?>" alt="<?php  echo $row['name'];?>"></p>
                        <span><?php  echo $row['name'];?></span>
                    </a>
                    <?php  } } ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('live/_menu', TEMPLATE_INCLUDEPATH)) : (include template('live/_menu', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
