<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">数据统计</div>
       
    </div>
    <!--顶部tab-->
    <div id="tab" class="fui-tab fui-tab-success fixed">
        <a data-tab="tab" class="external active" data-status="sale">销售统计</a>
        <a data-tab="tab0" class="external " data-status="sale_analysis">销售指标</a>
    </div>
    <div class='fui-content navbar'>
        <div class='content-empty' style='display:none;'>
            <i class='icon icon-manageorder'></i><br/>暂时没有任何数据
        </div>
        <div class="fui-list-group" id="container"></div>
        <!--销售统计-->
        <script id='tpl_sale_list' type='text/html'>
            <div class="fui-tab-o fui-tab-success auto">
                <a <%if type == 0%> class="active" <%/if%> data-type="0">交易额</a>
                <a <%if type == 1%> class="active" <%/if%> data-type="1">交易量</a>
            </div>
            <div class="fui-panel" style="font-size:0.65rem;">
                <div class="fui-panel-header">
                    <%if type == 0%>
                        交易额
                    <%else%>
                        交易量
                    <%/if%>

                    ：<span style="color:red; "><%totalcount%></span>，
                    最高
                    <%if type == 0%>
                        交易额
                    <%else%>
                        交易量
                    <%/if%>
                    <span style="color:red; "><%maxcount%></span> 
                    <%if maxcount_date%>
                        <span>(<%maxcount_date%>)</span>
                    <%/if%>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th style='width:33%;'>
                                    日期
                                </th>
                                <th style='width:33%;'><%if type == 0%>交易额<%else%>交易量<%/if%></th>
                                <th>比例</th>
                            </tr>
                        </thead>
                        <tbody>
                            <%each list as row%>
                            <tr>
                                <td style="text-align:center;"><%row.data%> <?php  echo $row['data'];?></td>
                                <td style="text-align:center;"><%row.count%><?php  echo $row['count'];?></td>
                                <td style="text-align:center;">
                                    <%if row.percent %>
                                        <%row.percent%>%
                                    <%/if%>
                                </td>
                            </tr>
                            
                            <%/each%>
                        </tbody>
                    </table>   
                </div>
            </div>
        </script>
        <!--销售指标-->

        <div class="sale_analysis" style="display:none">
            <style type="text/css">
                .sale_analysis_html th,.sale_analysis_html td {
                    width: 33%;
                    text-align: center;
                    font-weight: normal;
                    font-size: 0.65rem;
                }
                .sale_analysis_html {
                    padding: 0.5rem;
                }
            </style>
            <div class='panel-body sale_analysis_html'>
                <div class="form-group">
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <table class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th >订单总金额</th>
                                    <th >总会员数</th>
                                    <th>会员消费率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php  echo $orderprice;?></td>
                                    <td><?php  echo $member_count;?></td>
                                    <td><?php $percent=round( $orderprice/($member_count==0?1:$member_count),2);?>
                                        <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                       <?php echo empty($percent)?'':$percent.'%'?>
                                       
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <table class="table table-hover"  style="width:100%">
                            <thead>
                                <tr>
                                    <th >订单总金额</th>
                                    <th>总访问次数</th>
                                    <th>访问转化率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php  echo $orderprice;?></td>
                                    <td><?php  echo $viewcount;?></td>
                                   <td><?php $percent=round( $orderprice/($viewcount==0?1:$viewcount),2);?>
                                        <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                      <?php echo empty($percent)?'':$percent.'%'?>
                                       
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
         
                <div class="form-group">
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <table class="table table-hover"  style="width:100%">
                            <thead>
                                <tr>
                                    <th >总订单数</th>
                                    <th >总访问次数</th>
                                    <th>订单转化率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php  echo $ordercount;?></td>
                                    <td><?php  echo $viewcount;?></td>
                                   <td><?php $percent=round( $ordercount/($viewcount==0?1:$viewcount),2);?>
                                        <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                        <?php echo empty($percent)?'':$percent.'%'?>
                                       
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <table class="table table-hover" style="width:100%" >
                            <thead>
                                <tr>
                                    <th >消费会员数</th>
                                    <th >总会员数</th>
                                    <th>会员消费率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php  echo $member_buycount;?></td>
                                    <td><?php  echo $member_count;?></td>
                                    <td><?php $percent=round( $member_buycount/($member_count==0?1:$member_count),2);?>
                                        <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                        <?php echo empty($percent)?'':$percent.'%'?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-lg-9 col-xs-12">
                        <table class="table table-hover"  style="width:100%">
                            <thead>
                                <tr>
                                    <th >总订单数</th>
                                    <th >总会员数</th>
                                    <th>订单购买率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php  echo $ordercount;?></td>
                                    <td><?php  echo $member_count;?></td>
                                    <td><?php $percent=round( $ordercount/($member_count==0?1:$member_count),2);?>
                                        <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                       <?php echo empty($percent)?'':$percent.'%'?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        

    <script type="text/javascript" src="../addons/ewei_shopv2/plugin/merchmanage/static/js/init.js?v=<?php  echo time()?>"></script>
    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/merchmanage/static/js/statistics.js'],function(modal){
            modal.init();
        });
    </script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/_menu', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/_menu', TEMPLATE_INCLUDEPATH));?>