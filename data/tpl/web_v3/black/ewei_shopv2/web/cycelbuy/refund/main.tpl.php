<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: none;
        border-top: 1px solid #efefef;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary">审核修改地址 </span>
</div>
<div class="page-content">
    <form action="" method="get">
        <div class="page-content" style="display: block;">
            <div class="main">
                <div class="page-toolbar m-b-sm m-t-sm">
                    <input type="hidden" name="c" value="site">
                    <input type="hidden" name="a" value="entry">
                    <input type="hidden" name="m" value="ewei_shopv2">
                    <input type="hidden" name="do" value="web">
                    <input type="hidden" name="r" value="cycelbuy.refund.main">
                    <div class="col-sm-6 pull-right">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" name="keyword" value="<?php  echo $keyword;?>" placeholder="请输入订单编号">
                            <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit" id="so"> 搜索</button>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="panel-default">
                    <div class="panel-body table-responsive" style="padding:0;">
                        <?php  if(count($record)>0) { ?>
                        <form action="" method="post">
                            <table class="table table-hover ">
                                <thead class="navbar-inner">
                                <tr>
                                    <th style="width:20%; text-align: center;">订单编号</th>
                                    <th style="width:10%;text-align: center;">姓名</th>
                                    <th style="width:10%;text-align: center;">手机号</th>
                                    <th style="width:15%;text-align: center;">地区</th>
                                    <th style="width:20%;text-align: center;">详细地址</th>
                                    <th style="width:10%;text-align: center;">申请时间</th>
                                    <th style="width:8%;text-align: center;">状态</th>
                                    <th style="width:7%;text-align: center;">操作</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                <?php  if(is_array($record)) { foreach($record as $key => $value) { ?>
                                <tr>
                                    <td><?php  echo $value['ordersn'];?></td>
                                    <td><?php  echo $value['data']['realname'];?></td>
                                    <td><?php  echo $value['data']['mobile'];?></td>
                                    <td><?php  echo $value['data']['areas'];?></td>
                                    <td><?php  echo $value['data']['address'];?></td>
                                    <td><?php  echo date('Y-m-d H:i',$value['createtime']);?></td>
                                    <td>
                                        <?php  if($value['ispass'] == 1) { ?>
                                        通过
                                        <?php  } else if($value['ispass'] == 2) { ?>
                                        不通过
                                        <?php  } else { ?>
                                        等待商家审核
                                        <?php  } ?>
                                    </td>
                                    <td>
                                        <a href="<?php  echo webUrl('cycelbuy/refund/detail',array('id'=>$value['id']))?>" class="text-primary">查看详情</a>
                                    </td>
                                </tr>
                                <?php  } } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8" style="text-align: right"><?php  echo $pager;?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </form>
                        <div style="text-align:right;width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php  } else { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">暂时没有任何申请记录</div>
    </div>
    <?php  } ?>
</div>
<script>
        function pass( id , type ){
            if( type == 2 ){
                var content = $( '#content' ).val();
                if( content.length <= 0 ){
                    tip.msgbox.err( '请填写回复内容' );
                    return;
                }
            }

            $.post( "<?php  echo webUrl('cycelbuy/refund/save')?>",{id:id,content:content,type:type},function( msg ){
                msg = JSON.parse( msg );
                if( msg.status == 1 ){
                    window.location.reload();
                }else{
                    tip.msgbox.err( msg.result.message );
                    return;
                }
            });

        }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>