<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header"> 当前位置：<span class="text-primary">拼团快递助手</span></div>
<div class="page-content">
<div class="tabs-container">
	<div class="tab-content ">
		<div class="tab-pane active" id="tab_printset">
			<form action="" method="get" class="form-horizontal" plugins="form">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="m" value="ewei_shopv2" />
				<input type="hidden" name="do" value="web" />
				<input type="hidden" name="r" value="groups.exhelper.short" />
				<input type="hidden" name="tab" value="short" />
				<div class="page-toolbar m-b-sm m-t-sm">
					<div class="col-sm-6 pull-right">
						<div class="input-group">
							<div class="input-group-select">
								<select name='status' class='form-control input-sm' style='width:100px;'>
									<option value='' <?php  if($_GPC[ 'status']=='' ) { ?>selected<?php  } ?>>全部状态</option>
									<option value='1' <?php  if($_GPC[ 'status']=='1' ) { ?>selected<?php  } ?>>上架</option>
									<option value='0' <?php  if($_GPC[ 'status']=='0' ) { ?>selected<?php  } ?>>下架</option>
								</select>
							</div>
							<div class="input-group-select">
								<select name='shorttitle' class='form-control  input-sm' style='width:100px;'>
									<option value='' <?php  if($_GPC[ 'shorttitle']=='' ) { ?>selected<?php  } ?>>全部简称</option>
									<option value='1' <?php  if($_GPC[ 'shorttitle']=='1' ) { ?>selected<?php  } ?>>已填写</option>
									<option value='2' <?php  if($_GPC[ 'shorttitle']=='2' ) { ?>selected<?php  } ?>>未填写</option>
								</select>
							</div>
							<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">
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
						<?php if(cv('exhelper.short.edit')) { ?>
						<a class="btn btn-default btn-sm btn-op btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('groups/exhelper/shortedit')?>">
							<i class='fa fa-circle-o'></i> 清空简称
						</a>
						<?php  } ?>
					</div>
				</div>
				<table class="table table-hover table-responsive">
					<thead>
					<tr>
						<th style="width:25px;">

						</th>
						<th>商品标题</th>
						<th >商品简称<?php if(cv('exhelper.short.edit')) { ?><small>(点击编辑)</small><?php  } ?></th>
						<th style="width:60px;">状态</th>
					</tr>
					</thead>
					<tbody>
					<?php  if(is_array($list)) { foreach($list as $row) { ?>
					<td>
						<input type='checkbox' value="<?php  echo $row['id'];?>" />
					</td>
					<td>
						<?php  echo $row['title'];?>
					</td>
					<td>
						<?php if(cv('exhelper.short.edit')) { ?>
						<a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('groups/exhelper/shortedit',array('id'=>$row['id']))?>">
							<?php  if(empty($row['shorttitle'])) { ?>未填写<?php  } else { ?><?php  echo $row['shorttitle'];?><?php  } ?>
						</a>
						<?php  } else { ?>
						<?php  echo $row['shorttitle'];?>
						<?php  } ?>
					</td>

					<td>
						<?php  if($row['status']>0) { ?>
						<span class='label label-primary'>上架</span>
						<?php  } else { ?>
						<span class='label label-default'>下架</span>
						<?php  } ?>
					</td>

					</tr>
					<?php  } } ?>
					</tbody>
					<tfoot>
						<tr>
							<td><input type="checkbox"></td>
							<td>
								<?php if(cv('exhelper.short.edit')) { ?>
								<a class="btn btn-default btn-sm btn-op btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('groups/exhelper/shortedit')?>">
									<i class='fa fa-circle-o'></i> 清空简称
								</a>
								<?php  } ?>
							</td>
							<td colspan="2" class="text-right"><?php  echo $pager;?></td>
						</tr>
					</tfoot>
				</table>
			</form>


		</div>
	</div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
