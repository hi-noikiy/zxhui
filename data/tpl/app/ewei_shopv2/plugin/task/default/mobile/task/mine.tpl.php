<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/task.css?v=<?php  echo time();?>"/>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/task/static/css/iconfont.css?v=<?php  echo time();?>"/>

<title>任务中心</title>
	<div class="fui-page task-list ">
		<div class="fui-header">
            <div class="fui-header-left">
                <a class="back2 external" href="<?php  echo mobileUrl('task')?>"></a>
            </div>
            <div class="title">我的任务</div>
            <div class="fui-header-right">
            </div>
        </div>
		<div id="tab" class="fui-tab fui-tab-danger">
	        <a data-tab="tab" class="external<?php  if($status == 1) { ?> active<?php  } ?>"
			   href="<?php  echo mobileUrl('task.mine',array('status'=>1))?>">进行中</a>
	        <a data-tab="tab0" class="external<?php  if($status == 2) { ?> active<?php  } ?>"
			   href="<?php  echo mobileUrl('task.mine',array('status'=>2))?>">已完成</a>
	        <a data-tab="tab1" class="external<?php  if($status == 3) { ?> active<?php  } ?>"
			   href="<?php  echo mobileUrl('task.mine',array('status'=>3))?>">已失败</a>
	    </div>
		<div class="fui-content navbar" style="padding-bottom: 0;">
			<?php  if(empty($list)) { ?>
			<div style="height: 7rem;line-height:7rem;width: 100%;text-align: center;color: #d0d0d0;font-size: 1rem">暂时没有任何任务</div>
			<?php  } ?>
			<div class="mytask-list-group">
				<?php  if(is_array($list)) { foreach($list as $c => $record) { ?>
				<a class="mytask-list">
					<div class="mytask-list-top">
						<div class="mytask-list-media">
							<img src="<?php  echo $record['taskimage'];?>"/>
						</div>
						<div class="mytask-list-inner">
							<div class="title"><?php  echo $record['tasktitle'];?></div>
							<div class="time">
								<p>领取时间：<?php  echo substr($record['picktime'],0,-3)?></p>
								<p>截至时间：<?php  if($record['stoptime'] == '0000-00-00 00:00:00') { ?>
									无<?php  } else { ?><?php  echo substr($record['stoptime'],0,-3)?>
									<?php  } ?></p>
							</div>
						</div>
						<div class="mytask-list-right">
							<div><?php  if($status == 1) { ?>进行中<?php  } else if($status == 2) { ?>已完成<?php  } else { ?>已失败<?php  } ?></div>
							<div class="detail"
								 onclick="location.href='<?php  echo mobileUrl('task.detail',array('rid'=>$record['id']))?>'">
								详情</div>
						</div>
					</div>
					<div class="mytask-progress">
						进度
						<div class="progress">
							<div class="progress-inner" style="width: <?php  echo $record['task_progress']/$record['task_demand']*100?>%;"></div>
						</div>
						<span class="times"><?php  echo $record['task_progress'];?>/<?php  echo $record['task_demand'];?></span>
					</div>
				</a>
				<?php  } } ?>
			</div>
		</div>
	</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>