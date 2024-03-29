<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">说明&通知设置</span></div>
<div class="page-content">
    <ul class="nav nav-arrow-next nav-tabs" id="settingTab">
        <li class="active"><a href="#tab_info">说明设置</a></li>
        <li ><a href="#tab_notice">通知设置</a></li>
    </ul>
    <form class="form-horizontal form-validate"  role="form" method="post" >
        <div class="tab-content">
            <div class="tab-pane active" id="tab_info"  >
                <div class="alert alert-primary">入口描述则是用户对应的抽奖列表</div>

                <div class="form-group">
                    <label class="col-lg control-label must">活动说明</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('lottery.setting.edit|lottery.setting.add')) { ?>
                        <?php  if(!empty($set['lotteryinfo'])) { ?>
                        <?php  echo tpl_ueditor('lotteryinfo',unserialize($set['lotteryinfo']),array('height'=>'300'))?>
                        <?php  } else { ?>
                        <?php  echo tpl_ueditor('lotteryinfo','暂无说明',array('height'=>'300'))?>
                        <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_notice"  >
                <div class="alert alert-primary">当用户获取到新的抽奖机会时回复,此通知链接将指向对应的抽奖活动</div>
                <div class="">
                    <table class="table table-responsive">
                        <thead>
                        <th>买家通知 - 抽奖通知</th>
                        <th class="w200">模板消息</th>
                        <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>获得抽奖机会通知</td>
                            <td>
                                <select class="select2 is_advanced" name="data[lottery_get_template]">
                                    <option value=''>[默认]获得抽奖通知</option>
                                    <?php  if(is_array($template_group['lottery'])) { foreach($template_group['lottery'] as $template_val) { ?>
                                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['lottery_get_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                                    <?php  } } ?>
                                </select>
                            </td>
                            <td style="text-align: right;" class="is_advanced">
                                <label class="notice-default">
                                    <input type="hidden" name="data[lottery_get_close_advanced]" value="<?php  echo intval($data['lottery_get_close_advanced'])?>" />
                                    <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="lottery_get"  type="checkbox" value="<?php  echo intval($data['lottery_get_close_advanced'])?>" <?php  if(empty($data['lottery_get_close_advanced'])) { ?>checked<?php  } ?>/>
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
        </div>


        <?php if(cv('lottery.setting.edit|lottery.setting.add')) { ?>
        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-10 col-xs-12">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>
        </div>
        <?php  } ?>
    </form>
</div>

<script type="text/javascript">
    require(['bootstrap'],function(){
        $('#settingTab a').click(function (e) {
            e.preventDefault();
            $('#tab').val( $(this).attr('href'));
            $(this).tab('show');
        })
    });
</script>


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


        //开启通知
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

            //判断是否开启模板通知
            if(tag != '' && val==1&&type=='tpl-advanced') {
                $(this).data('stop', 1);
                $(this).parent().hide().next().show();

                var data = {
                    'tag': tag,
                    checked:val
                };
                //申请微信模板,并将模板ID更新至数据库.
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

    })
</script>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
