<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('founder/header', TEMPLATE_INCLUDEPATH)) : (include template('founder/header', TEMPLATE_INCLUDEPATH));?>
<div class="keyword-list-head clearfix we7-margin-bottom">
	<form action="" method="get">
		<input type="hidden" name="c" value="founder">
		<input type="hidden" name="a" value="display">
		<label for="" class="col-sm-1 control-label">副创始人组</label>
		<div class="input-controls col-sm-3">
			<select name="groupid" class="we7-select form-control">
				<option value="" selected="selected">不限</option>
				<?php  if(is_array($founder_groups)) { foreach($founder_groups as $group) { ?>
				<option value="<?php  echo $group['id'];?>"<?php  if($group['id'] == $_GPC['groupid']) { ?> selected="selected"<?php  } ?>><?php  echo $group['name'];?></option>
				<?php  } } ?>
			</select>
		</div>
		<div class="input-group pull-left col-sm-4">
			<input type="text" name="search" id="" value="<?php  echo $_GPC['search'];?>" class="form-control"  placeholder="搜索副创始人或手机号" />
			<span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
		</div>
	</form>
	<div class="pull-right">
		<a href="<?php  echo url('founder/create')?>" class="btn btn-primary">+添加副创始人</a>
	</div>
</div>
<table class="table we7-table table-hover table-manage vertical-middle" id="js-users-display" ng-controller="UsersDisplay" ng-cloak>
	<col width="150px"/>
	<col width="150px">
	<col width="170px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="180px"/>
	<col width="180px"/>
	<col width="150px"/>
	<tr>
		<th></th>
		<th class="text-left">用户名</th>
		<th>用户权限组</th>
		<th>公众号</th>
		<th>小程序</th>
		<th>pc</th>
		<th>APP</th>
		<th>熊掌号</th>
		<th>注册时间</th>
		<th>到期时间</th>
		<th class="text-right">操作</th>
	</tr>
	<tr ng-repeat="user in users" ng-if="users">
		<td class="td-link">
			<a ng-href="{{links.edit}}uid={{user.uid}}">
				<img src="{{user.avatar}}" alt="" class="img-responsive icon"/>
			</a>
		</td>
		<td><span ng-bind="user.username"></span><br/><span ng-bind="user.mobile"></span></td>
		<td>
			<span class="color-default" ng-if="user.founder">管理员</span>
			<span class="color-default" ng-if="user.groupname && !user.founder" ng-bind="user.groupname"></span>
			<span class="color-default" ng-if="!user.groupname && !user.founder">未分配</span>
		</td>
		<td class="color-default" ng-bind="user.maxaccount"></td>
		<td class="color-default" ng-bind="user.maxwxapp"></td>
		<td class="color-default" ng-bind="user.maxwebapp"></td>
		<td class="color-default" ng-bind="user.maxphoneapp"></td>
		<td class="color-default" ng-bind="user.maxxzapp"></td>
		<td>
			<span ng-bind="user.joindate"></span>
		</td>
		<td>
			<span ng-bind="user.endtime"></span>
		</td>
		<td class="vertical-middle table-manage-td">
			<div class="link-group" ng-if="!user.founder">
				<a ng-href="{{links.edit}}uid={{user.uid}}" ng-if="type == 'display'">编辑</a>
				<a href="javascript:;" ng-click="operate(user.uid, '')" class="del" ng-if="type == 'display'">删除</a>
			</div>
			<div class="manage-option text-right" ng-if="!user.founder">
				<a href="{{links.edit}}uid={{user.uid}}">基础信息</a>
				<a href="{{links.edit}}&do=edit_modules_tpl&uid={{user.uid}}">应用模板权限</a>
				<a href="{{links.edit}}&do=edit_account&uid={{user.uid}}">使用账号列表</a>
			</div>
		</td>
	</tr>
	<tr ng-if="!users">
		<td colspan="7" class="text-center">暂无数据</td>
	</tr>
</table>
<div class="text-right">
	<?php  echo $pager;?>
</div>
<script type="text/javascript">
	$(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
	angular.module('userManageApp').value('config', {
		type: "<?php echo !empty($_GPC['type']) ? $_GPC['type'] : 'display'?>",
		users: <?php echo !empty($users) ? json_encode($users) : 'null'?>,
		usergroups: <?php echo !empty($usergroups) ? json_encode($usergroups) : 'null'?>,
		links: {
			link: "<?php  echo url('founder/display/del')?>",
			edit: "<?php  echo url('founder/edit')?>",
		},
	});
	angular.bootstrap($('#js-users-display'), ['userManageApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
