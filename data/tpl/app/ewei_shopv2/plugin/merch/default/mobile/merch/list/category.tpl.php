<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merch/common', TEMPLATE_INCLUDEPATH)) : (include template('merch/common', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/qa/static/css/common.css?v=2016063000">
<div class="fui-page page-merch-list">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" href="<?php  echo mobileUrl('merch/list')?>"></a>
        </div>
        <div class="title">全部分类</div>
        <div class="fui-header-right"></div>
    </div>
    <div class="fui-content" style="bottom: 2.4rem">
        <form action="<?php  echo mobileUrl('merch/list/category')?>" method="post">
            <div class="fui-searchbar bar">
                <div class="searchbar center">
                    <input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
                    <div class="search-input">
                        <i class="icon icon-search"></i>
                        <input type="search" placeholder="输入关键字..." class="search" name="keyword">
                    </div>
                </div>
            </div>
        </form>

        <?php  if(count($category)>0) { ?>
        <div class="fui-cell-group qa-title">
            <div class="fui-cell">
                <div class="fui-cell-text">全部分类</div>
            </div>
        </div>
        <div class="fui-icon-group col-4 noborder">
            <?php  if(is_array($category)) { foreach($category as $item) { ?>
            <a class="fui-icon-col external" href="<?php  echo mobileUrl('merch/list/merchuser', array('cate'=>$item['id']))?>">
                <div class="icon">
                    <img src="<?php  echo tomedia($item['thumb'])?>"/>
                </div>
                <div class="text"><?php  echo $item['catename'];?></div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>
    </div>
    <?php  $this->footerMenus()?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

