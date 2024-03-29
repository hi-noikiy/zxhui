<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
    .modal{
        display: none;
        opacity: 1;
        width: 540px;
        height: 260px;
        top:50%;
        left:50%;
        margin-top: -130px;
        margin-left: -270px;
    }
    .modal-body{
        background: #fff;
        justify-content: center;
        -webkit-justify-content: center;
        padding: 0;
    }
    .modal-body .diy-item{
        width:133px;
        margin: 30px 15px;
        text-align: center;
        padding: 25px 0 ;
        border-radius: 4px;
    }
    .modal-body .diy-item p{
        font-weight: bold;
        font-size: 14px;
        color: #666;
    }
    .modal-body .diy-item a{
        color: inherit;
        display: inline-block;
        width:77px;
        height:28px;
        border:1px solid;
        border-color: inherit;
        line-height: 26px;
    }
    .wid{
        width: 76px;
        white-space: nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
    }
    /* .dropdown-menu {
         width: 120px !important;
         background: none; border: none; box-shadow: none; padding: 0;
         left: 60px;
         margin-left: -60px;
     }
     .dropdown-menu li:last-child span {margin: 0}
     .dropdown-menu li {padding-top: 5px; width: 120px;}
     .dropdown-menu li span {background: #fff; width: 100%;}
     .create .fa-caret-up {display: none}
     .create.open .fa-caret-down {display: none}
     .create.open .fa-caret-up {display: inline-block}*/
</style>
<div class="page-header">
    当前位置：<span class="text-primary">购买页面 </span>
</div>
<div class="page-content">
<form action="/index.php">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="quick.pages" />
    <input type="hidden" name="type" value="<?php  echo $type;?>" />
    <div class="page-toolbar m-b-sm m-t-sm">
        <div class="col-sm-4">
            <?php if(mcv('quick.pages.add')) { ?>
            <div class="">
                <a href="JavaScript:;" class="btn btn-primary btn-sm btn-create"><i class="fa fa-plus"></i> 新建页面</a>
            </div>
            <?php  } ?>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group">
                <div class="input-group-select">
                    <select name="status" class='form-control'>
                        <option value="" <?php  if($_GPC['status'] == '') { ?> selected<?php  } ?>>状态</option>
                        <option value="1" <?php  if($_GPC['status']== '1') { ?> selected<?php  } ?>>开启</option>
                        <option value="0" <?php  if($_GPC['status'] == '0') { ?> selected<?php  } ?>>关闭</option>
                    </select>
                </div>
                <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入页面标题关键字进行搜索">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"> 搜索</button>
                </span>
            </div>
        </div>
    </div>
    <ul class="nav nav-arrow-next nav-tabs" id="myTab" >
        <li class="<?php  if($_GPC['type']===null) { ?>active<?php  } ?>" >
            <a href="<?php  echo webUrl('quick/pages')?>">全部</a>
        </li>
        <li class="<?php  if($_GPC['type']==='0') { ?>active<?php  } ?>" >
            <a href="<?php  echo webUrl('quick/pages',array('type'=>0))?>">公众号快速购买页</a>
        </li>
        <li class="<?php  if($_GPC['type']==1) { ?>active<?php  } ?>" >
            <a href="<?php  echo webUrl('quick/pages',array('type'=>1))?>">小程序快速购买页</a>
        </li>
    </ul>
</form>

<?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align: center;padding:30px;">
            未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关页面!
        </div>
    </div>
<?php  } else { ?>
    <div class="page-table-header">
        <input type="checkbox">
        <div class="btn-group">
            <?php if(mcv('quick.pages.delete')) { ?>
            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('quick/pages/delete')?>" disabled="disabled">
                <i class="icow icow-shanchu1"></i> 删除</button>
            <?php  } ?>
        </div>
    </div>
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th style="width:25px;"></th>
            <th>页面标题</th>
            <th >关键字</th>
            <th>创建时间</th>
            <th>最后修改时间</th>
            <th class="text-center">状态</th>
            <th style="width: 110px">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><input type="checkbox" value="<?php  echo $item['id'];?>"></td>
                    <td>
                        <?php  if($_GPC['type']===null && $item['type']==1) { ?>
                            <i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;"></i>
                        <?php  } ?>
                        <?php  echo $item['title'];?></td>
                    <td><?php  if(!empty($item['keyword'])) { ?><?php  echo $item['keyword'];?><?php  } else { ?>未设置<?php  } ?></td>
                    <td><?php  echo date("Y-m-d", $item['createtime'])?><br><?php  echo date("H:i:s", $item['createtime'])?></td>
                    <td><?php  echo date("Y-m-d", $item['lasttime'])?><br><?php  echo date("H:i:s", $item['lasttime'])?></td>
                    <td style="text-align: center;">
                        <span class='label <?php  if($item['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                        <?php if(mcv('quick.pages.edit')) { ?>
                            style="cursor: pointer"
                            data-toggle="ajaxSwitch"
                            data-confirm = "确认<?php  if($item['status']==1) { ?>关闭<?php  } else { ?>开启<?php  } ?>吗？"
                            data-switch-value="<?php  echo $item['status'];?>"
                            data-switch-value0="0|关闭|label label-default|<?php  echo webUrl('quick/pages/status',array('status'=>1,'id'=>$item['id']))?>"
                            data-switch-value1="1|开启|label label-primary|<?php  echo webUrl('quick/pages/status',array('status'=>0,'id'=>$item['id']))?>"
                        <?php  } ?>>
                        <?php  if($item['status']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?>
                        </span>
                    </td>
                    <td>
                        <?php if(mcv('quick.pages.view|quick.pages.edit')) { ?>
                            <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('quick/pages/edit', array('id'=>$item['id'],'type'=>$item['type']))?>">
                                 <span data-toggle="tooltip" data-placement="top" title="" data-original-title=" <?php if(mcv('quick.pages.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                     <?php if(mcv('quick.pages.edit')) { ?>
                                    <i class="icow icow-bianji2"></i>
                                     <?php  } else { ?>
                                     <i class="icow icow-chakan-copy"></i>
                                     <?php  } ?>
                                 </span>
                            </a>
                        <?php  } ?>
                        <?php if(mcv('quick.pages.delete')) { ?>
                            <a class="btn btn-default btn-sm btn-op btn-operation" href="<?php  echo webUrl('quick/pages/delete', array('id'=>$item['id'],'type'=>$item['type']))?>" data-toggle='ajaxRemove' data-confirm="删除后不可恢复！确认删除吗？">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                        <i class='icow icow-shanchu1'></i>
                                   </span>
                            </a>
                        <?php  } ?>
                        <?php  if($item['type']!=1) { ?>
                        <a class="btn btn-default btn-sm js-clip btn-op btn-operation" title="复制链接" data-href="<?php  echo mobileUrl('quick', array('id'=>$item['id'],'type'=>$item['type']), true)?>">
                            <span data-toggle="tooltip" data-placement="top"  data-original-title="复制链接">
                                       <i class='icow icow-lianjie2'></i>
                                   </span>
                        </a>

                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-op btn-operation" data-toggle="popover" data-trigger="hover" data-html="true"
                           data-content="<img src='<?php  echo $item['qrcode'];?>' width='130' alt='链接二维码'>" data-placement="auto right">
                            <i class="icow icow-erweima3"></i>
                        </a>
                        <?php  } ?>
                    </td>
                </tr>
            <?php  } } ?>
        </tbody>
        <tfoot>
            <tr>
                <td><input type="checkbox"></td>
                <td colspan="2">
                    <div class="btn-group">
                        <?php if(mcv('quick.pages.delete')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('quick/pages/delete')?>" disabled="disabled">
                            <i class="icow icow-shanchu1"></i> 删除</button>
                        <?php  } ?>
                    </div>
                </td>
                <td colspan="4" class="text-right"><?php  echo $pager;?></td>
            </tr>
        </tfoot>
    </table>
<?php  } ?>
</div>
<div class="modal fade" id="selectUrl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:325px">
    <div class="modal-header">
        选择类型
        <button data-dismiss="modal" class="close" type="button" aria-label="Close">×</button>
    </div>
    <div class="modal-body" style="padding-bottom: 40px;">
        <div class="flex" style="margin: 0 auto;width:334px;">
        <div data-type="1" class="diy-item active" style="background: #f5f5f9;color: #7ecf6b;width:132px;height: 137px;position: relative;">
            <icon class="iconfont icon-xiaochengxu"></icon>
            <p style="position: absolute;bottom: 0;left:0;text-align: center;background:#fff;width: 100%;line-height: 40px;margin:0">小程序页面</p>
        </div>
        <div data-type="0" class="diy-item" style="background: #f5f5f9;color: #ff5555;width:132px;height: 137px;position: relative;">
            <icon class="iconfont icon-weixin" style="font-size: 44px;"></icon>
            <p style="position: absolute;bottom: 0;left:0;text-align: center;background:#fff;width: 100%;line-height: 40px;margin:0">公众号页面</p>
        </div>
        </div>
        <div style="width: 120px;height: 37px;text-align: center;color: #fff;background:#5eaef8;margin:0 auto;line-height:37px;cursor:pointer" id="submittype">确定</div>
    </div>
</div>
<style>

    @font-face {font-family: "iconfont";
        src: url('iconfont.eot?t=1524798092805'); /* IE9*/
        src: url('iconfont.eot?t=1524798092805#iefix') format('embedded-opentype'), /* IE6-IE8 */
        url('data:application/x-font-woff;charset=utf-8;base64,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') format('woff'),
        url('iconfont.ttf?t=1524798092805') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
        url('iconfont.svg?t=1524798092805#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
        font-family:"iconfont" !important;
        font-size:16px;
        font-style:normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .icon-weixin:before { content: "\e61f"; }

    .icon-xiaochengxu:before { content: "\e632"; }


    .diy-item {
        border: 1px solid #f5f5f9
    }
    .diy-item.active {
        border: 1px solid #5eaef8;
    }
    .diy-item.active p,.diy-item.active icon {
        color: #5eaef8;
    }

    .diy-item icon {
        font-size: 40px;
        color: #c8cfdf;
    }

</style>

<script>
    $(".btn-create").off("click").on("click",function () {
        $('#selectUrl').modal()
    });
    var types = 1;
    $(".diy-item").on("click",function(){
        $(".diy-item").removeClass("active");
        $(this).addClass("active");
        types = $(this).attr("data-type");
    });
    $("#submittype").on("click",function(){
        if(types ==1) {
            window.location.href = "<?php  echo webUrl('quick/pages/add',array('type'=>1))?>";
        }else{
            window.location.href = "<?php  echo webUrl('quick/pages/add',array('type'=>0))?>";
        }
    });

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>