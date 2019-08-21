<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current order-detail-page'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back btn-back"></a>
        </div>
        <div class="title">订单备注</div>
        <div class="fui-header-right"></div>
    </div>
    <div class='fui-content navbar'>

        <div class="fui-title">备注信息</div>
        <div class="fui-cell-group">
            <div class="fui-cell fui-cell-textarea">
                <div class="fui-cell-info">
                    <textarea rows="8" placeholder="请输入备注信息" id="remarksaler" data-olddata="<?php  echo $item['remarksaler'];?>"><?php  echo $item['remarksaler'];?></textarea>
                </div>
            </div>
        </div>

    </div>
    <div class="fui-navbar">
        <div class="nav-item btn btn-gray cancel-params">取消</div>
        <div class="nav-item btn btn-success submit-params">保存</div>
    </div>

    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/merchmanage/static/js/order-op.js'],function(modal){
            modal.initRemark({orderid: "<?php  echo $orderid;?>"});
        });
    </script>
</div>
