<?php defined('IN_IA') or exit('Access Denied');?><link href="../addons/ewei_shopv2/template/mobile/default/static/sendticket/css/style.css" rel="stylesheet" />
<div role="dialog" class="modal fade bs-example-modal-sm" id="layer">
    <div class="pop">
        <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/close1.png" alt="" style="width:1.3rem;height:1.3rem;position:absolute;right:0.9rem;top:0.8rem" class="close_get">
        <div class="pop1">
            <p class="icon_9">您有一份礼包待领取</p>
            <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/gifts.png"style="width: 6.5rem;height: 5.75rem;margin-top: 0.8rem">
        </div>
        <!--<a href="<?php  echo mobileUrl('sale/sendticket/share/enjoy')?>" class="external" data-nocache="true">-->
        <a href="javascript:;" class="external" data-nocache="true">
        <div class="pop2" style="margin-top: 0rem">
            立即领取
        </div>
        </a>
    </div>
</div>

<script language='javascript'>
    $(document).ready(function(){
        require(['biz/sale/sendticket/index'], function (modal) {
            modal.init({orderid:<?php  echo $_GPC['id'];?>})
        });
    });
</script>
