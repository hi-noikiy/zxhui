<?php defined('IN_IA') or exit('Access Denied');?><div class="fui-navbar">
    <a href="<?php  echo mobileUrl('live')?>" class="external nav-item <?php  if($_GPC['r']=='live') { ?>active<?php  } ?>">
        <span class="icon icon-home"></span>
        <span class="label">直播首页</span>
    </a>

    <a href="<?php  echo mobileUrl('live/list')?>" class="external nav-item <?php  if($_GPC['r']=='live.list') { ?>active<?php  } ?>">
        <span class="icon icon icon-list"></span>
        <span class="label">全部直播</span>
    </a>

   <a href="<?php  echo mobileUrl('live/follow')?>" class="external nav-item <?php  if($_GPC['r']=='live.follow') { ?>active<?php  } ?>">
        <span class="icon icon icon-like"></span>
        <span class="label">我的订阅</span>
    </a>

    <a href="<?php  echo mobileUrl('member')?>" class="external nav-item">
        <span class="icon icon-person2"></span>
        <span class="label">会员中心</span>
    </a>


</div>

