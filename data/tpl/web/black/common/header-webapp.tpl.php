<?php defined('IN_IA') or exit('Access Denied');?><div class="text-center"><img src="<?php  echo tomedia('headimg_'.$_W['acid'].'.jpg')?>?time=<?php  echo time()?>" class="head-logo"></div>
<div class="text-center account-name"><?php  echo $account['name'];?></div>
<div class="text-center operate">
	<?php  if(in_array($role, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
	<a href="<?php  echo url('account/post', array('uniacid' => $_W['account']['uniacid'], 'acid' => $_W['acid'], 'account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL))?>"><i class="wi wi-appsetting" data-toggle="tooltip" data-placement="bottom" title="设置"></i></a>
	<?php  } ?>
	<a href="<?php  echo url('account/display', array('type' => 'all'))?>" class="color-default"><i class="wi wi-small-routine" data-toggle="tooltip" data-placement="bottom" title="切换平台"></i></a>
</div>