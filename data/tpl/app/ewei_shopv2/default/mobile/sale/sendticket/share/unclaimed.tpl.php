<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="../addons/ewei_shopv2/template/mobile/default/static/sendticket/css/style.css" rel="stylesheet" />

<div class="fui-page">
    <div class="fui-content">
        <div class="share_body">
            <div class="share_main">
                <div class="share_head_img">
                    <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/bg7s.png" alt="" width="100%">
                </div>
                <div class="content_bg">
                    <div class="share_title" style="padding-top: 0.6rem">
                        <span class="share_title_text" style="font-size: 0.95rem;"><b>您有<?php  echo $num;?>张优惠券待领取</b></span>
                    </div>
                    <div class="content_list">
                        <ul>
                            <li style="width:100%;height:1rem;padding-top: 1rem">
                                <div style="width:100%;height:25%;text-align: center;line-height: 1rem;font-size: 0.8rem;color:#666">传递本页面给好友，与好友共享礼包</div>
                            </li>
                            <li style="width:100%;height:11.2rem;padding-bottom: 3rem;padding-top:1rem">
                                <div style="width:70%;height:100%;text-align: center;font-size: 0.65rem;color:#999;margin:0 auto;margin-top: 2rem;">
                                    <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/share.png" alt="" width="100%" height="100%">
                                </div>
                            </li>
                        </ul>
                        <div class="share_button">
                                <div class="button_c text-center js-clip" data-href="">
                                    立即传递
                                </div>
                        </div>
                    </div>
                </div>
                <div class="bottom" style="text-align: center;line-height: 4rem">
                    <!--<span style="font-size: 0.8rem;color:#fff">人人商城</span>-->
                </div>

            </div>

        </div>

        <div class="share_img">
            <img src="../addons/ewei_shopv2/template/mobile/default/static/sendticket/img/guide_1.png" alt="">
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


<script language='javascript'>

    //    require(['../dist/clipboard.min'], function(Clipboard){
    //        var clipboard = new Clipboard('.js-clip', {
    //            text: function(e) {
    //                return $(e).data('url')||$(e).data('href');
    //            }
    //        });
    //        clipboard.on('success', function(e) {
    //            //tip.msgbox.suc('复制成功');
    //            alert('d')
    //        });
    //    })

    $(document).ready(function(){

        $('.button_c').click(function(){

            if(/MicroMessenger/i.test(navigator.userAgent)){
                $('.share_img').css('display','block');
            }else{
                //alert($(this).attr(''));
                var activityid = <?php  echo $_GPC['sid'];?>;
                var orderid = <?php  echo $_GPC['orderid'];?>;
                var timestamp = format(Date.parse(new Date()));

                var randnum = Math.floor((Math.random()*9000)+1000);
                var ident = 'rrsc' + randnum+ timestamp ;
                var url = core.getUrl('sale/sendticket/share/shareSuccess', {}, true);
                $.ajax({
                    url:url,
                    data:{
                        'sid' : activityid,
                        'ident' : ident,
                    },
                    type:'post',
                    success:function(result){
                        var obj = JSON.parse(result);
                        if(obj.status == 'success'){
                            alert('请手动复制一下链接前去分享！');
                        }else if(obj.status == 'error'){
                            alert(obj.msg);
                        }

                    }});

            }

        });

        $('.share_img').click(function(){
            $('.share_img').css('display','none');
        });
    });
    function add0(m){return m<10?'0'+m:m }
    function format(timestamp)
    {
        //timestamp是整数，否则要parseInt转换,不会出现少个0的情况

        var time = new Date(timestamp);
        var year = time.getFullYear();
        var month = time.getMonth()+1;
        var date = time.getDate();
        var hours = time.getHours();
        var minutes = time.getMinutes();
        var seconds = time.getSeconds();
        return year+add0(month)+add0(date);
    }

    function shareticket(){
        var activityid = <?php  echo $_GPC['sid'];?>;
        var orderid = <?php  echo $_GPC['orderid'];?>;
        var ident = "<?php  echo $ident;?>";
        var skipurl = core.getUrl("sale/sendticket/share/enjoy",{sid:activityid,orderid:orderid,ident:ident},true);
        window.location.href = skipurl;

    }



</script>
