<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">
	当前位置：<span class="text-primary">抽奖记录 </span>
</div>

<div class="page-content">
	<form action="./index.php" method="get" class="form-horizontal table-search"  role="form">
		<input type="hidden" name="c" value="site" />
		<input type="hidden" name="a" value="entry" />
		<input type="hidden" name="m" value="ewei_shopv2" />
		<input type="hidden" name="do" value="web" />
		<input type="hidden" name="r"  value="lottery.log" />
		<input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>" />
		<div class="page-toolbar m-b-sm m-t-sm">
			<div class="col-sm-5">
				<div class='input-group input-group-sm'   >
					<?php  echo tpl_daterange('time', array('placeholder'=>'抽奖时间'),true);?>
				</div>
			</div>


			<div class="col-sm-6 pull-right">

				<div class="input-group">
					<input type="text" class=" form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="昵称/姓名/手机号"> <span class="input-group-btn">

						<button class="btn btn-primary" type="submit"> 搜索</button> </span>
				</div>

			</div>
		</div>
	</form>


	<form action="" method="post" onsubmit="return formcheck(this)">

		<?php  if(count($list)>0) { ?>
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>参与人</th>
					<th></th>
					<th>奖励</th>
					<th>参与时间</th>
					<th style="width: 45px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $row) { ?>
				<?php  $row['lottery_data']=unserialize($row['lottery_data']);?>
				<tr>
					<td><span data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'><img src='<?php  echo $row['avatar'];?>' style='width:20px;height:20px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?></span></td>
					<td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>
					<td  data-toggle="tooltip" title="<?php  if(!empty($row['lottery_data'])) { ?><?php  echo $this->model->lottery_complain($row['lottery_data']);?><?php  } else { ?>无奖励<?php  } ?>"> <?php  if(!empty($row['lottery_data'])) { ?><?php  echo mb_substr($this->model->lottery_complain($row['lottery_data']),0,13,'utf-8');?><?php  } else { ?>无奖励<?php  } ?>
					</td>
					<td><?php  echo date('Y-m-d H:i',$row['addtime']);?></td>
					<td>
						<a class='btn btn-default btn-op btn-operation' href="<?php  echo webUrl('lottery/log',array('id'=>$row['lottery_id'],'keyword'=>$row['nickname']));?>" title=''>
							<span data-toggle="tooltip" data-placement="top" title="" data-original-title="此用户抽奖列表">
								<i class='icow icow-dingdan2'></i>
							 </span>
						</a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" class="text-right"><?php  echo $pager;?></td>
				</tr>
			</tfoot>
		</table>
		<?php  } else { ?>
		<div class='panel panel-default'>
			<div class='panel-body' style='text-align: center;padding:30px;'>
				暂时没有任何参与记录!
			</div>
		</div>

		<?php  } ?>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
