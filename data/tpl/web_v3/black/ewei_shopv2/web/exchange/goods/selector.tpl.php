<?php defined('IN_IA') or exit('Access Denied');?><table class="table">

    <thead>

    <tr>

        <td>商品</td>

        <td style="width:100px;text-align: center;">商品价格</td>

        <td style="width:100px;text-align: center;">兑换库存</td>

        <th style="width:100px;text-align: center;">操作</th>

    </tr>

    </thead>





    <tbody id="param-items" class="ui-sortable">

    <?php  if(is_array($res)) { foreach($res as $k => $v) { ?>

    <tr>

        <td>

            <img src="<?php  echo tomedia($v['thumb']);?>" style="width:30px;height:30px;padding1px;border:1px solid #ccc"><?php  echo $v['title'];?></td>

        <td style="text-align: right;">¥<?php  echo $v['marketprice'];?></td>

        <td style="text-align: right;"><?php  echo $v['total'];?></td>

        <td style="text-align: center;">

            <a href="javascript:;" class="label label-primary select" gtitle="<?php  echo $v['title'];?>" gthumb="<?php  echo tomedia($v['thumb']);?>" dataid="<?php  echo $v['id'];?>" <?php  if($v['hasoption']==1) { ?>type="has_checkbox[]"<?php  } else { ?>type="no_checkbox[]"<?php  } ?> gtype="<?php  echo $v['hasoption'];?>">选择</a>

        </td>

    </tr>

    <?php  } } ?>

    </tbody>

</table>



<script>

    $(document).ready(function () {

        $(".select").click(function () {//商品选择器

            var dataid = $(this).attr('dataid');

            var condition = "tr[data-id='"+dataid+"']";

            var exsit = $(condition).length;

            var link = "<?php  echo webUrl('exchange/goods/optionset',array('groupid'=>$id));?>&id="+$(this).attr('dataid')+"&gtype="+$(this).attr('gtype');

            var input = '';

            if ($(this).attr('gtype') != '1'){

                input = '<input type="hidden" name="no_checkbox[]" value="'+$(this).attr('dataid')+'">';

            }

            if(exsit<1){

                var content = '<tr class="multi-product-item" data-id="'+$(this).attr('dataid')+'" data-name="goodsid">' +input+

                        '<td style="width:80px;">' +

                        '<img src="'+$(this).attr('gthumb')+'" style="width:70px;border:1px solid #ccc;padding:1px"></td>' +

                        '<td style="width:220px;">'+$(this).attr('gtitle')+'</td>' +

                        '<td><a class="btn btn-default btn-sm" data-toggle="ajaxModal" href="'+link+'" id="optiontitle5115">设置</a></td>' +

                        '<td><a href="javascript:void(0);" class="btn btn-default btn-sm" title="删除" data-id="'+$(this).attr('dataid')+'" onclick="biz.selector_new.remove(this,\'goodsid\')">' +

                        '<i class="fa fa-times"></i></a></td></tr>';

                $(".tablet").append(content);

            }

        });

    });

</script>

