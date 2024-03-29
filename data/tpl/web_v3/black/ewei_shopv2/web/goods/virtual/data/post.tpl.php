<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(empty($_GPC['id'])) { ?>添加数据<?php  } else { ?>编辑数据<?php  } ?></span>
</div>
<div class="page-content">

    <div class="alert alert-primary"><?php  if(empty($_GPC['id'])) { ?>您正在向模板:“<?php  echo $item['title'];?> (id:<?php  echo $item['id'];?>)” 添加数据<?php  } else { ?>您正在编辑模板id:<?php  echo $_GPC['typeid'];?>数据id:<?php  echo $_GPC['id'];?>的内容<?php  } ?><br>Tips:主键自动填充只适用于以下格式：00000001(纯数字)、C00000001(字母开头数字结尾)、C000SDD00001(字母数字混合，以数字结尾)，末尾连续数字不能超过16位，其他格式请手动填写或者Excel导入。</div>


    <form id="dataform" action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data">
        <input type="hidden" name="typeid" value="<?php  echo $item['id'];?>"/>
        <div class='form-group'>

            <div class="col-sm-12" >
                <table class="table">
                    <thead>
                    <tr>
                        <?php  if(is_array($item['fields'])) { foreach($item['fields'] as $key => $name) { ?>
                        <th><?php  echo $name;?> (<?php  echo $key;?>) <?php  if($key=='key') { ?>主键 <?php  if(empty($_GPC['id'])) { ?><?php  } ?><?php  } ?></th>
                        <?php  } } ?>
                        <th style="width: 50px;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="type-items">
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/virtual/data/tpl', TEMPLATE_INCLUDEPATH)) : (include template('goods/virtual/data/tpl', TEMPLATE_INCLUDEPATH));?>
                    </tbody>
                </table>

            </div></div>
        <?php  if(empty($_GPC['id'])) { ?>
        <div class='form-group'>

            <div class="col-sm-7">

                <div class="input-group ">
                    <span class="input-group-addon">增加</span>
                    <input type="text" name="numlist" value="1" class="form-control" style="padding:0px; text-align: center;">
                    <span class="input-group-addon">条数据</span>
                    <div class='input-group-btn'>
                        <span class="btn btn-default btn-add-type2" onclick="addType();"><i class="fa fa-plus"></i> 确认增加</span>

                        <?php if(cv('goods.virtual.data.import')) { ?>
                        <a class="btn btn-primary" href="javascript:;" style="margin-right: 10px;" onclick="$('#modal-import').modal()"><i class="fa fa-plus" title=""></i> Excel导入</a>
                        <a class="btn btn-primary" href="<?php  echo webUrl('goods/virtual/data/temp',array('id'=>$item['id']))?>" style="margin-right: 10px;" ><i class="fa fa-download" title=""></i> 下载Excel模板文件</a>
                        <?php  } ?>

                    </div>
                </div>


            </div>
        </div>
        <?php  } ?>

        <div class='form-group'>
            <div class="col-sm-12">
                <?php if(cv('goods.virtual.data.add|virtual.data.edit')) { ?>
                <input type="submit"  value="保存数据" class="btn btn-primary"  />
                <?php  } ?>
                <?php if(cv('goods.virtual.data.view')) { ?>
                <a class="btn btn-default " href="<?php  echo webUrl('goods/virtual/data',array('typeid'=>$item['id']))?>" style="margin-left: 10px;"><i class="fa fa-list" title=""></i> 查看已有数据</a>
                <?php  } ?>
                <a class='btn btn-default' href="<?php  echo webUrl('goods/virtual/temp')?>">返回列表</a>
            </div>
        </div>
    </form>

    <div id="modal-import" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="width:600px;margin:0px auto;">
        <form id="importform" class="form-horizontal form" action="<?php  echo webUrl('goods/virtual/data/import')?>" method="post" enctype="multipart/form-data">
            <input type='hidden' name='typeid' value="<?php  echo $item['id'];?>" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h3>上传数据</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label must">EXCEL</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="file" name="excelfile" class="form-control" />
                                <span class="help-block">如果遇到数据重复则将进行数据更新（在数据未使用的情况下）</span>
                            </div>
                        </div>
                        <div id="module-menus"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="cancelsend" value="yes">确认导入</button>
                        <a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script language='javascript'>
    $(function(){

        $('#importform').submit(function(){
            if(!$(":input[name=excelfile]").val()){
                tip.msgbox.err("您还未选择Excel文件哦~");
                return false;
            }
        })

        $('#dataform').submit(function(){
            var check = true;
            $("#dataform input[type=text]").each(function(){
                var val = $(this).val();
                if(!val){
                    tip.msgbox.err("不能为空!");
                    $(this).focus();
                    check =false;
                    return false;
                }
            });
            if(!check){
                $('#dataform').attr('stop', 1);
                return false;
            }else{
                $('#dataform').removeAttr('stop', 0);
            }
            var o={}; // 判断重复
            $("#dataform input[mk=1]").each(function(){
                if(!(o[$(this).val()])){
                    o[$(this).val()] = true;
                }else{
                    var val = $(this).val();
                    $("input[mk=1]").each(function(){
                        if($(this).val()==val){
                            $(this).css("border-color","#f01");
                        }else{
                            $(this).css("border-color","#ccc");
                        }
                    });
                    alert("数据不能重复哦~！");
                    check =false;
                    return false;
                }
            });
            if(!check){
                $('#dataform').attr('stop', 1);
                return false;
            }else{
                $('#dataform').removeAttr('stop', 0);
            }
            return check;
        });
        $(document).on('mousemove', '.autotc', function () {
            $(this).children(1).next().css('display','table-cell');
        });
        $(document).on('mouseout', '.autotc', function () {
            $(this).children(1).next().css('display','none');
        });
    })
    var kw = 1;
    function addType() {
        numlist = $("input[name=numlist]").val();
        if(!$.isInt(numlist)){
            tip.msgbox.err("请填写要添加的条数");
            return false;
        }
        if(numlist>100){
            tip.msgbox.err("每次最多增加100条数据");
            return false;
        }
        $(".btn-add-type2").button("loading");
        $.ajax({
            url: "<?php  echo webUrl('goods/virtual/data/tpl',array('typeid'=>$_GPC['typeid']))?>&kw="+kw+"&numlist="+numlist,
            cache: false
        }).done(function (html) {
            $(".btn-add-type2").button("reset");
            $("#type-items").append(html);
        });
        kw++;
    }
    function removeType(obj) {
        $(obj).parent().parent().remove();
    }

    function autonum(_this){
//        alert(val);return;

        var $this = $(_this);
        var val = $this.parent().prev().val();

        if(val==''){
            tip.msgbox.err("请先录入一个值");
            $(this).parent().prev().focus();
            return;
        }
        var end = val.substr(val.length-1,1);
        if(isNaN(end)){
            tip.msgbox.err("此数据无法填充");
            return;
        }
        var reg = /\d+/g;
        var ms = val.match(reg);
        if(ms == null || ms == ''){
            tip.msgbox.err("此数据无法填充");
            return;
        }
        var endNum = ms[ms.length-1];
        if((parseInt(endNum)+1).toString().length > endNum.length){
            tip.msgbox.err("此数据无法填充");
            return;
        }
        if(endNum.toString().length > 16){
            tip.msgbox.err("卡密主键的末尾连续数字不能超过16位");
            return;
        }
        var eng = val.replace(endNum,'');
        var numArr = new Array();
        for(var i=0;i<=$(":input[mk=1]").length -1;i++){
            numArr[i] = parseInt(endNum) + i;
        }

        $('.btn-add-type').button('loading');
        $this.parents('tr').nextAll().find(":input[mk=1]").each(function(index,item){
            if(endNum.toString().length >= numArr[index+1].toString().length){
                item.value = eng + numArr[index+1];
            }
            $('.btn-add-type').button('reset');
        });

    }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

