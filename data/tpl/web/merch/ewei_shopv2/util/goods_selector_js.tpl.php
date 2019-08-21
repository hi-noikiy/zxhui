<?php defined('IN_IA') or exit('Access Denied');?><div class="goods-selector" id="goods_selector_goods_selector" data-switch="1">
    <!--modal-->
    <div class="modal fade ">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="$(this).parents('#goods_selector_goods_selector').remove()">
                    <span>×</span>
                </button>
                <h3 class="modal-title">数据选择器</h3>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:15px 0;">
                    <div class="input-group fenlei">

						<span class="input-group-select">
                            <!--商品分类-->
                            <select name="goodsgroup" class="select2" style="width:275px;" id="cates">
                                <option value="0">选择商品分类</option>
                            </select>
		                </span>
                        <input type="text" class="form-control search"	placeholder="请输入关键字">
                        <span class="input-group-btn">
							<button type="button" class="btn btn-default pager-nav" page="1">搜索</button>
						</span>
                    </div>
                </div>
                <!--描述文字-->
                <!--分页列表-->
                <div class="content"></div>
            </div>

            <div class="modal-footer"><a href="#" class="btn btn-default" onclick="$(this).parents('#goods_selector_goods_selector').remove()">关闭</a></div>
            <!--商品分类-->
            <!--<div class="select2-drop select2-display-none select2-with-searchbox select2-drop-active" style="left: 30px; width: 275px; top: 95px; bottom: auto; display: none;" id="select2-drop">-->
                <!--<ul class="select2-results" role="listbox" id="select2-results-2">-->
                    <!--<li class="select2-results-dept-0 select2-result select2-result-selectable select2-highlighted" role="presentation">-->
                        <!--<div class="select2-result-label" id="select2-result-label-41" role="option" data-id="0">-->
                            <!--<span class="select2-match"></span>商品分类-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="select2-results-dept-0 select2-result select2-result-selectable" role="presentation">-->
                        <!--<div class="select2-result-label" id="select2-result-label-42" role="option" data-id="12">-->
                            <!--<span class="select2-match"></span>家用电器-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
        </div>
    </div>
</div>
<style>
    .cancelit{
        background-color: red;
    }
    .page-raduis{
        border-top-right-radius: 4px;border-bottom-right-radius: 4px;
    }
    .goods-selector{
        width: 100%;
        float: left;
    }
    .goods-selector-header{
        width: 100%;height: 3rem;line-height: 3rem;border-color: #efefef;
        background: #f6f6f6;border: 1px solid #f2f2f2;float: left;
    }
    .goods-selector-content{
        margin-top: 5px;
        width: 100%;line-height: 3rem;border-color: #efefef;
        border: 1px solid #f2f2f2;float: left;
    }
    #mask{
        z-index: 2060 !important;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: none;
        overflow: hidden;
        -webkit-overflow-scrolling: touch;
        outline: 0;
        background-color: rgba(0,0,0,0.5);
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }
    .goods-selector .modal{
        z-index: 2060 !important;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: none;
        overflow: hidden;
        -webkit-overflow-scrolling: touch;
        outline: 0;
        background-color: rgba(0,0,0,0.5);
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }
    .goods-selector .modal-dialog{
        height: 704px;
        width: 920px;
        background-color: #fff;
        position: absolute;
        left: 50%;
        margin-left: -460px;
        z-index: 2061 !important;
        display: block;
    }
    .goods-selector .modal .modal-header{
        background-color: #f4f5f9;
        border-bottom: 0;
        padding: 15px 20px;
    }
    .goods-selector .modal .modal-header h3 {
        font-size: 14px;
    }
    .goods-selector .modal .modal-header .close{
        -webkit-appearance: none;
        padding: 0;
        cursor: pointer;
        background: 0 0;
        border: 0;
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
    }
    .goods-selector .modal .modal-body {
        padding: 0 30px;
        overflow-y: auto;
        overflow-x: hidden;
        height: 595px;
    }
    .goods-selector .modal .modal-body .row {
        margin-right: -10px;
        margin-left: -10px;
    }
    .goods-selector .modal .modal-body .input-group {
        position: relative;
        border-collapse: separate;
        overflow: hidden;
        margin-left: 10px;
    }
    .goods-selector .modal .modal-body .input-group .form-control::-webkit-input-placeholder {
        color:#999;
    }
    .goods-selector .modal .modal-body .input-group .form-control {
        position: relative;
        z-index: 2;
        float: left;
        width: 530px;
        margin-bottom: 0;
        background-color: #FFFFFF;
        background-image: none;
        border: 1px solid #efefef;
        border-radius: 1px;
        color: inherit;
        display: block;
        -webkit-transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        font-size: 12px;
        height: 30px;
    }
    .goods-selector .modal .modal-body .input-group .input-group-btn{
        display: inline-block;
    }
    .goods-selector .modal .modal-body .input-group .btn {
        border-radius: 1px;
        font-size: 12px;
        height: 30px;
        float: left;
        width: 58px
    }
    .goods-selector .modal .modal-body .table{
        font-size: 12px;
        color: #333;
        margin-bottom: 0;
    }
    .goods-selector .modal .modal-body .table tr td:last-child{
        padding-right: 42px;
        width: 140px;
        position: relative;
    }
    .goods-selector .modal .modal-body .table tr td:first-child{
        text-align: left;
        width: auto;
        padding-left: 8px;
        padding-right: 40px
    }
    .goods-selector .modal .modal-body .table td{
        padding: 8px 50px 8px 0;
        text-align: right;
        border-top: 0;
        width: 112px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .goods-selector .modal .modal-body .table thead{
        background: #f7f7f7
    }
    .goods-selector .modal .modal-body .table tbody tr td{
        border-bottom: 1px solid #ededed;
        height: 47px;
        vertical-align: middle;
    }
    .goods-selector .modal .modal-body .table tbody tr td:first-child{
        border-left: 1px solid #ededed;
        line-height: 30px;
    }
    .goods-selector .modal .modal-body .table tbody tr td:last-child:after{
        content: " ";
        position: absolute;
        right: 0;
        top: 0;
        width: 1px;
        height: 100%;
        border-right: 1px solid #ebebeb;
    }
    .goods-selector .modal .modal-body .pagination{
        float: right;
        margin-left:10px;
    }
    .goods-selector .modal .modal-body .record{
        display:inline-block;
        float:right;
        line-height: 28px;
        margin: 20px 0
    }
    .goods-selector .modal .modal-body .pagination>li {
        display: inline;
    }
    .pagination>li a{
        position: relative;
        float: left;
        margin-left: -1px;
        text-decoration: none;
        border: 1px solid #ddd;
    }
    .pagination>li input{

        width: 44px;
        height:28px;
        position: relative;
        float: left;
        margin-left: -1px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin-right: 5px;
        color: #000;
        line-height: 12px;
        font-size: 12px;
        padding: 7px 10px;
    }
    .pagination>li>a:focus, .pagination>li>a:hover {
        z-index: 2;
        color: #23527c;
        background-color: #eee;
        border-color: #ddd;
    }
    .goods-selector .modal .btn-default {
        background: #fdfdfd !important;
        color: #666;
        border: 1px solid #efefef !important;
        outline: none;
    }
    .goods-selector .modal .modal-footer {
        background-color: #f4f5f9;
        border-top: 0;
        text-align: center;
        padding: 15px;
    }
    .goods-selector .modal .modal-footer .btn {
        display: inline-block;
        min-width: 105px;
    }

    .goods-selector .form-control.select2-container .select2-choice {
        outline: 0;
    }
</style>

<script>
    model.init();
    $.ajax({
        url:"<?php echo $_W['plugin']=='merch'? './merchant.php?c=site&a=entry&m=ewei_shopv2&do=web&r=goods.getcate': './index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=util.goods_selector.getcate'?>",
        type:'get',
        success:function (json) {
            console.log(json)
            var htm = '<option value="0">选择商品分类</option>';
            $('.fenlei select').html(htm);
            $.each(json,function (i,v) {
                $('.fenlei select').append('<option value="'+v.id+'">'+v.name+'</option>');
            });

            myrequire(['select2'],function (select2) {
                $('#cates').select2()
            })
        }
    });
</script>