<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .tplcolor{
        color: #44abf7;
        cursor: pointer;
    }
    .tplcolor:hover{
        color: #2e6da4;
    }
    textarea, textarea:focus{
        text-indent:0
    }
</style>
<div class="page-header">
    <span class="tplcolor">消息通知</span>
</div>
<div class="page-content">
    <form id="setform" action="" method="post" class="form-horizontal form-validate" novalidate="novalidate">
        <div class="form-group">
            <label class="col-sm-2 control-label">消息通知</label>
            <div class="col-sm-9">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <td colspan="3" style="border-top: none">
                            <a href="<?php  echo webUrl('sysset.tmessage');?>" target="_blank" class="btn-sm btn-primary">
                                去自定义消息库编辑模板
                            </a>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>任务接取通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_pick_template]">
                                <option value=''>[默认]默认任务接取通知</option>
                                <?php  if(is_array($template_group['task_pick'])) { foreach($template_group['task_pick'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_pick_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_pick_close_advanced]" value="<?php  echo intval($data['task_pick_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_pick"  type="checkbox" value="<?php  echo intval($data['task_pick_close_advanced'])?>" <?php  if(empty($data['task_pick_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务进度通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_progress_template]">
                                <option value=''>[默认]默认任务进度通知</option>
                                <?php  if(is_array($template_group['task_progress'])) { foreach($template_group['task_progress'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_progress_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_progress_close_advanced]" value="<?php  echo intval($data['task_progress_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_progress"  type="checkbox" value="<?php  echo intval($data['task_progress_close_advanced'])?>" <?php  if(empty($data['task_progress_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务完成通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_finish_template]">
                                <option value=''>[默认]默认任务完成通知</option>
                                <?php  if(is_array($template_group['task_finish'])) { foreach($template_group['task_finish'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_finish_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_finish_close_advanced]" value="<?php  echo intval($data['task_finish_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_finish"  type="checkbox" value="<?php  echo intval($data['task_finish_close_advanced'])?>" <?php  if(empty($data['task_finish_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务海报接取通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_poster_pick_template]">
                                <option value=''>[默认]默认任务海报接取通知</option>
                                <?php  if(is_array($template_group['task_poster_pick'])) { foreach($template_group['task_poster_pick'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_poster_pick_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_poster_pick_close_advanced]" value="<?php  echo intval($data['task_poster_pick_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_poster_pick"  type="checkbox" value="<?php  echo intval($data['task_poster_pick_close_advanced'])?>" <?php  if(empty($data['task_poster_pick_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务海报进度通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_poster_progress_template]">
                                <option value=''>[默认]默认任务海报进度通知</option>
                                <?php  if(is_array($template_group['task_poster_progress'])) { foreach($template_group['task_poster_progress'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_poster_progress_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_poster_progress_close_advanced]" value="<?php  echo intval($data['task_poster_progress_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_poster_progress"  type="checkbox" value="<?php  echo intval($data['task_poster_progress_close_advanced'])?>" <?php  if(empty($data['task_poster_progress_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务海报完成通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_poster_finish_template]">
                                <option value=''>[默认]默认任务海报完成通知</option>
                                <?php  if(is_array($template_group['task_poster_finish'])) { foreach($template_group['task_poster_finish'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_poster_finish_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_poster_finish_close_advanced]" value="<?php  echo intval($data['task_poster_finish_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_poster_finish"  type="checkbox" value="<?php  echo intval($data['task_poster_finish_close_advanced'])?>" <?php  if(empty($data['task_poster_finish_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>任务海报扫描通知</td>
                        <td>
                            <select class="select2 is_advanced" name="data[task_poster_scan_template]">
                                <option value=''>[默认]默认任务海报扫描通知</option>
                                <?php  if(is_array($template_group['task_poster_scan'])) { foreach($template_group['task_poster_scan'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['task_poster_scan_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                <?php  } } ?>
                            </select>
                        </td>
                        <td style="text-align: right;" class="is_advanced">
                            <label class="notice-default">
                                <input type="hidden" name="data[task_poster_scan_close_advanced]" value="<?php  echo intval($data['task_poster_scan_close_advanced'])?>" />
                                <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="task_poster_scan"  type="checkbox" value="<?php  echo intval($data['task_poster_scan_close_advanced'])?>" <?php  if(empty($data['task_poster_scan_close_advanced'])) { ?>checked<?php  } ?>/>
                            </label>
                            <label style="display: none;">
                                <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">顶部通知</label>
            <div class="col-sm-9 col-xs-12">
                <label class="radio-inline">
                    <input type="radio" name="top_notice" value="1" <?php  if($top_notice == 1) { ?>checked<?php  } ?>>开启
                </label>
                <label class="radio-inline">
                    <input type="radio" name="top_notice" value="0" <?php  if($top_notice == 0) { ?>checked<?php  } ?>>关闭
                </label>
                <span class="help-block ">完成任务后在将会在商城页面顶部显示通知条</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function () {
        var sms =  <?php  if(!empty($opensms)) { ?>true<?php  } else { ?>false<?php  } ?>;
        $(".is_advanced").show();
        $(".w60").css('width', '70px');
        if (sms){
            $(".w200").css('width', '250px');
        }else{
            $(".w200").css('width', '550px');
            $(".colstd").attr('colspan',2);
        }

        $(".js-switch").not(".checkhi").click(function () {
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val("0");
            }else{
                $(this).val("0").prev().val("1");
            }
        });
        $(".checkhi").click(function () {
            var trueval = $(this).prev().data('true');
            var falseval = $(this).prev().data('false');
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val(trueval);
            }else{
                $(this).val("0").prev().val(falseval);
            }
        });
        $(".checkall").click(function () {
            var type = $(this).data('type');
            var val = $(this).val();
            if(val==0){
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").attr("checked","false").val("1").next().removeClass("checked").prev().prev().val("1");
            }else{
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").attr("checked","true").val("0").next().addClass("checked").prev().prev().val("0");
            }
        });
        $(".checkone").click(function () {
            var _this =$(this);
            var type = _this.data('type');
            var val = _this.val();
            var tag = _this.data('tag');
            var stop = _this.data('stop');
            if(stop==1)
            {
                return;
            }
            if(tag != '' && val==1) {
                $(this).data('stop', 1);
                $(this).parent().hide().next().show();
                var data = {
                    'tag': tag,
                    checked:val
                };
                $.ajax({
                    url: "<?php  echo webUrl('sysset/settemplateid')?>",
                    type:'get',
                    dataType:'json',
                    timeout : 3000, //超时时间设置，单位毫秒
                    data:data,
                    success:function(ret){
                        var _this = $(".checkone[data-tag='"+ret.result.tag+"']");
                        if (ret.result.status == '0') {
                            this.value=0;
                            _this.prev().val(1);
                            _this.next().removeClass('checked');
                            console.log(ret.result.messages);
                            alert(ret.result.messages);
                        }
                        $(_this).data('stop', 0);
                        $(_this).parent().show().next().hide();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $(".table").each(function () {
                            var _this = $(this);
                            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                                $(this).data('stop', 0);
                                $(this).parent().show().next().hide();
                            });
                        });
                    }
                });
            }

            var type = $(this).data('type');
            var val = $(this).val();
            if(val==0){
                $(this).attr("checked","false").val("1").next().removeClass("checked");
                $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("1").attr("checked","false").next().removeClass("checked");
            }else{
                $(this).attr("checked","true").val("0").next().addClass("checked");
                var all = true;
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").each(function () {
                    var val = $(this).val();
                    if(val!='on' && val==1){
                        all = false;
                        return;
                    }
                });
                if(all){
                    $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("0").attr("checked","true").next().addClass("checked");
                }
            }
        });
        $(".table").each(function () {
            var _this = $(this);
            var all_tpl_normal = true;
            var all_tpl_advanced = true;
            var all_sms = true;
            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_tpl_advanced = false;
                    return;
                }
            });
            _this.find(".checkone[data-type='sms']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_sms = false;
                    return;
                }
            });
            if(all_tpl_normal){
                _this.find(".checkall[data-type='tpl-normal']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_tpl_advanced){
                _this.find(".checkall[data-type='tpl-advanced']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_sms){
                _this.find(".checkall[data-type='sms']").val("0").attr("checked","true").next().addClass("checked");
            }
        });
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>