<?php defined('IN_IA') or exit('Access Denied');?><?php  if($packages) { ?>
<?php  if(count($packages)<=3) { ?>
<div class="fui-cell-group fui-comment-group" style="background: <?php  echo $diyitem['style']['background'];?>; margin-top: <?php  echo $diyitem['style']['margintop'];?>px; margin-bottom: <?php  echo $diyitem['style']['marginbottom'];?>px;">
    <div class="fui-cell fui-cell-click">
        <div class="fui-cell-text desc" style="color: <?php  echo $diyitem['style']['textcolor'];?>;">相关套餐</div>
        <div class="fui-cell-text desc label" style="color: <?php  echo $diyitem['style']['textcolor'];?>;" onclick="javascript:window.location.href='<?php  echo mobileUrl('goods/package',array('goodsid'=>$package_goods['goodsid']))?>'">更多套餐</div>
        <div class="fui-cell-remark"></div>
    </div>
    <div class="fui-cell">
        <div class="fui-cell-text comment ">
            <div class="fui-list package-list">
                <?php  if(is_array($packages)) { foreach($packages as $item) { ?>
                <div class="fui-list-inner package-goods" onclick="javascript:window.location.href='<?php  echo mobileUrl('goods/package/detail',array('pid'=>$package_goods['pid']))?>'">
                    <img src="<?php  echo tomedia($item['thumb'])?>" class="package-goods-img" alt="<?php  echo $item['title'];?>">
                    <span><?php  echo $item['title'];?></span>
                </div>
                <?php  } } ?>
            </div>
        </div>
    </div>
</div>
<?php  } else { ?>
<div class="fui-cell-group fui-comment-group" style="background: <?php  echo $diyitem['style']['background'];?>; margin-top: <?php  echo $diyitem['style']['margintop'];?>px; margin-bottom: <?php  echo $diyitem['style']['marginbottom'];?>px;">
    <div class="fui-cell fui-cell-click">
        <div class="fui-cell-text desc" style="color: <?php  echo $diyitem['style']['textcolor'];?>;">相关套餐</div>
        <div class="fui-cell-text desc label" style="color: <?php  echo $diyitem['style']['textcolor'];?>;" onclick="javascript:window.location.href='<?php  echo mobileUrl('goods/package',array('goodsid'=>$package_goods['goodsid']))?>'">更多套餐</div>
        <div class="fui-cell-remark"></div>
    </div>
    <div id="product" class="fui-list">
        <span class="prev fui-list-media"><i class="icon icon-left"></i></span>
        <div id="content" class="fui-list-inner">
            <div id="content_list" onclick="javascript:window.location.href='<?php  echo mobileUrl('goods/package/detail',array('pid'=>$package_goods['pid']))?>'">
                <?php  if(is_array($packages)) { foreach($packages as $item) { ?>
                <dl class="package-goods package-goods3">
                    <dt><img class="package-goods-img" src="<?php  echo tomedia($item['thumb'])?>"/></dt>
                    <dd><?php  echo $item['title'];?></dd>
                </dl>
                <?php  } } ?>
            </div>
        </div>
        <span class="next fui-list-media"><i class="icon icon-right1"></i></span>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var page = 1;
        var i = 3; //每版放4个图片
        //向后 按钮
        $("span.next").click(function(){    //绑定click事件
            var content = $("div#content");
            var content_list = $("div#content_list");
            var v_width = content.width();
            var len = content.find("dl").length;
            var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
            if( !content_list.is(":animated") ){    //判断“内容展示区域”是否正在处于动画
                if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
                    content_list.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
                    page = 1;
                }else{
                    content_list.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
                    page++;
                }
            }
        });
        //往前 按钮
        $("span.prev").click(function(){
            var content = $("div#content");
            var content_list = $("div#content_list");
            var v_width = content.width();
            var len = content.find("dl").length;
            var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
            if(!content_list.is(":animated") ){    //判断“内容展示区域”是否正在处于动画
                if(page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
                    content_list.animate({ left : '-='+v_width*(page_count-1) }, "slow");
                    page = page_count;
                }else{
                    content_list.animate({ left : '+='+v_width }, "slow");
                    page--;
                }
            }
        });
    });
</script>
<?php  } ?>
<?php  } ?>
