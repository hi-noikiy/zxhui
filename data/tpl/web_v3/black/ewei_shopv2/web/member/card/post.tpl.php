<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="/favicon.ico" rel="shortcut icon" />
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/static/css/card/index.css"/>
<script type="text/javascript" src="js/bootstrap-colorpalette.js" charset="utf-8"></script>

<style>
	.dropdown-menu {
		border: medium none;
		font-size: 12px;
		left: 0;
		list-style: none outside none;
		padding: 0;
		text-shadow: none;
		top: 100%;
		z-index: 1000;
		border-radius: 0;
		box-shadow: 0 0 3px rgba(86, 96, 117, 0.3);
	}

	.dropdown-menu li {
		display: inline-block;
	}

	.bootstrap-colorpalette {
		padding-left: 4px;
		padding-right: 4px;
		white-space: normal;
		line-height: 1;
	}

	.tabs-container .form-group-color {
		margin-right: -15px;
		margin-left: -15px;
	}
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/web/sale/wxcard/css/iconfont.css"/>

<div class='page-header'>
     当前位置：<span class="text-primary">基本信息</span>
</div>
<div class="page-content">
    <form <?php if(cv('member.card')) { ?>action="" method='post'<?php  } ?> class='form-horizontal form-validate'>
    <div class="flex">
        <div class="preview" style="overflow: visible;position: relative;top: 0;height: 1%;">
            <div class="cart-top">
                <img src="../addons/ewei_shopv2/static/images/cart_top.jpg" alt=""/>
            </div>
            <div class="title">
                <i class="back icon icon-back"></i>
                <i class="more pull-right icon icon-more"></i>
            </div>
            <div class="panel" style="border: none;">
                <!--商户信息-->
                <div class="logo-area">
                    <div class="logo">
                        <img id="logoimg" src="<?php  if(empty($card)) { ?>../addons/ewei_shopv2/static/images/default.png<?php  } else { ?><?php  echo $card['card_logoimg'];?><?php  } ?>"/>
                    </div>
                    <div class="name"  id="title">
                        <?php echo empty($card['card_brand_name'])?'会员卡标题名称':$card['card_brand_name']?>
                    </div>
                    </br>
                    <div class="name"  id="brandname">
                        <?php echo empty($card['card_title'])?'会员卡商铺名称':$card['card_title']?>
                    </div>
                    <div class="code">
                        <img src="../addons/ewei_shopv2/static/images/code.jpg" alt="" />
                    </div>
                    <div class="bot">
                        <span>0268 8888 8888</span>
                        <i class="icon icon-info pull-right"></i>
                    </div>
                </div>
                <div class="card-other">
                    <ul>
                        <li id="show_custom_cell1" <?php  if(empty($card['custom_cell1'])) { ?>style="display:none;" <?php  } ?>>
                        <span id="show_custom_cell1_name"><?php echo empty($card['custom_cell1_name'])?'自定义入口':$card['custom_cell1_name']?></span>
                        <span style="float: right;">
                            <span id="show_custom_cell1_tips"><?php echo empty($card['custom_cell1_tips'])?'立即进入':$card['custom_cell1_tips']?></span>

                            <i  class="go pull-right icon icon-right"></i>
                        </span>
                        </li>
                        <li>会员卡详情<i class="go pull-right icon icon-right"></i></li>
                        <li>公众号<i class="go pull-right icon icon-right"></i></li>
                    </ul>
                </div>
            </div>
            <!--自定义入口-->
            <!--卡券其他-->
            <div class="card-other">
                <ul>
                </ul>
            </div>
        </div>

        <!--控制台-->
            <div class="control flex1" style="padding: 10px 0;background: none">
                <div class="editor_section">
                    <!--会员卡标题-->
                    <div class="form-group">
                        <label class="col-lg control-label must"> 会员卡标题</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <input type="text" name="card_title" id="card_title" class="input form-control" value="<?php  echo $card['card_title'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> maxlength=15 />
                            <?php  } else { ?>
                            <?php  echo $card['card_title'];?>
                            <?php  } ?>
                        </div>
                    </div>
                    <!--商铺名称-->
                    <div class="form-group">
                        <label class="col-lg control-label must">  商铺名称</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <input type="text" name="card_brand_name" id="card_brand_name" class="input form-control" value="<?php  echo $card['card_brand_name'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> maxlength=15/>
                            <?php  } else { ?>
                            <?php  echo $card['card_brand_name'];?>
                            <?php  } ?>
                        </div>
                    </div>

                    <!--库存总量-->
                    <div class="form-group">
                        <label class="col-lg control-label must">  库存总量</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <input type="text" name="card_totalquantity" id="card_totalquantity" maxlength=10  class="input form-control" value="<?php  echo $card['card_totalquantity'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> />
                            <?php  } else { ?>
                            <?php  echo $card['card_totalquantity'];?>
                            <?php  } ?>
                        </div>
                    </div>

                    <!--logo图片-->
                    <div class="form-group">
                        <label class="col-lg control-label must">logo图片</label>
                        <div class="col-sm-8 col-xs-12">
                            <div class="frm-image" style="margin-bottom: 10px">
                                <input type="hidden" name="card_logoimg" id="card_logoimg" value="<?php  echo $card['card_logoimg'];?>"/>
                                <input type="hidden" name="card_logolocalpath" id="card_logolocalpath" value=""/>
                                <img  id="showlogo"  src="<?php  if(empty($card)) { ?>../addons/ewei_shopv2/static/images/default.png<?php  } else { ?><?php  echo $card['card_logoimg'];?><?php  } ?>" style="width: 50px;height:50px;" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                            </div>
                            <a class="btn btn-default upload" href="javascript:void(0);" <?php if(cv('member.card')) { ?>id="uploadlogo"<?php  } else { ?>disabled<?php  } ?> >上传图片</a>
                            <p class='help-block'>卡券的商户logo，建议像素为300*300。图片大小不能超过1mb,仅支持jpg,png格式</p>
                        </div>
                    </div>

                    <!--卡券是否显示余额设置-->
                    <div class="form-group">
                        <div class="col-lg control-label">
                            是否显示余额
                        </div>
                        <?php if(cv('member.card')) { ?>
                            <?php  if(empty($card)) { ?>
                            <div class="col-sm-8 col-xs-12">
                                <label class="radio-inline">
                                    <input type="radio" name="card_supply_balance" value="0" <?php  if(empty($card['card_supply_balance'])) { ?>checked="true"<?php  } ?> />
                                    不使用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="card_supply_balance" value="1" <?php  if(!empty($card['card_supply_balance'])) { ?>checked="true"<?php  } ?> />
                                    使用
                                </label>
                            </div>
                            <?php  } else { ?>
                                <input type="hidden" name="card_supply_balance" value="<?php  echo $card['card_supply_balance'];?>">
                                <div class="col-sm-8 col-xs-12">
                                    <?php  if(empty($card['card_supply_balance'])) { ?>
                                    不使用
                                    <?php  } else { ?>
                                    使用
                                    <?php  } ?>
                                </div>
                            <?php  } ?>
                        <?php  } else { ?>
                            <input type="hidden" name="card_supply_balance" value="<?php  echo $card['card_supply_balance'];?>">
                            <div class="col-sm-8 col-xs-12">
                                <?php  if(empty($card['card_supply_balance'])) { ?>
                                不使用
                                <?php  } else { ?>
                                使用
                                <?php  } ?>
                            </div>
                        <?php  } ?>
                        <div class="col-sm-8 col-xs-12">
                            <p class='help-block'>使用微信卡券余额（具体为在会员卡中使用“余额/supply_balance”字段）需提交《单用途预付卡备案》。 操作指引详见： <a href="https://mp.weixin.qq.com/cgi-bin/readtemplate?token=1091016770&t=cardticket/faq_tmpl&type=info&token=1494071418&lang=zh_CN#3dot2">卡券储值功能权限开通</a>。​</p>
                        </div>
                    </div>

                    <!--卡券背景设置-->
                    <div class="form-group">
                        <label class="col-lg control-label">  卡券背景设置</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="card_backgroundtype" value="0"
                                       onclick="$('.backgroundimg').hide();$('.color').show();$('.btn-color-down').hide();"
                                       <?php  if(empty($card['card_backgroundtype'])) { ?>checked="true"<?php  } ?> /> 使用背景色
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="card_backgroundtype" value="1"
                                       onclick="$('.backgroundimg').show();$('.color').hide();$('.btn-color-down').hide();"
                                       <?php  if(!empty($card['card_backgroundtype'])) { ?>checked="true"<?php  } ?> /> 使用背景图片
                            </label>
                            <?php  } else { ?>
                            <input type="hidden" name="card_backgroundtype" value="<?php  echo $card['card_backgroundtype'];?>">
                            <div class='frm_controls'>
                                <?php  if(empty($card['card_backgroundtype'])) { ?>
                                使用背景色
                                <?php  } else { ?>
                                使用背景图片
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>

                    <!--会员卡背景图-->
                    <div class="form-group backgroundimg"  <?php  if(empty($card['card_backgroundtype'])) { ?> style="display:none;"<?php  } ?>>
                        <label class="col-lg control-label">会员卡背景图</label>
                        <div class="col-sm-8 col-xs-12">
                            <div class="frm-image" style="margin-bottom: 10px">
                                <input type="hidden" name="card_backgroundimg" id="card_backgroundimg" value="<?php  echo $card['card_backgroundimg'];?>"/>
                                <input type="hidden" name="card_backgroundimg_localpath" id="card_backgroundimg_localpath" value=""/>
                                <img  id="showbackground"  src="<?php  echo $card['card_backgroundimg'];?>" style="width: 50px;height: 50px;"onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                            </div>
                            <a class="btn btn-default upload" href="javascript:void(0);" <?php if(cv('member.card')) { ?> id="uploadbackground"    <?php  } else { ?>disabled<?php  } ?> >上传图片</a>
                            <p class='frm_tip'>卡券的商户logo，建议像素为1000*600。图片大小不能超过1mb,仅支持jpg,png格式</p>
                        </div>
                    </div>

                    <!--卡券颜色-->

                <div class="form-group color control-group"  <?php  if(!empty($card['card_backgroundtype'])) { ?> style="display:none;"<?php  } ?>>
                    <label class="col-lg control-label ">卡券背景色</label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="btn-groups  btn-group btns">
                            <input type="hidden" name="color2" id="color2" value="<?php  echo $card['color2'];?>"/>
                            <input type="hidden" name="color" id="color" value="<?php  if(empty($card['color'])) { ?>Color010<?php  } else { ?><?php  echo $card['color'];?><?php  } ?>"/>
                            <?php if( ce('sale.wxcard' ,$card) ) { ?>
                            <a id="selected-color2" class="dropdown-toggle" data-toggle="dropdown"><i  <?php  if(empty($card['color'])) { ?>style=" background-color: rgb(99, 179, 89);"<?php  } else { ?>style=" background-color: <?php  echo $card['color2'];?>;"<?php  } ?>></i><span class="caret pull-right"></span></a>
                            <?php  } else { ?>
                            <a class="dropdown-toggle" ><i <?php  if(empty($card['color'])) { ?>style=" background-color: rgb(99, 179, 89);"<?php  } else { ?>style=" background-color: <?php  echo $card['color2'];?>;"<?php  } ?>></i><span class="caret pull-right"></span></a>
                            <?php  } ?>
                            <ul class="dropdown-menu" style="width:180px;">
                                <li style="display:inline-block;">
                                    <div id="colorpalette3"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                    <!--特权说明-->

                    <div class="form-group">
                        <label class="col-lg control-label must">特权说明</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                                <textarea  name="prerogative" class="form-control" rows="5" cols="50"><?php  echo $card['prerogative'];?></textarea>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $card['prerogative'];?></div>
                            <?php  } ?>
                            <p class='help-block'>文本长度不能超过300字</p>
                        </div>
                    </div>

                    <!--使用须知-->
                    <div class="form-group">
                        <label class="col-lg control-label must">使用须知</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                                <textarea  class="form-control" name="card_description" rows="5" cols="50"><?php  echo $card['card_description'];?></textarea>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  echo $card['card_description'];?></div>
                            <?php  } ?>
                            <p class='help-block'>文本长度不能超过300字</p>
                        </div>
                    </div>

                    <!--商户服务-->
                    <div class="form-group">
                        <label class="col-lg control-label">商户服务</label>
                        <div class="col-sm-8 col-xs-12">
                            <div class="frm_controls">
                                <label class="checkbox-inline">
                                    <!--BIZ_SERVICE_FREE_WIFI-->
                                    <input type="checkbox" name="freewifi" id="freewifi" <?php  if(!empty($card['freewifi'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >免费WIFI
                                </label>
                                <label class="checkbox-inline">
                                    <!--BIZ_SERVICE_WITH_PET-->
                                    <input type="checkbox" name="withpet" id="withpet" <?php  if(!empty($card['withpet'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> />可带宠物
                                </label>
                                <label class="checkbox-inline">
                                    <!--BIZ_SERVICE_FREE_PARK-->
                                    <input type="checkbox" name="freepark" id="freepark" <?php  if(!empty($card['freepark'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >免费停车
                                </label>
                                <label class="checkbox-inline">
                                    <!--BIZ_SERVICE_DELIVER-->
                                    <input type="checkbox" name="deliver" id="deliver" <?php  if(!empty($card['deliver'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >可外卖
                                </label>
                            </div>
                            <p class='help-block'>会员卡商户服务创建后无法修改</p>
                        </div>
                    </div>



                    <!--是否自定义入口-->
                    <div class="form-group">
                        <label class="col-lg control-label">开启自定义入口</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="custom_cell1" value="1"  onclick="$('.custom_cell1').show();$('#show_custom_cell1').show();" <?php  if(!empty($card['custom_cell1'])) { ?>checked="true"<?php  } ?>  />开启
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="custom_cell1" value="0"   onclick="$('.custom_cell1').hide();$('#show_custom_cell1').hide();" <?php  if(empty($card['custom_cell1'])) { ?>checked="true"<?php  } ?> />关闭
                            </label>
                            <?php  } else { ?>
                            <input type="hidden" name="custom_cell1" value="<?php  echo $card['custom_cell1'];?>">
                            <div class='frm_controls'>
                                <?php  if(empty($card['custom_cell1'])) { ?>
                                关闭
                                <?php  } else { ?>
                                开启
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>

                    <!--入口名称-->
                    <div class="form-group custom_cell1"  <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
                        <label class="col-lg control-label">入口名称</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <input type="text"  name="custom_cell1_name" id="custom_cell1_name" class="input form-control" value="<?php  echo $card['custom_cell1_name'];?>" />
                            <?php  } else { ?>
                            <?php  echo $card['custom_cell1_name'];?>
                            <?php  } ?>
                        </div>
                    </div>

                    <!--引导语-->
                    <div class="form-group custom_cell1"  <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
                        <label class="col-lg control-label">引导语</label>
                        <div class="col-sm-8 col-xs-12">
                            <?php if(cv('member.card')) { ?>
                            <input type="text" name="custom_cell1_tips" id="custom_cell1_tips" class="input form-control" value="<?php  echo $card['custom_cell1_tips'];?>" />
                            <?php  } else { ?>
                            <?php  echo $card['custom_cell1_tips'];?>
                            <?php  } ?>
                        </div>
                    </div>



                    <!--入口跳转链接-->
                    <div class="form-group custom_cell1"   <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
                        <label class="col-lg control-label">入口跳转链接</label>
                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group">
                                <?php if(cv('member.card')) { ?>
                                <input type="text" name="custom_cell1_url" id="custom_cell1_url" class="input form-control" value="<?php  echo $card['custom_cell1_url'];?>"  />
                                <div class="input-group-btn">
                                    <span data-input="#custom_cell1_url" data-toggle="selectUrl" class="btn btn-default" data-full="true">选择链接</span>
                                </div>
                                <?php  } else { ?>
                                <?php  echo $card['custom_cell1_url'];?>
                                <?php  } ?>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
</div>

    <div class='panel-body' >
        <a class="btn btn-default" href="<?php  echo webUrl('member.card')?>">返回</a>
        <input type="submit" value="提交" class="btn btn-primary"/>
    </div>
    </form>
</div>
<script type="text/javascript" src="../addons/ewei_shopv2/static/js/app/biz/sale/wxcard/colorpalette.js" charset="utf-8"></script>

<script>
    <?php  if(!empty($card)&&  !empty($card['card_backgroundtype']) &&!empty($card['card_backgroundimg'])) { ?>
        $(".logo-area").css({
            "background":"url('<?php  echo $card['card_backgroundimg'];?>') no-repeat left top",
            "background-size":"100% 100%",
        });
    <?php  } ?>

    <?php  if(!empty($card)&&  empty($card['card_backgroundtype'])) { ?>
        $(".logo-area").css({
            "background":"<?php  echo $card['color2'];?>"
        });
    <?php  } ?>


  $('#colorpalette3').colorPalette()
          .on('selectColor', function (e) {
              $('#selected-color2 i').css('background-color', e.color);
              $(".btn-color-down").hide();
              $(".logo-area").css({
                  "background":e.color
              });

              $('#color2').val(e.color);
          });

  $(".btn-color-drop").off("click").on("click", function () {
      if ($(".btn-color-down").css("display") == "block") {
          $(".btn-color-down").hide();
      } else {
          $(".btn-color-down").show();
      }
  })

  require(['jquery', 'util'], function ($, util) {
      //示例图logo控制
      $('#uploadlogo').click(function () {
          util.image('', function (data) {
              $("#showlogo").attr('src', data.url);
              $("#showlogo").show();
              $("#card_logoimg").val(data.url);
              $("#card_logolocalpath").val(data.attachment);

              $("#logoimg").attr('src', data.url);

          });
      });

      //示例图封面图片控制
      $('#uploadbackground').click(function () {
          util.image('', function (data) {
              $("#showbackground").attr('src', data.url);
              $("#showbackground").show();
              $("#card_backgroundimg").val(data.url);
              $("#card_backgroundimg_localpath").val(data.attachment);


              $(".logo-area").css({
                  "background":"url("+data.url+") no-repeat left top",
                  "background-size":"100% 100%",
              });

          });
      });

      //示例图自定义入口1文本控制
      $('#custom_cell1_name').change(function(){

          var str = $(this).val();

          if(str=="")
          {
              str="自定义入口1(选填)";
          }

          $('#show_custom_cell1_name').html(str);
      });
      //示例图自定义入口1引导文本控制
      $('#custom_cell1_tips').change(function(){
          $('#show_custom_cell1_tips').html($(this).val());
      });
      //示例图自定义入口1引导文本控制
      $('#card_title').change(function(){
          $('#title').html($(this).val());
      });

      //示例图自定义入口1引导文本控制
      $('#card_brand_name').change(function(){
          $('#brandname').html($(this).val());
      });



  });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

