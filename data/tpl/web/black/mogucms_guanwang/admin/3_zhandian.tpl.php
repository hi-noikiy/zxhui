<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div id="js-wesite-article-display">
    <div class="pull-right menu-content-tips">
       
		<a href="<?php  echo $_W['siteurl'];?>&act=zhandianadd" class="btn btn-primary we7-padding-horizontal">添加代理商</a>
		<a href="<?php  echo $_W['siteurl'];?>&act=csradd" class="btn btn-primary we7-padding-horizontal">绑定创始人域名</a>

		<a href="<?php  echo $_W['siteurl'];?>&act=otheradd" class="btn btn-primary we7-padding-horizontal">其他模块首页</a>
    </div>
    <br />

    <table class="table we7-table table-hover article-list vertical-middle">
        <col/>
        <col/>
        <col/>
		1.如果有代理的请添加代理域名和代理登录名<br/>
		2.创始人站点支持多域名绑定，一个代理商只能绑定一个域名<br/>
        <tr>
            <th>ID</th>
            <th class="text-left">域名</th>
            <th class="text-left">用户名</th>
            <th class="text-left">类型</th>
            <th class="text-right">操作</th>
        </tr>
        <?php  if(is_array($lists)) { foreach($lists as $list) { ?>
        <tr>
            <td><?php  echo $list['id'];?></td>
            <td class="text-left"><?php  echo $list['domain'];?></td>
            <td class="text-left"><?php  if($list['username']  >= 0) { ?><?php  echo $list['username'];?><?php  } ?></td>
            <td class="text-left"><?php  if($list['isfounder']=="1") { ?>创始人<?php  } else if($list['isfounder']=="-2") { ?>其他首页<?php  } else if($list['isfounder']=="-1") { ?>创始人多域名<?php  } else { ?>代理商<?php  } ?></td>
            <td>
                <div class="link-group">
					<?php  if($list['isfounder']=="-1" || $list['isfounder']=="-2") { ?>
                    <a href="<?php  echo $_W['siteurl'];?>&act=delete&mid=<?php  echo $list['id'];?>" class="del">删除</a>
					<?php  } else { ?>
                    <a href="<?php  echo $_W['siteurl'];?>&act=edit&mid=<?php  echo $list['id'];?>" class="del">修改</a>
					<?php  } ?>
                </div>
            </td>
        </tr>
        <?php  } } ?>
    </table>
    <div class="text-right we7-margin-top">
        <?php  echo $pager;?>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>