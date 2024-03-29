<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<a href="<?php  echo url('user/display');?>"><i class="wi wi-back-circle"></i> </a>
	<li><a href="<?php  echo url('user/display');?>">用户管理</a></li>
	<li>编辑用户详情</li>
</ol>
<div id="js-user-edit-modulestpl" ng-controller="UserEditModules" ng-cloak>
	<div class="user-head-info we7-padding-bottom" >
		<img ng-src="{{profile.avatar}}" class="img-circle user-avatar pull-left">
		<h3 class="pull-left" ng-bind="user.username"></h3>
		<div class="user-edit pull-right">
			
			<?php  if($user['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) { ?>
			<a href="javascript:;" class="btn btn-primary" ng-click="recycleUser()">禁用</a>
			<?php  } ?>
			
		</div>
	</div>
	<div class="btn-group we7-btn-group we7-padding-bottom">
		<a href="<?php  echo url('user/edit/edit_base', array('uid' => $_GPC['uid']))?>" class="btn btn-default">基础信息</a>
		<a href="<?php  echo url('user/edit/edit_modules_tpl', array('uid' => $_GPC['uid']))?>" class="btn btn-default active">应用模板权限</a>
		<a href="<?php  echo url('user/edit/edit_account', array('uid' => $_GPC['uid']))?>" class="btn btn-default">使用账号列表</a>
	</div>

	<div class="panel we7-panel user-permission">
		<div class="panel-heading">
			<span>所属用户组：<span ng-bind="group_info.name"></span></span>
			<a href="javascript:;" class="color-default pull-right" data-toggle="modal" data-target="#group" ng-click="editGroup()">修改</a>
		</div>
		<div class="modal fade" id="group" role="dialog">
			<div class="we7-modal-dialog modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<div class="modal-title">修改用户组</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<select class="we7-select" ng-model="changeGroup">
								<option value="">请选择所属用户组</option>
								<option ng-value="group.id" ng-repeat="group in groups" ng-selected="group.id == group_info.id" ng-bind="group.name"></option>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="httpChange('groupid')">确定</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body" ng-repeat="(packid, pack) in group_info.package_detail">
			<div class="permission-heading">
				<span ng-bind="pack.name"></span>
				<span ng-if="packid == '-1'">所有服务</span>
				<div class="pull-right permission-edit" ng-style="{'width': 'auto'}">
					<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#demo-{{packid}}" ng-click="changeText($event)">展开</a>
				</div>
			</div>
			<table id="demo-{{pack.id}}" class="table we7-table table-hover collapse" ng-if="packid != '-1'">
				<col width="90px" />
				<col width="835px" />
				<tr class="permission-apply">
					<td class="vertical-middle">公众号应用</td>
					<td>
						<ul>
							<li ng-repeat="module in pack.modules" class="col-sm-2 text-over text-left">
								<img ng-src="{{ module.logo }}" alt="">
								{{ module.title }}
							</li>
						</ul>
					</td>
				</tr>
				<tr class="permission-apply">
					<td class="vertical-middle">小程序应用</td>
					<td>
						<ul>
							<li ng-repeat="module in pack.wxapp" class="col-sm-2 text-over text-left">
								<img ng-src="{{ module.logo }}" alt="">
								{{ module.title }}
							</li>
						</ul>
					</td>
				</tr>
				<tr class="permission-apply">
					<td class="vertical-middle">PC应用</td>
					<td>
						<ul>
							<li ng-repeat="module in pack.webapp" class="col-sm-2 text-over text-left">
								<img ng-src="{{ module.logo }}" alt="">
								{{ module.title }}
							</li>
						</ul>
					</td>
				</tr>
				<tr class="permission-apply">
					<td class="vertical-middle">APP应用</td>
					<td>
						<ul>
							<li ng-repeat="module in pack.phonebapp" class="col-sm-2 text-over text-left">
								<img ng-src="{{ module.logo }}" alt="">
								{{ module.title }}
							</li>
						</ul>
					</td>
				</tr>
				<tr class="permission-template">
					<td class="vertical-middle">模板</td>
					<td><ul><li ng-repeat="tpl in pack.templates"><span class="label label-info" ng-bind="tpl.title"></span></li></ul></td>
				</tr>
			</table>
			<table id="demo-{{packid}}" class="table we7-table table-hover collapse" ng-if="packid == -1">
				<col width="90px" />
				<col width="835px" />
				<tr class="permission-apply">
					<td class="vertical-middle">应用</td>
					<td><ul><li><span class="label label-danger">系统所有模块</span></li></ul></td>
				</tr>
				<tr class="permission-template">
					<td class="vertical-middle">模板</td>
					<td><ul><li><span class="label label-danger">系统所有模板</span></li></ul></td>
				</tr>
			</table>
		</div>
	</div>

	<table class="table we7-table table-hover account-package-extra">
		<tr>
			<th colspan="5" class="text-left">
				<span class="we7-padding-right">附加权限</span>
				<span></span>
			</th>

			<?php  if(user_is_founder($_W['uid'])) { ?>
			<th class="text-right">
				<a class="color-default" data-toggle="modal" data-target="#jurisdiction-add">修改</a>
			</th>
			<?php  } ?>
		</tr>

		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">公众号应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.modules_modules" ng-if="extend.modules_modules">
						<div ng-if="module.name != 'all'" class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.modules_modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">小程序应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.wxapp_modules" ng-if="extend.wxapp_modules">
						<div class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.wxapp_modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">PC 应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.webapp_modules" ng-if="extend.webapp_modules">
						<div class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.webapp_modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">APP 应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.phoneapp_modules" ng-if="extend.phoneapp_modules">
						<div class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.phoneapp_modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">熊掌应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.xzapp_modules" ng-if="extend.xzapp_modules">
						<div class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.xzapp_modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
				<div class="col-sm-11 js-extra-templates">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.templates" ng-if="extend.templates">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.templates">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>

	</table>
	<div class="uploader-modal modal fade module" id="jurisdiction-add">
		<div class="modal-dialog modal-lg">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2">选择</h4>
				</div>
				<div class="modal-body material-content clearfix">
					<div class="material-nav">
						<a href="javascript:;" ng-if="user_modules.account" ng-click="tabChange('account')"  ng-class="{true:'active',false:''}[jurindex=='account']" >公众号应用</a>
						<a href="javascript:;" ng-if="user_modules.wxapp" ng-click="tabChange('wxapp')"  ng-class="{true:'active',false:''}[jurindex=='wxapp']" >小程序应用</a>
						<a href="javascript:;" ng-if="user_modules.webapp" ng-click="tabChange('webapp')"  ng-class="{true:'active',false:''}[jurindex=='webapp']" >PC 应用</a>
						<a href="javascript:;" ng-if="user_modules.phoneapp" ng-click="tabChange('phoneapp')"  ng-class="{true:'active',false:''}[jurindex=='phoneapp']" >APP 应用</a>
						<a href="javascript:;" ng-if="user_modules.xzapp" ng-click="tabChange('xzapp')"  ng-class="{true:'active',false:''}[jurindex=='xzapp']" >熊掌号应用</a>
						<a href="javascript:;" ng-if="templates" ng-click="tabChange('template')" ng-class="{true:'active',false:''}[jurindex=='template']">微站模板</a>
					</div>
					<div class="material-body" ng-show="jurindex!='template'" id="content-modules" style="height: 560px;">
						<div class="row">
							<div class="col-sm-2" ng-repeat="item in modules">
								<div class="item"
									 ng-click="itemclick(item.name)"
									 ng-class="{true:'active',false:''}[item.checked == 1]"
									 onclick="$(this).toggleClass('active')">
									<img ng-src="{{item.logo}}" alt="" class="icon"/>
									<div class="name" ng-bind="item.title"></div>
									<div class="mask">
										<span class="wi wi-right"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="material-body" ng-show="jurindex=='template'" id="content-templates" style="height: 560px;">
						<div class="row">
							<div class="col-sm-2" ng-repeat="temp in templates">
								<div ng-click="itemclick(temp.id)"
									 class="item"
									 ng-class="{true:'active',false:''}[temp.checked == 1]"
									 onclick="$(this).toggleClass('active')"
								>
									<i class="wi wi-home" style="color: #ddd;font-size: 48px;position:relative; top:-15px; margin: 0;"></i>
									<div class="name" ng-bind="temp.title"></div>
									<div class="mask">
										<span class="wi wi-right"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="material-pager text-right clearfix" style="padding: 10px">
					<div class="pull-left we7-form">
						<input type="checkbox" id="selected-all" ng-model="allmodule" ng-change="allmodulechange(allmodule)">
						<label for="selected-all">全选</label>
					</div>
					<div class="js-pager">
						<ul class="pagination">
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="addExtend()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	angular.module('userManageApp').value('config', {
		user: <?php echo !empty($user) ? json_encode($user) : 'null'?>,
		profile: <?php echo !empty($profile) ? json_encode($profile) : 'null'?>,
		group_info: <?php echo !empty($group_info) ? json_encode($group_info) : 'null'?>,
		groups: <?php echo !empty($groups) ? json_encode($groups) : 'null'?>,
		extend: <?php echo !empty($extend) ? json_encode($extend) : 'null'?>,
    	user_modules: <?php echo !empty($user_modules) ? json_encode($user_modules) : 'null'?>,
    	source_templates: <?php echo !empty($templates) ? json_encode($templates) : 'null'?>,
    	extend_modules: <?php echo !empty($extend_permission['modules']) ? json_encode($extend_permission['modules']) : 'null'?>,
		links: {
			editGroup: "<?php  echo url('user/edit/edit_modules_tpl')?>",
			editUsersPermission: "<?php  echo url('user/edit/edit_users_permission')?>",
			recycleUser: "<?php  echo url('user/display/operate', array('type' => 'recycle'))?>",
		},
	});
    
	angular.bootstrap($('#js-user-edit-modulestpl'), ['userManageApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>