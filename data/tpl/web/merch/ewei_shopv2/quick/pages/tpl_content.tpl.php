<?php defined('IN_IA') or exit('Access Denied');?><link href="../addons/ewei_shopv2/plugin/quick/static/css/web.base.css?v=201609291001" rel="stylesheet" type="text/css"/>
<link href="../addons/ewei_shopv2/plugin/quick/static/css/web.css?v=20171115" rel="stylesheet" type="text/css"/>

<div class="alert alert-primary">
    <p>提示：1.点击左侧分组可编辑; 2.拖拽左侧分组可排序; 3.商品数据较多建议使用商品组/商品分类导入; 4.模板二(商城模式)不适合大量数据</p>
</div>

<input type="hidden" name="datas" id="datas" />

<div class="diy-phone">
    <div class="phone-head"></div>
    <div class="phone-body">
        <div class="phone-title" id="page-title"><?php  if(empty($page['pagetitle'])) { ?>快速购买<?php  } else { ?><?php  echo $page['pagetitle'];?><?php  } ?></div>
        <div class="phone-main" id="phone"></div>
    </div>
    <div class="phone-foot"></div>
</div>

<div class="diy-editor-group" id="editor"></div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('quick/pages/tpl_editor', TEMPLATE_INCLUDEPATH)) : (include template('quick/pages/tpl_editor', TEMPLATE_INCLUDEPATH));?>
