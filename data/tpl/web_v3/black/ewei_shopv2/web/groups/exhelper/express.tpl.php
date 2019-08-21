<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span>拼团快递助手</span>
</div>
<div class="page-content">
	<div class="tabs-container">
		<div class="tab-content ">
			<div class="tab-pane active" id="tab_express">
			<form action="./index.php" method="get" class="form-horizontal" plugins="form">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="m" value="ewei_shopv2" />
				<input type="hidden" name="do" value="web" />
				<input type="hidden" name="r" value="groups.exhelper.express" />
				<input type="hidden" name="tab" value="express" />
				<div class="page-toolbar  m-b-sm m-t-sm">
					<span class=''>
						<?php if(cv('exhelper.temp.express.add')) { ?>
						<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('groups/exhelper/expressadd')?>"><i class='fa fa-plus'></i> 添加模板</a>
						<?php  } ?>
					</span>
					<div class="col-sm-6 pull-right">
						<div class="input-group">
							<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="输入快递单模版名称进行搜索"> <span class="input-group-btn">
								<button class="btn btn-primary" type="submit"> 搜索</button> </span>
						</div>
					</div>
				</div>
			</form>
				<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('groups/exhelper/tabs', TEMPLATE_INCLUDEPATH)) : (include template('groups/exhelper/tabs', TEMPLATE_INCLUDEPATH));?>
			<form action="" method="post">
				<div class="page-table-header">
					<input type="checkbox">
					<div class="btn-group">
						<?php if(cv('exhelper.temp.express.delete')) { ?>
						<a class="btn btn-default btn-sm  btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('groups/exhelper/expressdelete')?>">
							<i class='icow icow-shanchu1'></i> 删除
						</a>
						<?php  } ?>
					</div>
				</div>
				<table class="table table-hover table-responsive">
					<thead>
						<tr>
							<th style="width:25px;">
								<input type='checkbox' />
							</th>
							<th><?php  if($type==1) { ?>快递单<?php  } else if($type==2) { ?>发货单<?php  } ?>模版名称</th>
							<th>快递公司</th>
							<th style="">默认</th>
							<th style="width:65px;">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if(is_array($list)) { foreach($list as $row) { ?>
							<tr>
								<td>
									<input type='checkbox' value="<?php  echo $row['id'];?>" />
								</td>
								<td><?php  if(!empty($row['expressname'])) { ?><?php  echo $row['expressname'];?><?php  } else { ?>未填写<?php  } ?></td>
								<td >
									<span style="text-align: center" class="text-success"><?php  echo $row['expresscom'];?></span>
								</td>
								<td>
									<span class='defaults label <?php  if($row['isdefault']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
									  <?php if(cv('exhelper.temp.express.setdefault')) { ?>
									<?php  if($row['isdefault']==0) { ?>
										  data-toggle='ajaxSwitch'
										  data-confirm = "确认<?php  if($row['isdefault']==1) { ?>取消<?php  } else { ?>设为<?php  } ?>默认吗？"
										  data-switch-css='.defaults'
										  data-switch-other = 'true'
										  data-switch-value='<?php  echo $row['isdefault'];?>'
										  data-switch-value0='0|否|label label-default|<?php  echo webUrl('groups/exhelper/expresssetdefault',array('isdefault'=>1, 'id'=>$row['id'], 'type'=>$type))?>'
										  data-switch-value1='1|是|label label-primary|<?php  echo webUrl('groups/exhelper/expresssetdefault',array('isdefault'=>0, 'id'=>$row['id'], 'type'=>$type))?>'
										  style="cursor: pointer;"
									  <?php  } ?>
									<?php  } ?>
									><?php  if($row['isdefault']==1) { ?>是<?php  } else { ?>否<?php  } ?></span>
								</td>
								<td>
									<?php if(cv('exhelper.temp.express.edit')) { ?>
									<a class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('groups/exhelper/expressedit',array('id' => $row['id']));?>">
										<span data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑">
											<i class='icow icow-bianji2'></i>
									   </span>
									</a>
									<?php  } ?>
									 <?php if(cv('exhelper.temp.express.delete')) { ?>
									 <a class='btn btn-default btn-sm btn-op btn-operation'
									data-toggle='ajaxRemove' href="<?php  echo webUrl('groups/exhelper/expressdelete',array('id' => $row['id']));?>" data-confirm="确定要删除该模板吗？">
										 <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
											<i class='icow icow-shanchu1'></i>
									   </span>
									 </a>
									<?php  } ?>
								</td>
							</tr>
						<?php  } } ?>
					</tbody>
					<tfoot>
						<tr>
							<td><input type="checkbox"></td>
							<td>
								<div class="btn-group">
									<?php if(cv('exhelper.temp.express.delete')) { ?>
									<a class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('groups/exhelper/expressdelete')?>">
										<i class='icow icow-shanchu1'></i> 删除
									</a>
									<?php  } ?>
								</div>
							</td>
							<td colspan="3" class="text-right"><?php  echo $pager;?></td>
						</tr>
					</tfoot>
				</table>
			</form>
		</div>
	</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
