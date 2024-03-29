<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($dispatch['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>配送方式<?php  if(!empty($dispatch['id'])) { ?>(<?php  echo $dispatch['dispatchname'];?>)<?php  } ?></span>
</div>


<div class="page-content">
    <div class="page-sub-toolbar">
        <span>
            <?php if(mcv('shop.dispatch.add')) { ?>
                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('shop/dispatch',array('op'=>'post'))?>">添加新配送方式</a>
            <?php  } ?>
        </span>
    </div>
    <form <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $dispatch['id'];?>" />
        <div class="form-group">
            <label class="col-lg control-label">排序</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <input type="text" name="displayorder" class="form-control" value="<?php  echo $dispatch['displayorder'];?>" />
                <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $dispatch['displayorder'];?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label must">配送方式名称</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <input type="text" id='dispatchname' name="dispatchname" class="form-control" value="<?php  echo $dispatch['dispatchname'];?>" data-rule-required='true' />
                <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $dispatch['dispatchname'];?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label ">是否默认</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <label class='radio-inline'><input type='radio' name='isdefault' id="isdefault1" value='1' <?php  if($dispatch['isdefault']==1) { ?>checked<?php  } ?> /> 是</label>
                    <label class='radio-inline'><input type='radio' name='isdefault' id="isdefault0" value='0' <?php  if($dispatch['isdefault']==0) { ?>checked<?php  } ?> /> 否</label>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($dispatch['calculatetype'])) { ?>按重量计费<?php  } else { ?>按件计费<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label ">计费方式</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <label class='radio-inline'><input type='radio' name='calculatetype' value='0' <?php  if($dispatch['calculatetype']==0) { ?>checked<?php  } ?> /> 按重量计费</label>
                    <label class='radio-inline'><input type='radio' name='calculatetype' value='1' <?php  if($dispatch['calculatetype']==1) { ?>checked<?php  } ?> /> 按件计费</label>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($dispatch['calculatetype'])) { ?>按重量计费<?php  } else { ?>按件计费<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group dispatch0">
            <label class="col-lg control-label ">物流公司</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <input type='hidden' name='expressname' value='<?php  echo $dispatch['expressname'];?>'/>
                    <select name='express' class="form-control select2">
                        <option value="" data-name="其他快递">其他快递</option>
                        <?php  if(is_array($express_list)) { foreach($express_list as $value) { ?>
                            <option value="<?php  echo $value['express'];?>" data-name="<?php  echo $value['name'];?>"><?php  echo $value['name'];?></option>
                        <?php  } } ?>
                    </select>
                    <span class="help-block">如果您选择了常用快递，则客户可以订单中查询快递信息，如果缺少您想要的快递，您可以联系我们! </span>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $dispatch['expressname'];?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label" style="padding-top: 11px">配送区域</label>
            <div class="col-sm-9 col-xs-12">
                <table  style='width:100%;'>
                    <thead>
                        <tr>
                            <th style="height:40px;width:400px;">运送到</th>
                            <th class="show_h" style="width:110px;">首重(克)</th>
                            <th class="show_h" style="width:110px;">首费(元)</th>
                            <th class="show_h" style="width:110px;">续重(克)</th>
                            <th class="show_h" style="width:110px;">续费(元)</th>

                            <th class="show_n" style="width:110px;">首件(个)</th>
                            <th class="show_n" style="width:110px;">运费(元)</th>
                            <th class="show_n" style="width:110px;">续件(个)</th>
                            <th class="show_n" style="width:110px;">续费(元)</th>
                            <th style="width:80px;">管理</th>
                        </tr>
                    </thead>
                    <tbody id='tbody-areas'>
                        <tr>
                            <td style="padding:10px 10px 10px 0;">全国 [默认运费]</td>
                            <td class="show_h text-center">
                            <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                <input type="text" value="<?php echo empty($dispatch['firstweight'])?1000:$dispatch['firstweight']?>" class="form-control" name="default_firstweight" style="width:100px;"></td>
                            <?php  } else { ?>
                                <div class='show_h form-control-static'><?php echo empty($dispatch['firstweight'])?1000:$dispatch['firstweight']?></div>
                            <?php  } ?>
                            <td class="show_h text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php  echo $dispatch['firstprice'];?>" class="form-control" name="default_firstprice"  style="width:100px;" />
                                <?php  } else { ?>
                                    <div class='show_h form-control-static'><?php  echo $dispatch['firstprice'];?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_h text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php echo empty($dispatch['secondweight'])?1000:$dispatch['secondweight']?>" class="form-control" name="default_secondweight"  style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_h form-control-static'><?php echo empty($dispatch['secondweight'])?1000:$dispatch['secondweight']?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_h text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php  echo $dispatch['secondprice'];?>" class="form-control" name="default_secondprice"  style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_h form-control-static'><?php  echo $dispatch['secondprice'];?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_h"></td>
                            <td class="show_n text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php echo empty($dispatch['firstnum'])?1:$dispatch['firstnum']?>" class="form-control" name="default_firstnum" style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_n form-control-static'><?php echo empty($dispatch['firstnum'])?1:$dispatch['firstnum']?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_n text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php  echo $dispatch['firstnumprice'];?>" class="form-control" name="default_firstnumprice"  style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_n form-control-static'><?php  echo $dispatch['firstnumprice'];?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_n text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php echo empty($dispatch['secondnum'])?1:$dispatch['secondnum']?>" class="form-control" name="default_secondnum"  style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_n form-control-static'><?php echo empty($dispatch['secondnum'])?1:$dispatch['secondnum']?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_n text-center">
                                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                                    <input type="text" value="<?php  echo $dispatch['secondnumprice'];?>" class="form-control" name="default_secondnumprice"  style="width:100px;">
                                <?php  } else { ?>
                                    <div class='show_n form-control-static'><?php  echo $dispatch['secondnumprice'];?></div>
                                <?php  } ?>
                            </td>
                            <td class="show_n"></td>
                        </tr>
                        <?php  if(is_array($dispatch_areas)) { foreach($dispatch_areas as $row) { ?>
                            <?php  $random = random(16);?>
                            <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/dispatch/tpl', TEMPLATE_INCLUDEPATH)) : (include template('shop/dispatch/tpl', TEMPLATE_INCLUDEPATH));?>
                        <?php  } } ?>
                    </tbody>
                </table>
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <a class='btn btn-default' href="javascript:;" onclick='addArea(this)'><span class="fa fa-plus"></span> 新增配送区域</a>
                    <span class='help-block show_h' <?php  if($dispatch['calculatetype']==1) { ?>style='display:none'<?php  } ?>>根据重量来计算运费，当物品不足《首重重量》时，按照《首重费用》计算，超过部分按照《续重重量》和《续重费用》乘积来计算</span>
                    <span class='help-block show_n' <?php  if($dispatch['calculatetype']==0) { ?>style='display:none'<?php  } ?>>根据件数来计算运费，当物品不足《首件数量》时，按照《首件费用》计算，超过部分按照《续件重量》和《续件费用》乘积来计算</span>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group-title">特殊区域设置</div>

        <div class="form-group">
            <label class="col-lg control-label ">类型</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <label class='radio-inline'><input type='radio' name='isdispatcharea' value='0' <?php  if($dispatch['isdispatcharea']==0) { ?>checked<?php  } ?> /> 不配送区域</label>
                    <label class='radio-inline'><input type='radio' name='isdispatcharea' value='1' <?php  if($dispatch['isdispatcharea']==1) { ?>checked<?php  } ?> /> 只配送区域</label>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($dispatch['isdispatcharea'])) { ?>不配送区域<?php  } else { ?>只配送区域<?php  } ?></div>
                <?php  } ?>
                <span class='help-block'>不配送区域:不配送选择的区域,只配送未选择的区域<br>只配送区域:只配送选择的区域,不配送未选择的区域<br>只能选择一种类型</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label"><span id="dispatcharea_name"><?php  if(empty($dispatch['isdispatcharea'])) { ?>不<?php  } else { ?>只<?php  } ?></span>配送区域</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <div id="areas" class="form-control-static"><?php  echo $dispatch_nodispatchareas;?></div>
                    <a href="javascript:;" class="btn btn-default" onclick="selectAreas()">选择地区</a>
                    <input type="hidden" id='selectedareas' name="nodispatchareas" value="<?php  echo $dispatch_nodispatchareas;?>" />
                    <input type="hidden" id='selectedareas_code' name="nodispatchareas_code" value="<?php  echo $dispatch_nodispatchareas_code;?>" />
                <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $dispatch_nodispatchareas;?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group-title"></div>

        <div class="form-group">
            <label class="col-lg control-label ">状态</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <label class='radio-inline'><input type='radio' name='enabled' value=1' <?php  if($dispatch['enabled']==1) { ?>checked<?php  } ?> /> 启用</label>
                    <label class='radio-inline'><input type='radio' name='enabled' value=0' <?php  if($dispatch['enabled']==0) { ?>checked<?php  } ?> /> 禁用</label>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($item['enabled'])) { ?>禁用<?php  } else { ?>启用<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label "></label>
            <div class="col-sm-9 col-xs-12">
                <?php if( mce('shop.dispatch' ,$dispatch) ) { ?>
                    <input type="submit" value="提交" class="btn btn-primary"  />
                <?php  } ?>
                <input type="button" name="back" onclick='history.back()' <?php if(mcv('shop.dispatch.add|shop.dispatch.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
            </div>
        </div>
    </form>
</div>

<?php  if(empty($new_area)) { ?>
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareas', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareas', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareasNew', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareasNew', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<script language='javascript'>
    function show_type(flag){
        if (flag == 1) {
            $('.show_h').hide();
            $('.show_n').show();
        } else {
            $('.show_h').show();
            $('.show_n').hide();
        }
    }
    $(function(){
        show_type(<?php  echo $dispatch['calculatetype']?>);
        $(':radio[name=calculatetype]').click(function(){
            var val = $(this).val();
            show_type(val);
        })
        $(':radio[name=dispatchtype]').click(function(){
            var val = $(this).val();
            $(".dispatch0,.dispatch1").hide();
            $(".dispatch" + val).show();
        })

        $(':radio[name=isdispatcharea]').click(function(){
            var val = $(this).val();
            var name = '不';
            if(val == 1) {
                name = '只';
            }
            $("#dispatcharea_name").html(name);
        })

        $("select[name=express]").change(function(){
            var obj = $(this);
            var sel = obj.find("option:selected");
            $(":input[name=expressname]").val(sel.data("name"));
        });
        <?php  if(!empty($dispatch['express'])) { ?>
        $("select[name=express]").val("<?php  echo $dispatch['express'];?>");
        <?php  } ?>

        <?php  if(empty($new_area)) { ?>
        $('.province').mouseover(function(){
            $(this).find('ul').show();
        }).mouseout(function(){
            $(this).find('ul').hide();
        });

        $('.cityall').click(function(){
            var checked = $(this).get(0).checked;
            var citys = $(this).parent().parent().find('.city');
            citys.each(function(){
                $(this).get(0).checked = checked;
            });
            var count = 0;
            if (checked){
                count = $(this).parent().parent().find('.city:checked').length;
            }
            if (count > 0){
                $(this).next().html("(" + count + ")");
            }
            else{
                $(this).next().html("");
            }
        });

        $('.city').click(function(){
            var checked = $(this).get(0).checked;
            var cityall = $(this).parent().parent().parent().parent().find('.cityall');
            if (checked){
                cityall.get(0).checked = true;
            }
            var count = cityall.parent().parent().find('.city:checked').length;
            if (count > 0){
                cityall.next().html("(" + count + ")");
            }
            else{
                cityall.next().html("");
            }
        });
        <?php  } ?>
    });
    function getCurrents(withOutRandom){
        var citys = "";
        $('.citys').each(function(){
            var crandom = $(this).prev().val();
            if (withOutRandom && crandom == withOutRandom){
                return true;
            }
            citys += $(this).val();
        });
        return citys;
    }
    function getCurrentsCode(withOutRandom){
        var citys = "";
        $('.citys_code').each(function(){
            var crandom = $(this).prev().prev().prev().val();
            if (withOutRandom && crandom == withOutRandom){
                return true;
            }
            citys += $(this).val();
        });
        return citys;
    }
    var current = '';
    function addArea(btn){
        $(btn).button('loading');
        $.ajax({
            url:"<?php  echo webUrl('shop/dispatch/tpl')?>",
            dataType:'json',
            success:function(json){
                $(btn).button('reset');
                current = json.random;
                $('#tbody-areas').append(json.html);
                $('#tbody-areas tr').last().hide();
                clearSelects();
                $("#modal-areas").modal();

                var citystrs = "";

                <?php  if(empty($new_area)) { ?>
                var currents = getCurrents();
                currents = currents.split(';');
                $('.city').each(function(){
                    var parentdisabled = false;
                    for (var i in currents){
                        if (currents[i] != '' && currents[i] == $(this).attr('city')){
                            $(this).attr('disabled', true);
                            $(this).parent().parent().parent().parent().find('.cityall').attr('disabled', true);
                        }
                    }
                });
                $('#btnSubmitArea').unbind('click').click(function(){
                    $('.city:checked').each(function(){
                        citystrs += $(this).attr('city') + ";";
                    });
                    $('.' + current + ' .cityshtml').html(citystrs);
                    $('.' + current + ' .citys').val(citystrs);
                    $('#tbody-areas tr').last().show();
                })
                <?php  } else { ?>
                var currents = getCurrentsCode();
                currents = currents.split(';');

                var parentdisabled = false;
                for (var i in currents){
                    var area_info = currents[i].split(' ');
                    if(area_info[0]) {
                        $('#ch_pcode'+area_info[0]).prop("disabled",true);
                    }
                    if(area_info[1]) {
                        $('#ch_ccode'+area_info[1]).prop("disabled",true);
                    }
                    if(area_info[2]) {
                        $('#ch_acode'+area_info[2]).prop("disabled",true);
                    }
                }

                $('#btnSubmitArea').unbind('click').click(function(){
                    update_area();
                    var city_html = $('#city_info').html();
                    var area_html = $('#area_info').html();

                    if (city_html && area_html) {
                        $('.' + current + ' .cityshtml').html(city_html);
                        $('.' + current + ' .citys').val(city_html);
                        $('.' + current + ' .citys_code').val(area_html);
                        $('#tbody-areas tr').last().show();
                    }


                })
                <?php  } ?>

                var calculatetype1 = $('input[name="calculatetype"]:checked ').val();
                show_type(calculatetype1);
            }
        })
    }

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
