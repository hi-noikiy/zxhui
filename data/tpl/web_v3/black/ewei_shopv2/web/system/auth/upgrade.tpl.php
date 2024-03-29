<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">系统更新</span>
</div>
<div class="page-content">
<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >

    <div class="form-group">
        <label class="col-sm-2 control-label">当前版本</label>
        <div class="col-sm-9 col-xs-12">
            <div class="input-group">
                <div class="input-group-addon" style="background:#f2f2f2"><?php  echo $version;?></div>
                <input type='text' class='form-control'  value="RELEASE <?php  echo $release;?>" readonly style="background:#fff;"/>
                <div class="input-group-btn">

                </div>
            </div>
        </div>
    </div>


    <div class="form-group" >
        <label class="col-sm-2 control-label">最新版本</label>
        <div class="col-sm-9 col-xs-12">
            <div class="form-control-static"  id="check">等待检测...</div>
        </div>
    </div>
    <div class="form-group" id="upgrade" style="display:none">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <div class='form-control-static'>
                <input type="button" id="upgradebtn" value="立即更新" class="btn btn-primary" />
            </div>
        </div>
    </div>
</form>
</div>
<script language='javascript'>
    function process(action) {
        $.ajax({
            url: "<?php  echo webUrl('system/auth/upgrade/process')?>",
            data: {action: action},
            type: 'post',
            dataType: 'json',
            success: function (ret) {
                var status = ret.status;
                var result = ret.result;
                var act = result.action;

                if (act == 'database') {

                    if (status == 1) {
                        $('#upgradebtn').val("已更新 " + result.success + " 条数据库结构变动 / 共 " + result.total + " 条");
                        process('database');
                    } else {
                        $('#upgradebtn').val("已成功更新 " + result.total + " 条数据库结构变动");

                        process('file');
                    }


                } else if (act == 'file') {

                    if (status == 1) {
                        $('#upgradebtn').val("已更新 " + result.success + " 个文件 / 共 " + result.total + " 个文件");
                        process('file');
                    } else {
                        $('#upgradebtn').val("已成功更新 " + result.total + " 个文件");

                        process('upgrade');
                    }

                } else if (act== 'upgrade') {


                    if (status == 1) {

                        $('#upgradebtn').val("已更新 " + result.success + " 个补丁 / 共 " + result.total + " 个补丁");
                        process('upgrade');
                    } else {

                        $('#upgradebtn').val('更新成功').removeAttr('updating');
                        tip.alert('更新成功!', function () {
                            location.reload();
                        });
                    }
                }
            }
        });
    }


    $(function () {


        $.ajax({
            url: "<?php  echo webUrl('system/auth/upgrade/check')?>",
            type: 'post',
            dataType: 'json',
            success: function (ret) {

                var result = ret.result;

                if (ret.status == 1) {

                    var html = "";

                    if (result.filecount <= 0 && !result.database && !result.upgrades) {

                        html += "恭喜您，您现在是最新版本！"

                    } else {

                        html += "最新版本: <span style='color:red'>" + result.version + "</span> RELEASE " + result.release +"<br/>";

                        if (result.filecount > 0) {
                            html += "共检测到有 <span style='color:red'>" + result.filecount + "</span> 个文件需要更新.<br/>";
                        }
                        if (result.database || result.upgrades) {
                            html += "此次有数据变动.<br/>";
                        }
                        if(result.templatefiles!=''){
                            html += "<br/><b>模板更新</b><br/>";
                            html += "<div style='height:150px;width:700px;overflow:auto;border:1px solid #f2f2f2;padding:5px;margin-top:10px;'>" + result.templatefiles + "</div><br/>";
                        }

                        if (result.log != '') {
                            html += "<br/><b>更新日志:</b><br/>";
                            html += '<div class="ibox-content no-padding" style="width:700px;overflow:auto;"><div class="panel-body" style="padding: 15px 0px;"><div class="panel-group" id="version">' + result.log + "</div></div></div><br/>";
                        }



                        html += "<br/><b style='color:red'></b><br/><br/>";
                    }

                    html += "<div id='process'></div>";
                    $("#check").html(html);
                    if (result.filecount > 0 || result.database || result.upgrades) {
                        $('#upgrade').show();
                        $("#upgradebtn").unbind('click').click(function () {
                            if ($(this).attr('updating') == '1') {
                                return;
                            }
                            tip.confirm('确认已备份，并进行更新吗?', function () {
                                $(this).attr('updating', 1).val('正在更新中...');
                                if( result.database){
                                    process('database');
                                } else if(result.filecount>0){
                                    process('file');
                                }else if(result.upgrades){
                                    process('upgrade');
                                }

                            });
                        });
                    }

                } else {

                    $("#check").html(result.message);
                }
            }
        })


    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>