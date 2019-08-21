<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div id="js-wesite-article-display">
    <div class="pull-right menu-content-tips">
       
		<a href="<?php  echo $_W['siteurl'];?>&act=solveadd" class="btn btn-primary we7-padding-horizontal">添加方案</a>
    </div>
    <br />

    <table class="table we7-table table-hover article-list vertical-middle">
        <col/>
        <col/>
        <col/>
        <tr>
            <th>ID</th>
            <th class="text-left">标题</th>
            <th class="text-right">操作</th>
        </tr>
        <?php  if(is_array($lists)) { foreach($lists as $list) { ?>
        <tr>
            <td><?php  echo $list['id'];?></td>
            <td class="text-left"><?php  echo $list['title'];?></td>
            <td>
                <div class="link-group">
                    <a href="<?php  echo $_W['siteurl'];?>&act=edit&mid=<?php  echo $list['id'];?>">编辑</a>
                    <a href="<?php  echo $_W['siteurl'];?>&act=delete&mid=<?php  echo $list['id'];?>" class="del">删除</a>
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