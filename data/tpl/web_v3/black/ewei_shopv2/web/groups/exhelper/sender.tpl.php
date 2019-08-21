<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary">拼团快递助手</span>
</div>
<div class="page-content">
	<div class="tabs-container">
		<div class="tab-content ">
			<div class="tab-pane active" id="tab_sender">
				<form action="./index.php" method="get" class="form-horizontal" plugins="form">
					<input type="hidden" name="c" value="site" />
					<input type="hidden" name="a" value="entry" />
					<input type="hidden" name="m" value="ewei_shopv2" />
					<input type="hidden" name="do" value="web" />
					<input type="hidden" name="r" value="groups.exhelper.sender" />
					<input type="hidden" name="tab" value="sender" />
					<div class="page-toolbar m-b-sm m-t-sm">
						<div class="col-sm-6">
							<span class=''>
								<?php if(cv('exhelper.sender.add')) { ?>
									<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('groups/exhelper/senderadd')?>"><i class='fa fa-plus'></i> 添加模板</a>
								<?php  } ?>
							</span>
						</div>

						<div class="col-sm-6 pull-right">
							<div class="input-group">
								<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="输入发件人/发件人电话/发件人签名/发件邮编/发件城市/发件地址进行搜索"> <span class="input-group-btn">
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
							<?php if(cv('exhelper.sender.delete')) { ?>
							<a class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('groups/exhelper/senderdelete')?>">
								<i class='icow icow-shanchu1'></i> 删除</a>
							<?php  } ?>
						</div>
					</div>
					<table class="table table-hover table-responsive">
						<thead>
							<tr>
								<th style="width:25px;">

								</th>
								<th style="">发件人</th>
								<th style="">发件人电话</th>
								<th style="">发件人签名</th>
								<th style="">发件地邮编</th>
								<th style="">发件城市</th>
								<th>发件地址</th>
								<th style="width:50px;">默认</th>
								<th style="width:95px;">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php  if(is_array($list)) { foreach($list as $row) { ?>
								<tr>
									<td>
										<input type='checkbox' value="<?php  echo $row['id'];?>" />
									</td>
									<td><?php  if(!empty($row['sendername'])) { ?><?php  echo $row['sendername'];?><?php  } else { ?>-<?php  } ?></td>
									<td><?php  if(!empty($row['sendertel'])) { ?><?php  echo $row['sendertel'];?><?php  } else { ?>-<?php  } ?></td>
									<td><?php  if(!empty($row['sendersign'])) { ?><?php  echo $row['sendersign'];?><?php  } else { ?>-<?php  } ?></td>
									<td><?php  if(!empty($row['sendercode'])) { ?><?php  echo $row['sendercode'];?><?php  } else { ?>-<?php  } ?></td>
									<td><?php  if(!empty($row['sendercity'])) { ?><?php  echo $row['sendercity'];?><?php  } else { ?>-<?php  } ?></td>
									<td><?php  if(!empty($row['senderaddress'])) { ?><?php  echo $row['senderaddress'];?><?php  } else { ?>-<?php  } ?></td>
									<td>
										<span class='defaults label <?php  if($row['isdefault']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
										  <?php if(cv('exhelper.sender.setdefault')) { ?>
											  data-toggle='ajaxSwitch'
											  data-confirm = "确认<?php  if($row['isdefault']==1) { ?>取消<?php  } else { ?>设为<?php  } ?>默认吗？"
											  data-switch-css='.defaults'
											  data-switch-other = 'true'
											  data-switch-value='<?php  echo $row['isdefault'];?>'
											  data-switch-value0='0|否|label label-default|<?php  echo webUrl('groups/exhelper/sendersetdefault',array('isdefault'=>1,'id'=>$row['id']))?>'
											  data-switch-value1='1|是|label label-success|<?php  echo webUrl('groups/exhelper/sendersetdefault',array('isdefault'=>0,'id'=>$row['id']))?>'
											  style="cursor: pointer;"
										  <?php  } ?>
										><?php  if($row['isdefault']==1) { ?>是<?php  } else { ?>否<?php  } ?></span>
									</td>
									<td>
										<?php if(cv('exhelper.sender.view|exhelper.sender.edit')) { ?>
										<a class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('groups/exhelper/senderedit',array('id' => $row['id']));?>" title="">
											<span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('groups.exhelper.senderedit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
												<?php if(cv('groups.exhelper.senderedit')) { ?>
												<i class='icow icow-bianji2'></i>
												<?php  } else { ?>
													<i class='icow icow-chakan-copy'></i>
												<?php  } ?>
										   </span>
										</a> <?php  } ?>
										 <?php if(cv('exhelper.sender.delete')) { ?>
										 <a class='btn btn-default btn-sm btn-op btn-operation'
										data-toggle='ajaxRemove' href="<?php  echo webUrl('groups/exhelper/senderdelete',array('id' => $row['id']));?>" data-confirm="确定要删除该模板吗？">
											  <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
											<i class='icow icow-shanchu1'></i>
									   </span>
										 </a><?php  } ?>
									</td>
								</tr>
							<?php  } } ?>
						</tbody>
						<tfoot>
							<tr>
								<td><input type="checkbox"></td>
								<td colspan="2">
									<div class="btn-group">
										<?php if(cv('exhelper.sender.delete')) { ?>
										<a class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('groups/exhelper/senderdelete')?>">
											<i class='icow icow-shanchu1'></i> 删除</a>
										<?php  } ?>
									</div>
								</td>
								<td colspan="6" class="text-right">
									<?php  echo $pager;?>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
