<?php defined('IN_IA') or exit('Access Denied');?>
<div class="fui-cell-group fui-cell-click">
    <a class="fui-cell external" href="<?php  echo mobileUrl('verifygoods')?>" style="background: <?php  echo $diyitem['style']['titlebg'];?>">
        <div class="fui-cell-icon"><i class="icon icon-list"></i></div>
        <div class="fui-cell-text" style="color: <?php  echo $diyitem['style']['titlecolor'];?>;"><?php  echo $diyitem['params']['title'];?></div>
        <div class="fui-cell-remark" style="color: <?php  echo $diyitem['style']['remarkcolor'];?>;"><?php  echo $diyitem['params']['remark'];?></div>
    </a>
    <?php  if(!empty($diyitem['data'])) { ?>
        <div class="fui-icon-group selecter" style="overflow: scroll; background: <?php  echo $diyitem['style']['background'];?>">
            <ul class="banner-ul <?php  echo $diyitem['params']['style'];?>">
            <?php  if(is_array($diyitem['data'])) { foreach($diyitem['data'] as $verify_item) { ?>
                    <li <?php  if($verify_item['numlimit']) { ?>class="banner-li-blue"<?php  } ?>>
                    <a <?php  if($verify_item['cangetcard']) { ?> href="javascript:;" onclick="addCard2('<?php  echo $verify_item['card_id'];?>','<?php  echo $verify_item['cardcode'];?>')" <?php  } else { ?> href="<?php  echo mobileUrl('verifygoods/detail',array('id'=>$verify_item['id']))?>" <?php  } ?>>
                        <div></div>
                        <span><?php  if($verify_item['cangetcard']) { ?>待激活 <?php  } else { ?>待使用<?php  } ?></span>
                        <img src="<?php  echo $verify_item['thumb'];?>" alt="" style="border-radius: 1.05rem;">
                        <p><?php  echo $verify_item['title'];?></p>
                    </a>
                    </li>
            <?php  } } ?>
            </ul>
        </div>
    <?php  } ?>
</div>

<script  language='javascript'>
    var lis = $('.banner-ul').find('li');
    $('.banner-ul').width(lis.length*8.3+'rem');
    function addCard2(card_id,code) {
        var data = {'openid': '<?php  echo $_W["openid"]?>', 'card_id': card_id, 'code': code};
        $.ajax({
            url: "<?php  echo mobileUrl('sale/coupon/getsignature')?>",
            data: data,
            cache: false
        }).done(function (result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 1) {
                wx.addCard({
                    cardList: [{cardId: card_id, cardExt: data.result.cardExt}],
                    success: function (res) {},
                    cancel: function (res) {}
                });
            } else {
                alert("微信接口繁忙,请稍后再试!");
                alert(data.result.message);
            }
        });
    }
</script>
