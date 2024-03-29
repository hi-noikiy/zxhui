<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li><a href="<?php  echo url('statistics/account');?>">所有公众号流量统计</a></li>
	<li class="active"><a href="<?php  echo url('statistics/account/app_display');?>">所有公众号app端访问统计</a></li>
</ul>
<div class="api">
	<div class="panel we7-panel api-target">
		<div class="panel-heading">今日/昨日关键指标</div>
		<div class="panel-body we7-padding-vertical">
			<div class="col-sm-4 text-center">
				<div class="title">公众号总访问数</div>
				<div>
					<span class="today"><?php  echo $today_module_api['visit_sum'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_module_api['visit_sum'];?></span>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div class="title">公众号平均访问数</div>
				<div>
					<span class="today"><?php  echo $today_module_api['visit_avg'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_module_api['visit_avg'];?></span>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div class="title">公众号最高访问数</div>
				<div>
					<span class="today"><?php  echo $today_module_api['visit_highest'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_module_api['visit_highest'];?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="panel we7-panel" id="js-system-account-app-analysis" ng-controller="systemAccountAppAnalysisCtrl" ng-cloak>
		<div class="panel-heading tab">
			<a href="javascript:;">关键指标详解</a>
			<a href="javascript:;" ng-class="{'active': divideType == 'bysum'}" ng-click="changeDivideType('bysum')">公众号总访问数</a>
			<a href="javascript:;" ng-class="{'active': divideType == 'byavg'}" ng-click="changeDivideType('byavg')">公众号平均访问数</a>
			<a href="javascript:;" ng-class="{'active': divideType == 'byhighest'}" ng-click="changeDivideType('byhighest')">公众号最高访问数</a>
		</div>
		<div class="panel-body data-view">
			<div class="tab-bar-time clearfrix">
				<span class="we7-margin-right">时间</span>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" ng-class="{'active': timeType == 'week'}" ng-click="getAccountApi('week')">周统计</button>
					<button type="button" class="btn btn-default" ng-class="{'active': timeType == 'month'}" ng-click="getAccountApi('month')">月统计</button>
					<div class="btn-group" role="group" ng-class="{'active': timeType == 'daterange'}">
						<button class="btn btn-default daterange daterange-date" we7-date-range-picker ng-model="dateRange"><span>{{dateRange.startDate}} </span>至<span> {{dateRange.endDate}}</span> <i class="fa fa-calendar"></i></button>
					</div>
				</div>
			</div>
			<div class="col-sm-12" id="chart-line" style="height:500px"></div>
		</div>
	</div>
</div>
<script>
require(['daterangepicker'], function() {
	angular.module('statisticsApp').value('config', {
		'links': {
			'accountApi': "<?php  echo url('statistics/account/get_account_app_api')?>",
		},
	});
	angular.bootstrap($('#js-system-account-app-analysis'), ['statisticsApp']);
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>