<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('account/account-header', TEMPLATE_INCLUDEPATH)) : (include template('account/account-header', TEMPLATE_INCLUDEPATH));?>
<div id="js-account-manage-base" ng-controller="AccountManageBase" ng-cloak>
	<table class="table we7-table table-hover table-form">
		<col width="140px" />
		<col />
		<col width="100px" />
		<tr>
			<th class="text-left" colspan="3">PC应用设置</th>
		</tr>
		<tr>
			<td class="table-label">头像</td>
			<td><img ng-src="{{other.headimgsrc}}" width="75px" height="75px" /></td>
			<td>
				<div class="link-group">
					<a href="javascript:;" ng-click="changeImage('headimgsrc','<?php  echo $uniacid;?>')">修改</a>
				</div>
			</td>
		</tr>

		<tr>
			<td class="table-label">PC名称</td>
			<td ng-bind="account.name"></td>
			<td><div class="link-group"><a href="javascript:;" data-toggle="modal" data-target="#name" ng-click="editInfo('name', account.name)">修改</a></div></td>
		</tr>


		<tr>
			<td class="table-label">到期时间</td>
			<td><span ng-bind="account.end"></span><span class="color-gray">（随该PC主管理员的到期时间，未设置主管理员时默认为创始人）</span></td>
			<td>
				<div class="link-group" ng-if="founder || owner">
					<a href="javascript:;" data-toggle="modal" data-target="#endtime" ng-click="editInfo('endtype', account.endtype)">修改</a>
				</div>
			</td>
		</tr>
		
		<tr>
			<td class="table-label">月访问总次数</td>
			<td ng-if="account.highest_visit"><span ng-bind="account.highest_visit"></span><span class="color-gray"> 次 / 月</span></td>
			<td ng-if="!account.highest_visit">不限次数</span></td>
			<td>
				<?php  if(user_is_founder($_W['uid'])) { ?>
				<div class="link-group"><a href="javascript:;" data-toggle="modal" data-target="#visit" ng-click="editInfo('highest_visit', account.highest_visit)">修改</a></div>
				<?php  } ?>
			</td>
		</tr>
		
		<tr>
			<td class="table-label">附件空间</td>
			<td>
				<span ng-if="account.attachment_limit != -1">{{account.attachment_limit}}M</span>
				<span ng-if="account.attachment_limit == -1">不限</span>
			</td>
			<td>
				<div class="link-group" ng-if="founder || owner">
					<a href="javascript:;" data-toggle="modal" data-target="#attachment_limit" ng-click="editInfo('attachment_limit', account.attachment_limit)">修改</a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="table-label">已用附件空间</td>
			<td><span ng-bind="account.attachment_size"></span><span>M</span></td>
			<td></td>
		</tr>
	</table>
	<div class="modal fade" id="attachment_limit" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="we7-modal-dialog modal-dialog we7-form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-title">修改公众号附件空间大小</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="number" ng-model="middleAccount.attachment_limit" class="form-control"/>
						<span class="help-block">请输入单位为 M 的内存值，设置为 -1 时不限空间。</span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="httpChange('attachment_limit')">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="name" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="we7-modal-dialog modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-title">修改PC名称</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" ng-model="middleAccount.name" class="form-control" placeholder="PC名称" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="httpChange('name')">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="we7-modal-dialog modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-title">修改PC账号</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" ng-model="middleAccount.account" class="form-control" placeholder="公众号账号" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="httpChange('account')">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="endtime" role="dialog">
		<div class="we7-modal-dialog modal-dialog we7-form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-title">设置到期时间</div>
				</div>
				<div class="modal-body">
					<div class="form-group" ng-if="middleAccount.endtype == 1 || founder">
						<input id="endtype-1" type="radio" name="endtype" value="2" ng-model="middleAccount.endtype" ng-checked="middleAccount.endtype == 2"><label for="endtype-1">设置期限</label>
						<input id="endtype-2" type="radio" name="endtype" value="1" ng-model="middleAccount.endtype" ng-checked="middleAccount.endtype == 1"><label for="endtype-2">永久</label>
					</div>
					<div class="form-group" ng-show="middleAccount.endtype == 2">
						<?php  echo tpl_form_field_date('endtime', $account['endtime']);?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="httpChange('endtime')">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

    
    <div class="modal fade" id="visit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="we7-modal-dialog modal-dialog we7-form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="modal-title">修改访问总次数（单位：月）</div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="number" step="1" ng-model="middleAccount.highest_visit" class="form-control" placeholder="每月访问总次数" />
                        <span class="help-block">设置为0，表示无任何限制</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="httpChange('highest_visit')">确定</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    

</div>
<script>
	angular.module('accountApp').value('config', {
		founder : <?php  if($_W['isfounder']) { ?>true<?php  } else { ?>false<?php  } ?>,
		owner : <?php  if($state == 'owner') { ?>true<?php  } else { ?>false<?php  } ?>,
		account: <?php echo !empty($account) ? json_encode($account) : 'null'?>,
		uniaccount: <?php echo !empty($uniaccount) ? json_encode($uniaccount) : 'null'?>,
		headimgsrc: "<?php  echo $headimgsrc?>",
		qrcodeimgsrc: "<?php  echo $qrcodeimgsrc?>",
		links: {
			basePost: "<?php  echo url('account/post/base', array('acid' => $acid, 'uniacid' => $uniacid, 'account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL))?>",
			siteroot: "<?php  echo str_replace('http://', 'https://', $_W['siteroot'])?>",
	},
	});
	angular.bootstrap($('#js-account-manage-base'), ['accountApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>