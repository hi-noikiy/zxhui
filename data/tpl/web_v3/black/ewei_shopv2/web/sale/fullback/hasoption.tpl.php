<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
    .modal-dialog{width:920px;}
    .modal-dialog .input-group-addon{
        padding:0;
    }
    .modal-dialog .fa{
        margin-right: 0;
    }
    .content .table{border-collapse:collapse;border:none;}
    .content .table tr{border-collapse: collapse;border-left:1px solid #ededed;border-right:1px solid #ededed;}
    .content .table > tbody > tr > td{border-top:1px solid #ededed;border-left:0;border-right:0;}
</style>
<div class="content_hasoption">
    <!--<form class="form-horizontal form-validate" action="<?php  echo webUrl('sale/fullback/hasoption')?>" method="post" enctype="multipart/form-data">-->
    <input type='hidden' name='pid' value='<?php  echo $pid;?>' />
    <input type='hidden' name='goodsid' value='<?php  echo $goodsid;?>' />

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close hasoption-close" type="button">×</button>
                <h4 class="modal-title">设置</h4>
            </div>
            <div class="modal-body content">
                <table class="table" border="1" cellspacing="0" width="100%" cellpadding="0">
                    <thead style="background: #f7f7f7;">
                    <tr>
                        <th style=""><?php  if($option) { ?>规格<?php  } else { ?>商品<?php  } ?>名称</th>
                        <th style="width:80px;">原价</th>
                        <th style="width:100px;" class="fullprice">
                            <?php  if($option) { ?>
                            <div style="padding-bottom:10px;text-align:center;">全返总额</div>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm option_allfullbackprice_all"  VALUE=""/>
                                    <span class="input-group-addon">
                                        <a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol('option_allfullbackprice');"></a>
                                    </span>
                            </div>
                            <?php  } else { ?>全返总额<?php  } ?>
                        </th>
                        <th style="width:100px;" class="fullprice">
                            <?php  if($option) { ?>
                            <div style="padding-bottom:10px;text-align:center;">返还金额/天</div>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm option_minfullbackprice_all"  VALUE=""/>
                                    <span class="input-group-addon">
                                        <a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol('option_minfullbackprice');"></a>
                                    </span>
                            </div>
                            <?php  } else { ?>返还金额/天<?php  } ?>
                        </th>
                        <th style="width:120px;" class="fullratio">
                            <?php  if($option) { ?>
                            <div style="padding-bottom:10px;text-align:center;">全返总比例</div>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm option_allfullbackallratio_all"  VALUE=""/>
                                    <span class="input-group-addon">
                                        <a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol('option_allfullbackallratio');"></a>
                                    </span>
                            </div>
                            <?php  } else { ?>全返总比例<?php  } ?>
                        </th>
                        <th style="width:120px;" class="fullratio">
                            <?php  if($option) { ?>
                            <div style="padding-bottom:10px;text-align:center;">全返金额比例/天</div>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm option_minfullbackratio_all"  VALUE=""/>
                                    <span class="input-group-addon">
                                        <a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol('option_minfullbackratio');"></a>
                                    </span>
                            </div>
                            <?php  } else { ?>全返金额比例/天<?php  } ?>
                        </th>
                        <th style="width:100px;">
                            <?php  if($option) { ?>
                            <div style="padding-bottom:10px;text-align:center;">返还天数</div>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm option_day_all" readonly VALUE=""/>
                            </div>
                            <?php  } else { ?>返还天数<?php  } ?>
                        </th>
                        <?php  if($option) { ?>
                        <th style="width:50px;text-align: right;">全选 <input type='checkbox' /></th>
                        <?php  } ?>
                    </tr>
                    </thead>
                    <tbody id="param-items" class="ui-sortable">
                    <?php  if($option) { ?>
                    <?php  if(is_array($option)) { foreach($option as $item) { ?>
                    <tr class="multi-product-item option-item" data-id="<?php  echo $item['id'];?>">
                        <td><?php  echo $item['title'];?></td>
                        <td>&yen;<span class="original_price_<?php  echo $item['id'];?>"><?php  echo $item['marketprice'];?></span></td>
                        <td style="" class="fullprice">
                            <input name="option_allfullbackprice_<?php  echo $item['id'];?>" type="text" class="form-control option_allfullbackprice option_allfullbackprice_<?php  echo $item['id'];?>" placeholder="0" value="<?php  echo $item['allfullbackprice'];?>">
                        </td>

                        <td style="" class="fullprice">
                            <input name="option_minfullbackprice_<?php  echo $item['id'];?>" type="text" class="form-control option_minfullbackprice option_minfullbackprice_<?php  echo $item['id'];?>" placeholder="0" value="<?php  echo $item['minfullbackprice'];?>">
                        </td>

                        <td style="" class="fullratio">
                            <input name="option_allfullbackallratio_<?php  echo $item['id'];?>" type="text" class="form-control option_allfullbackallratio option_allfullbackallratio_<?php  echo $item['id'];?>" placeholder="0" value="<?php  echo $item['allfullbackallratio'];?>">
                        </td>

                        <td style="" class="fullratio">
                            <input name="option_minfullbackratio_<?php  echo $item['id'];?>" type="text" class="form-control option_minfullbackratio option_minfullbackratio_<?php  echo $item['id'];?>" placeholder="0" value="<?php  echo $item['minfullbackratio'];?>">
                        </td>

                        <td style="">
                            <input name="option_day_<?php  echo $item['id'];?>" readonly type="text" class="form-control option_day option_day_<?php  echo $item['id'];?>" placeholder="0" value="<?php  echo $item['day'];?>">
                        </td>

                        <td style="text-align: right;"><input type='checkbox' name="optionid" <?php  if($item['isoption']) { ?>checked<?php  } ?> value="<?php  echo $item['id'];?>"/></td>
                    </tr>
                    <?php  } } ?>
                    <?php  } else { ?>
                    <tr class="multi-product-item goods-item" data-id="<?php  echo $item['id'];?>">
                        <td><?php  echo $goods['title'];?></td>
                        <td>&yen;<span class="original_price"><?php  echo $goods['marketprice'];?></span></td>
                        <td style="" class="fullprice">
                            <input name="allfullbackprice<?php  echo $goodsid;?>" type="text" class="form-control allfullbackprice allfullbackprice<?php  echo $goodsid;?>" placeholder="0" value="<?php  echo $goods['allfullbackprice'];?>">
                            <input type="hidden" name="fullback_goods" data-goodsid="<?php  echo $goodsid;?>" data-id="<?php  echo $goods['id'];?>">
                        </td>

                        <td style="" class="fullprice">
                            <input name="minfullbackprice<?php  echo $goodsid;?>" type="text" class="form-control minfullbackprice minfullbackprice<?php  echo $goodsid;?>" placeholder="0" value="<?php  echo $goods['minfullbackprice'];?>">
                        </td>

                        <td style="" class="fullratio">
                            <input name="allfullbackallratio<?php  echo $goodsid;?>" type="text" class="form-control allfullbackallratio allfullbackallratio<?php  echo $goodsid;?>" placeholder="0" value="<?php  echo $goods['allfullbackallratio'];?>">
                        </td>

                        <td style="" class="fullratio">
                            <input name="minfullbackratio<?php  echo $goodsid;?>" type="text" class="form-control minfullbackratio minfullbackratio<?php  echo $goodsid;?>" placeholder="0" value="<?php  echo $goods['minfullbackratio'];?>">
                        </td>

                        <td style="">
                            <input name="day<?php  echo $goodsid;?>" type="text" readonly="true" class="form-control day day<?php  echo $goodsid;?>" placeholder="0" value="<?php  echo $goods['day'];?>">
                        </td>
                    </tr>
                    <?php  } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="option_submit">确认</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
            </div>
        </div>
        <!--</form>-->

    </div>

    <script type="text/javascript">
        $(function(){
            var fullType = $(":radio[name=type]:checked").val();
            if(fullType==1){
                $(".fullratio").show();
                $(".fullprice").hide();
            }else{
                $(".fullratio").hide();
                $(".fullprice").show();
            }
            //无规格计算
            $("input.minfullbackprice,input.allfullbackprice,input.allfullbackallratio,input.minfullbackratio").change(function () {
                var allprice = parseFloat(Math.abs($(this).parents(".goods-item").find("input.allfullbackprice").val())).toFixed(2);
                var minprice = parseFloat(Math.abs($(this).parents(".goods-item").find("input.minfullbackprice").val())).toFixed(2);
                var allratio = parseFloat(Math.abs($(this).parents(".goods-item").find("input.allfullbackallratio").val())).toFixed(2);
                var minratio = parseFloat(Math.abs($(this).parents(".goods-item").find("input.minfullbackratio").val())).toFixed(2);
                var day = 0;
                if(fullType==1){
                    // var original_price = $(".original_price").html();
                    day = Math.ceil((allratio/100)/(minratio/100));
                }else{
                    day = Math.ceil((allprice*10000/minprice)/10000);
                }

                if (!isFinite(day)){
                    day = 0;
                }
                $("input.allfullbackprice").val(allprice);
                $("input.minfullbackprice").val(minprice);
                $("input.allfullbackallratio").val(allratio);
                $("input.minfullbackratio").val(minratio);
                $("input.day").val(day);
            })
            //规格计算
            $("input.option_minfullbackprice,input.option_allfullbackprice,input.option_allfullbackallratio,input.option_minfullbackratio").change(function () {
                var opid = $(this).parents(".option-item").attr("data-id");
                var option_allprice = parseFloat(Math.abs($("input.option_allfullbackprice_"+opid+"").val())).toFixed(2);
                var option_minprice = parseFloat(Math.abs($("input.option_minfullbackprice_"+opid+"").val())).toFixed(2);
                var option_allratio = parseFloat(Math.abs($("input.option_allfullbackallratio_"+opid+"").val())).toFixed(2);
                var option_minratio = parseFloat(Math.abs($("input.option_minfullbackratio_"+opid+"").val())).toFixed(2);
                var option_day = 0;
                if(fullType==1){
                    var original_prices = $(".original_price_"+opid+"").html();
                    option_allprice = original_prices * option_allratio / 100;
                    option_day = Math.ceil(option_allprice/option_minratio);
                }else{
                    option_day = Math.ceil((option_allprice*10000/option_minprice)/10000);
                }
                if (!isFinite(option_day)){
                    option_day = 0;
                }
                $("input.option_allfullbackprice_"+opid+"").val(option_allprice);
                $("input.option_minfullbackprice_"+opid+"").val(option_minprice);
                $("input.option_allfullbackallratio_"+opid+"").val(option_allratio);
                $("input.option_minfullbackratio_"+opid+"").val(option_minratio);
                $("input.option_day_"+opid+"").val(option_day);
            })


            $(".option-item input[name=optionid]").removeProp('checked');
            var optionid = $("#fullbackgoods"+<?php  echo $goodsid;?>+"").val()
            if(<?php  echo $hasoption;?> && optionid){
                var opArray = optionid.split(",");
                $(opArray).each(function(index){
                    var specs = $("input[name='fullbackgoodsoption"+this+"']").val();
                    if(specs){
                        var specsArray = specs.split(",");
                        $(".option_allfullbackprice_"+this+"").val(specsArray[0]);
                        $(".option_minfullbackprice_"+this+"").val(specsArray[1]);
                        $(".option_allfullbackallratio_"+this+"").val(specsArray[2]);
                        $(".option_minfullbackratio_"+this+"").val(specsArray[3]);
                        $(".option_day_"+this+"").val(specsArray[4]);
                    }

                });
            }else{
                var pgoods = $("input[name='goods"+<?php  echo $goodsid;?>+"']").val();
                if(pgoods){
                    var pgoodsArray = pgoods.split(",");
                    $(".allfullbackprice"+<?php  echo $goodsid;?>+"").val(pgoodsArray[0]);
                    $(".minfullbackprice"+<?php  echo $goodsid;?>+"").val(pgoodsArray[1]);
                    $(".allfullbackallratio"+<?php  echo $goodsid;?>+"").val(pgoodsArray[2]);
                    $(".minfullbackratio"+<?php  echo $goodsid;?>+"").val(pgoodsArray[3]);
                    $(".day"+<?php  echo $goodsid;?>+"").val(pgoodsArray[4]);
                }
            };

            $(".option-item").each(function(){
                if(optionid.indexOf($(this).find("input[name=optionid]").val()) >= 0){
                    $(this).find("input[name=optionid]").prop('checked','true');

                }
            })

            //是否有规格提交
            $("#option_submit").on("click",function(){
                var option = [];
                var optoinhtml = '';
                var fullbackgoods = [];
                var fullbackprice = 0;
                var minfullbackprice = 0;
                var allfullbackallratio = 0;
                var minfullbackratio = 0;
                var day = 0;
                $("#param-items .option-item").each(function (index) {
                    if($(this).find("input[name='optionid']").prop("checked")){
                        option[index] = $(this).find("input[name='optionid']").val();
                        fullbackprice = $(this).find("input[name^='option_allfullbackprice']").val() ? parseFloat($(this).find("input[name^='option_allfullbackprice']").val()).toFixed(2) : 0;
                        minfullbackprice = $(this).find("input[name^='option_minfullbackprice']").val() ? parseFloat($(this).find("input[name^='option_minfullbackprice']").val()).toFixed(2) : 0;
                        allfullbackallratio = $(this).find("input[name^='option_allfullbackallratio']").val() ? parseFloat($(this).find("input[name^='option_allfullbackallratio']").val()).toFixed(2) : 0;
                        minfullbackratio = $(this).find("input[name^='option_minfullbackratio']").val() ? parseFloat($(this).find("input[name^='option_minfullbackratio']").val()).toFixed(2) : 0;
                        if(fullType==1){
                            day = Math.ceil(allfullbackallratio/minfullbackratio);
                        }else{
                            day = Math.ceil((fullbackprice*10000/minfullbackprice)/10000);
                        }
                        if (!isFinite(day)){
                            day = 0;
                        }
                        day = $(this).find("input[name^='option_day']").val() ? day : 0;
                        fullbackgoods[index] = [fullbackprice,minfullbackprice,allfullbackallratio,minfullbackratio,day];
                        optoinhtml += '<input type="hidden" value="'+fullbackgoods[index]+'" name="fullbackgoodsoption'+option[index]+'" >';
                    }
                })

                if(option.length > 0){
                    $.ajax({
                        url:"<?php  echo webUrl('sale/fullback/option',array('type'=>'option'))?>",
                        type:'get',
                        data:{option:option},
                        dataType:'json',
                        async : false, //默认为true 异步
                        success:function(data){
                            $("#fullbackgoods"+<?php  echo $goodsid;?>+"").val(option);
                            if(!data.result.title){
                                $("#optiontitle"+<?php  echo $goodsid;?>+"").html("设置");
                            }else{
                                $("#optiontitle"+<?php  echo $goodsid;?>+"").html(""+data.result.title+"...");
                            }
                            var $objOption = $("#fullbackgoods"+<?php  echo $goodsid;?>+"").nextAll();
                            if($objOption){
                                $objOption.remove();
                            }
                            $("#fullbackgoods"+<?php  echo $goodsid;?>+"").after(optoinhtml)

                        }
                    });
                }else{
                    //无规格提交
                    var goodsid = $("input[name='fullback_goods']").attr("data-goodsid");
                    var price = $("input[name='allfullbackprice"+goodsid+"']").val();
                    var minfullbackprice = $("input[name='minfullbackprice"+goodsid+"']").val();
                    var allfullbackallratio = $("input[name='allfullbackallratio"+goodsid+"']").val();
                    var minfullbackratio = $("input[name='minfullbackratio"+goodsid+"']").val();
                    var day = $("input[name='day"+goodsid+"']").val();
                    var fullbackgoods = [price,minfullbackprice,allfullbackallratio,minfullbackratio,day];

                    var fullbackgoodshtml = '<input type="hidden" value="'+fullbackgoods+'" name="goods'+<?php  echo $goodsid;?>+'" >';
                    if($("input[name='goods"+goodsid+"']").val()){
                        $("input[name='goods"+goodsid+"']").remove();
                        $("#optiontitle"+goodsid+"").after(fullbackgoodshtml)
                    }else{
                        $("#optiontitle"+goodsid+"").after(fullbackgoodshtml)
                    }
                    if(fullType==1){
                        $("#optiontitle"+goodsid+"").html(allfullbackallratio+"%");
                    }else{
                        $("#optiontitle"+goodsid+"").html("&yen;"+price);
                    }
                }

                //关闭弹窗
                $('.hasoption-close').trigger('click');
            })
        })
        function setCol(cls){
            $("."+cls).val( $("."+cls+"_all").val());
            $(".option-item").each(function () {
                var opid = $(this).attr("data-id");
                var option_allprice = parseFloat(Math.abs($("input.option_allfullbackprice_"+opid+"").val())).toFixed(2);
                var option_minprice = parseFloat(Math.abs($("input.option_minfullbackprice_"+opid+"").val())).toFixed(2);
                var option_allratio = parseFloat(Math.abs($("input.option_allfullbackallratio_"+opid+"").val())).toFixed(2);
                var option_minratio = parseFloat(Math.abs($("input.option_minfullbackratio_"+opid+"").val())).toFixed(2);
                var option_day = 0;
                var fullType = $(":radio[name=type]:checked").val();
                if(fullType==1){
                    var original_prices = $(".original_price_"+opid+"").html();
                    option_allprice = original_prices * option_allratio / 100;
                    option_day = Math.ceil((option_allratio/100)/(option_minratio/100));
                }else{
                    option_day = Math.ceil((option_allprice*10000/option_minprice)/10000);
                }
                if (!isFinite(option_day)){
                    option_day = 0;
                }
                $("input.option_allfullbackprice_"+opid+"").val(option_allprice);
                $("input.option_minfullbackprice_"+opid+"").val(option_minprice);
                $("input.option_allfullbackallratio_"+opid+"").val(option_allratio);
                $("input.option_minfullbackratio_"+opid+"").val(option_minratio);
                $("input.option_day_"+opid+"").val(option_day);
            })
        }

    </script>



