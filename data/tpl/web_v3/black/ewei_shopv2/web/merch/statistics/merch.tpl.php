<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">
    当前位置：<span class="text-primary">商户统计</span>
</div>
<div class="page-content">
      <form action="./index.php" method="get" class="form-horizontal table-search" role="form">
                    <input type="hidden" name="c" value="site" />
                    <input type="hidden" name="a" value="entry" />
                    <input type="hidden" name="m" value="ewei_shopv2" />
                    <input type="hidden" name="do" value="web" />
                    <input type="hidden" name="r" value="merch.statistics.merch" />
          <div class="page-toolbar row m-b-sm m-t-sm">
              <div class="col-sm-5">
                  <?php  echo tpl_daterange('datetime', array('sm'=>true,'placeholder'=>'按订单时间查询'),true);?>
              </div>
              <div class="col-sm-6 pull-right">
                  <div class="input-group">
                      <div class="input-group-select">
                          <select name='groupname'  class='form-control  input-sm select-md'   style="width:120px;">
                              <option value='' <?php  if($_GPC['groupname']=='') { ?>selected<?php  } ?>>商户组</option>
                              <?php  if(is_array($groups)) { foreach($groups as $key => $val) { ?>
                              <option value='<?php  echo $val['id'];?>' <?php  if($_GPC['groupname']==$val['id']) { ?>selected<?php  } ?>><?php  echo $val['groupname'];?></option>
                              <?php  } } ?>
                          </select>
                      </div>
                      <input type="text" class="form-control input-sm" name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder="可搜索商户名称/姓名/手机号"/>
                     <span class="input-group-btn">
                         <button class="btn btn-primary" type="submit"> 搜索</button>
                         <?php if(cv('merch.statistics.merch.export')) { ?>
                         <button type="submit" name="export" value="1" class="btn btn-success">导出</button>
                         <?php  } ?>
                    </span>
                  </div>

              </div>
          </div>
      </form>
        <?php  if(count($list)>0) { ?>
            <table class="table table-hover table-responsive">
                <thead class="navbar-inner">
                    <tr>
                        <!--<th style="width:25px;"><input type='checkbox' /></th>-->
                        <th style="width:150px;">商城信息</th>
                        <th style="width:120px;">商户信息</th>
                        <th style="width:100px;">订单应收</th>
                        <th style="width:100px;">订单抵扣</th>
                        <th style="width:100px;">订单会员折扣</th>
                        <th style="width:100px;">订单促销</th>
                        <th style="width:100px;">订单实收</th>
                        <!--th style="width:70px;">操作</th-->
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <!--<td style="position: relative; "><input type='checkbox'   value="<?php  echo $row['id'];?>"/></td>-->
                        <td  >
                        <div  >
                            <?php  if(!empty($row['logo'])) { ?>
                             <img src='<?php  echo tomedia($row['logo'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                           <?php  } ?>
                            <?php  echo $row['merchname'];?>
                            </div>
                        </td>
                        <td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>

                        <td><?php  echo $row['goodsprice']+$row['dispatchprice']?></td>
                        <td>积分：<span class="text-primary"><?php  echo floatval($row['deductprice'])?></span><br/>
                            余额：<span class="text-warning"><?php  echo floatval($row['deductcredit2'])?></span>
                        </td>
                        <td><?php  echo $row['discountprice'];?></td>
                        <td><?php  echo $row['isdiscountprice'];?></td>
                        <td><?php  echo $row['price'];?></td>
                        <!--<td style="overflow:visible;">-->
                            <!--div class="btn-group btn-group-sm">
                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu" style='z-index: 9999'>
                                    <li><a href="<?php  echo webUrl('merch/clearing/add',array('merchid' => $row['id'],'datetime[start]'=>$_GPC['datetime']['start'],'datetime[end]'=>$_GPC['datetime']['end']));?>" title="生成结算单"><i class='fa fa-edit'></i> 生成结算单</a></li>
                                </ul>
                            </div-->
                        <!--</td>-->
                    </tr>
                    <?php  } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-right">
                            <?php  echo $pager;?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <?php  } else { ?>
        <div class='panel panel-default'>
            <div class='panel-body' style='text-align: center;padding:30px;'>
                暂时没有任何商户!
            </div>
        </div>
        <?php  } ?>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
