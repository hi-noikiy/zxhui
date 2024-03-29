<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置： <span class='text-primary'>概述</span>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-sm-4">
            <div class=" flex border summary">
                <div class="flex1 flex column">社区数</div>
                <div class="flex1 flex column num text-danger boardcount">--</div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class=" flex border summary">
                <div class="flex1 flex column">话题数</div>
                <div class="flex1 flex column num  text-default postcount">--</div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class=" flex border summary">
                <div class="flex1 flex column">回复数</div>
                <div class="flex1 flex column num  text-success replycount">--</div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class=" flex border summary">
                <div class="flex1 flex column">昨日话题数</div>
                <div class="flex1 flex column num  text-primary postcount1">--</div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class=" flex border summary">
                <div class="flex1 flex column">昨日回复数</div>
                <div class="flex1 flex column num  text-warning replycount1">--</div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class=" flex border summary">
                <div class="flex1 flex column">最近7天话题数</div>
                <div class="flex1 flex column num  text-danger postcount2">--</div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class=" flex border summary">
                <div class="flex1 flex column">最近7天回复数</div>
                <div class="flex1 flex column num  text-danger replycount2">--</div>
            </div>
        </div>



    </div>

</div>

<script>

    $(function(){
        $.ajax({
            type: "GET",
            url: "<?php  echo webUrl('sns/index/data')?>",
            dataType: "json",
            success: function (data) {
                $('.boardcount').html(data.result.boardcount);
                $('.postcount').html(data.result.postcount);
                $('.replycount').html(data.result.replycount);

                $('.postcount1').html(data.result.postcount1);
                $('.replycount1').html(data.result.replycount1);

                $('.postcount2').html(data.result.postcount2);
                $('.replycount2').html(data.result.replycount2);

            }
        });
    });


</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
