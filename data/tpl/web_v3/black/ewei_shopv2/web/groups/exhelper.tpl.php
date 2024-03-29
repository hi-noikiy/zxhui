<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">拼团快递助手</span></div>
<div class="page-content">
<div class="tabs-container">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('groups/exhelper/tabs', TEMPLATE_INCLUDEPATH)) : (include template('groups/exhelper/tabs', TEMPLATE_INCLUDEPATH));?>
    <div class="tab-content ">
        <div class="tab-pane active" id="tab_printset">
            <form id="setform" action="" method="post" class="form-horizontal form-validate">
                <input type="hidden" id="tab" name="tab" value="<?php  echo $tab;?>" />
                <div class="row" style="padding: 0;">
                    <div class="col-sm-12">
                        <div class="summary_box float-e-margins">
                            <div class="summary_title">
                                <span class="title_inner">快递助手使用说明</span>
                            </div>
                            <div class="summary_lg">
                                <p>快递助手是集合于快递单打印、发货单打印、一键发货于一体的插件，可根据需求自定义打印元素、样式、字体。 </p>
                                <p>使用步骤 1. 在电脑上安装打印控件 -> 开启控件 -> 设置端口(这里的端口是IP端口并不是主机端口);</p>
                                <p style="text-indent: 4.3em;"> 2. 在 快递助手 -> <a href="<?php  echo webUrl('groups/exhelper')?>">打印机设置</a> 中将"IP端口"设置为与控件一致的端口;</p>
                                <p style="text-indent: 4.3em;"> 3. 进入 <a href="<?php  echo webUrl('groups/exhelper/express',array('tab'=>'express'))?>">快递单模板</a>或者<a href="<?php  echo webUrl('groups/exhelper/invoice',array('tab'=>'invoice'))?>">发货单模板</a>并根据所需创建相应模板;</p>
                                <p style="text-indent: 4.3em;"> 4. 进入 <a href="<?php  echo webUrl('groups/exhelper/sender',array('tab'=>'sender'))?>">发货人信息</a>并根据所需创建相应发货人信息模板;</p>
                                <p style="text-indent: 4.3em;"> 5. 进入 <a href="<?php  echo webUrl('groups/exhelper/short',array('tab'=>'short'))?>">商品简称设置</a>可将商品简称根据打印需要进行编辑(非必选);</p>
                                <p style="text-indent: 4.3em;"> 6. 进入 单个打印或者批量打印，根据需求查询出想要打印的订单并且进行打印快递单、发货单、一键发货;</p>
                                <p>提示: 单个打印系统自动合单，同一收货地址仅出一张单; 批量打印可打印自提订单的发货单; 在打印页面也可以进行快速修改商品简称、收件人信息;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-primary">注意: 1. 请将打印机连接至本机。2. 在本机上安装打印控件。3. 将打印控件中的打印端口下面的打印端口设为相同。</div>
                <div class="form-group">
                    <label class="col-lg control-label must">IP端口</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('exhelper.printset.edit')) { ?>
                        <input type='number' class='form-control' name='port' value="<?php  echo $sys['port'];?>" data-rule-required='true' />
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $sys['port'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <?php if(cv('exhelper.printset.edit')) { ?>
                <div class="form-group">
                    <label class="col-lg control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="submit"  value="提交" class="btn btn-primary" />
                    </div>
                </div>
                <?php  } ?>
            </form>
        </div>
    </div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
