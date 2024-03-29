<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">

    .page-content.step-two .inner{
        width: 574px;
        margin: 0 auto;
    }

    .page-content.step-two.step-two-b{
        display: none;
        text-align: center;
        padding-top: 70px;
        color: #000;
    }

    .step-two-b .progressbar{
        width: 350px;
        position: relative;
        border-top: 1px solid #f0f0f0;
        display: inline-block;
        margin-top: 50px;
    }
    .step-two-b .progressbar .line{
        width: 0%;
        height: 7px;
        background: #ffc730;
        border-radius: 4px;
        position: relative;
        left: 0;
        top: -4px;
        z-index: 9;
        transition: width 1s linear;
        max-width: 100%;
    }

</style>

<div class="page-header">
    当前位置：
    <span class="text-primary">初始化团队分红</span>
</div>
<div class="page-content step">
    <div class="alert alert-primary">
        <p><b>初始化说明</b></p>
        <p>为确保您的关系树显示完整，请先点击初始化。</p>
    </div>
</div>

<!--第二步 01-->
<div class="page-content step-two step-two-a" style="margin-top: 20px;">
    <div class="inner">
        <div class="button" style="padding: 36px 0 36px 200px;">
            <input type="submit" id="initBtn" data-pagecount="<?php  echo $page_count;?>" value="立即初始化" class="btn btn-primary init"/>
        </div>
    </div>
</div>

<!--第二步 02-->
<div class="page-content step-two step-two-b" style="margin-top: 20px;">
    <div class="inner">
        <img src="../addons/ewei_shopv2/plugin/app/static/images/upload.png"  id="showimgurl" style="width: 100px;height: 100px;"></br>
        <div class="progressbar"><div class="line" data-width="1"></div></div>
        <div style="margin: 40px 0 120px">正在初始化，请等待...</div>
    </div>
</div>



<script type="text/javascript">
    // 第二步 上传

    window.onload = function () {
        var redisStatus = "<?php  echo $redisStatus?>"
        if(redisStatus === "N") {
            document.getElementById('initBtn').disabled = true
            tip.msgbox.err("当前插件需要开启redis,请检查redis设置!")
        }
    }

    $(".init").click(function () {



        $('.step-two-b').css('display','block');
        $('.step-two-a').css('display','none');
        var pagecount=$(this).data("pagecount");

        // 先发送一个请求
        // 当前是否允许继续请求
        var pageIndex = 1;
        // 先发送一条请求
        ajaxRequest(1)
        // 轮询一直查看后台数据的处理状态, 202处理中 200-OK
        var initPolling = setInterval(function () {
            $.ajax({
                url: "<?php  echo webUrl('dividend/getHandleStatus')?>",
                type: 'post',
                data: {page: pageIndex},
                dataType: 'json',
                success:function(data){
                    var status = parseInt(data.status)
                    switch ( status ) {
                        case 200:
                            if(pagecount == data.result.pindex) {
                                clearInterval(initPolling)
                                progress(parseInt(100/pagecount* pageIndex))
                                setTimeout(function () {
                                    tip.msgbox.suc("初始化成功！");
                                    $('.step-two-b').css('display','none');
                                    location.reload();
                                },3000);
                            }
                            progress(parseInt(100/pagecount* pageIndex))
                            ++pageIndex
                            ajaxRequest(pageIndex)
                            break;
                        case 202:
                            // 延时等待,不作处理
                            break;
                        case -1:
                            // 初始化错误的情况
                            clearInterval(initPolling);
                            tip.msgbox.suc(data.result.message,"<?php  echo webUrl('dividend/init')?>");
                            break;
                        case 0:
                            // 常规错误
                            clearInterval(initPolling);
                            tip.msgbox.err(data.result.message,"<?php  echo webUrl('dividend/init')?>");
                            break;
                    }
                }
            })
        }, 1000)

    });



    //控制进度条
    function progress(num) {
        var width=$(".step-two-b .progressbar .line").data("width");
        var settime=setInterval(function () {
            width++;
            $('.step-two-b .progressbar .line').css('width',width+'%');
            if(width==num){
                $(".step-two-b .progressbar .line").data("width",width);
                clearInterval(settime);
            }
        },10);
    }

    // 只发送请求,不处理请求
    function ajaxRequest(pageIndex)
    {
        $.ajax({
            url: "<?php  echo webUrl('dividend/init')?>",
            type: 'post',
            data: {page: pageIndex},
            dataType: 'json',
            timeout: 5000,
        })
    }


</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>