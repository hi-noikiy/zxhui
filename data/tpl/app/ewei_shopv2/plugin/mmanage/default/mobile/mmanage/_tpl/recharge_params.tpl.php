<?php defined('IN_IA') or exit('Access Denied');?><div class='fui-content params-block'>
    <div class="inner">

        <div class="param-item param-changetype">
            <div class="fui-title">变更类型</div>
            <div class="fui-cell-group fui-cell-click">
                <div class="fui-cell submit-params" data-value="0">
                    <div class="fui-cell-text">增加<span class="credit_text"><?php echo $type==1?"积分":"余额"?></span></div>
                    <div class="fui-cell-remark">选择</div>
                </div>
                <div class="fui-cell submit-params" data-value="1">
                    <div class="fui-cell-text">减少<span class="credit_text"><?php echo $type==1?"积分":"余额"?></span></div>
                    <div class="fui-cell-remark">选择</div>
                </div>
                <div class="fui-cell submit-params" data-value="2">
                    <div class="fui-cell-text">最终<span class="credit_text"><?php echo $type==1?"积分":"余额"?></span></div>
                    <div class="fui-cell-remark">选择</div>
                </div>
            </div>
        </div>

    </div>

    <div class="fui-navbar">
        <div class="nav-item btn btn-success submit-params">确定</div>
        <div class="nav-item btn btn-gray cancel-params">取消</div>
    </div>
</div>
