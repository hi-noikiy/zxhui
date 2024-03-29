<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<a href="javascript:history.go(-1);"><i class="wi wi-back-circle"></i> </a>
	<li>权限设置</li>
</ol>
<form class="form-horizontal form we7-form" action="" method="post">
	<div class="alert alert-info">
		<i class="fa fa-exclamation-circle"></i> 默认未勾选任何菜单时，用户拥有全部权限。
	</div>

	<table class="table we7-table table-hover we7-form account-and-wxapp">
	<?php  if(is_array($menus)) { foreach($menus as $name => $sections) { ?>
		<?php  if($sections['section'] && $name == 'account' && in_array($account['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) { ?>
			<div class="we7-page-title"><?php  echo $sections['title'];?></div>
			<?php  if(is_array($sections['section'])) { foreach($sections['section'] as $section_id => $section) { ?>
				<?php  if(!in_array($section_id, array('platform_module'))) { ?>
					<thead>
					<tr class="text-left">
						<th colspan="4" class="text-left">
							<div class="">
								<input id="check-<?php  echo $section_id;?>" type="checkbox" name="system_<?php  echo $section_id;?>" onChange="selectall(this, 'system_<?php  echo $section_id;?>')">
								<label for="check-<?php  echo $section_id;?>" class=" we7-margin-horizontal-none"><?php  echo $section['title'];?></label>
							</div>
						</th>
					</tr>
					</thead>
					<tbody class="system_<?php  echo $section_id;?>">
					<?php  $i=1;?>
					<?php  if(is_array($section['menu'])) { foreach($section['menu'] as $menu_id => $menu) { ?>
						<?php  if($i%4 == 1 || $i == 1) { ?><tr><?php  } ?>
						<td class="text-left vertical-middle" style="overflow:inherit;">
							<div class="dropdown system-select-dropdown">
								<span>
									<input id="check-child-<?php  echo $menu_id;?>" type="checkbox" we7-check-all="1" value="<?php  echo $menu['permission_name'];?>" <?php  if(in_array($menu['permission_name'], $user_menu_permission_account)) { ?>checked<?php  } ?> name="system[]" autocomplete="off" />
									<label for="check-child-<?php  echo $menu_id;?>" class="we7-margin-horizontal-none" data-toggle="tooltip"><?php  echo $menu['title'];?></label>
								</span>
								<?php  if($menu['sub_permission']) { ?>
								<ul class="dropdown-menu">
									<?php  if(is_array($menu['sub_permission'])) { foreach($menu['sub_permission'] as $sub_permission) { ?>
									<li class="text-left">
										<input id="check-child-<?php  echo $sub_permission['permission_name'];?>"  we7-check-all="1" type="checkbox" value="<?php  echo $sub_permission['permission_name'];?>" <?php  if(in_array($sub_permission['permission_name'], $user_menu_permission_account)) { ?>checked<?php  } ?> name="system[]">
										<label class="we7-margin-horizontal-none" for="check-child-<?php  echo $sub_permission['permission_name'];?>">
											<?php  echo $sub_permission['title'];?>
										</label>
									</li>
									<?php  } } ?>
								</ul>
								<?php  } ?>
							</div>
							
						</td>
						<?php  if($i%4 == 0) { ?></tr><tr><?php  } ?>
						<?php  $i++;?>
					<?php  } } ?>
					<?php  if(($i-1)%4 != 0) { ?>
						<?php  
						for ($x=0; $x<4-($i-1)%4; $x++) {
							echo "<td></td>";
						} 
						?>
						</tr>
					<?php  } ?>
					</tbody>
				<?php  } ?>
			<?php  } } ?>
		<?php  } ?>
		<?php  if($sections['section'] && $name == 'wxapp' && $account['type'] == ACCOUNT_TYPE_APP_NORMAL) { ?>
			<div class="we7-page-title"><?php  echo $sections['title'];?></div>
			<?php  if(is_array($sections['section'])) { foreach($sections['section'] as $section_id => $section) { ?>
				<?php  if(!in_array($section_id, array('wxapp_module'))) { ?>
					<thead>
					<tr class="text-left">
						<th colspan="4" class="text-left">
							<div class="">
								<input id="check-<?php  echo $section_id;?>" type="checkbox" name="system_<?php  echo $section_id;?>"  we7-check-all="1" onChange="selectall(this, 'system_<?php  echo $section_id;?>')">
								<label for="check-<?php  echo $section_id;?>" class=" we7-margin-horizontal-none"><?php  echo $section['title'];?></label>
							</div>
						</th>
					</tr>
					</thead>
					<tbody class="system_<?php  echo $section_id;?>">
					<?php  $i=1;?>
					<?php  if(is_array($section['menu'])) { foreach($section['menu'] as $menu_id => $menu) { ?>
						<?php  if($menu_id == 'front_download') { ?><?php  continue;?><?php  } ?>
						<?php  if($i%4 == 1 || $i == 1) { ?><tr><?php  } ?>
						<td class="text-left vertical-middle" style="overflow:inherit;">
							<div class="dropdown system-select-dropdown">
								<span>
									<input id="check-child-<?php  echo $menu_id;?>" type="checkbox" we7-check-all="1" value="<?php  echo $menu['permission_name'];?>" <?php  if(in_array($menu['permission_name'], $user_menu_permission_wxapp)) { ?>checked<?php  } ?> name="wxapp[]" autocomplete="off" />
									<label for="check-child-<?php  echo $menu_id;?>" class="we7-margin-horizontal-none" data-toggle="tooltip"><?php  echo $menu['title'];?></label>
								</span>
								<?php  if($menu['sub_permission']) { ?>
								<ul class="dropdown-menu">
									<?php  if(is_array($menu['sub_permission'])) { foreach($menu['sub_permission'] as $sub_permission) { ?>
									<li class="text-left">
										<input id="check-child-<?php  echo $sub_permission['permission_name'];?>"  we7-check-all="1" type="checkbox" value="<?php  echo $sub_permission['permission_name'];?>" <?php  if(in_array($menu['permission_name'], $user_menu_permission_wxapp)) { ?>checked<?php  } ?> name="wxapp[]">
										<label class="we7-margin-horizontal-none" for="check-child-<?php  echo $sub_permission['permission_name'];?>">
											<?php  echo $sub_permission['title'];?>
										</label>
									</li>
									<?php  } } ?>
								</ul>
								<?php  } ?>
							</div>
							
						</td>
						<?php  if($i%4 == 0) { ?></tr><tr><?php  } ?>
						<?php  $i++;?>
					<?php  } } ?>
					<?php  if(($i-1)%4 != 0) { ?>
						<?php  
						for ($x=0; $x<4-($i-1)%4; $x++) {
							echo "<td></td>";
						} 
						?>
						</tr>
					<?php  } ?>
					</tbody>
				<?php  } ?>
			<?php  } } ?>
		<?php  } ?>
	<?php  } } ?>
	</table>

	<?php  if(!empty($module)) { ?>
	<table class="table we7-table table-hover vertical-middle we7-form">
		<div class="we7-page-title">应用</div>
		<thead>
			<tr>
				<th colspan="4" class="text-left">
					<div class="">
						<input id="check-module" type="checkbox" name="module_select"  we7-check-all="1" onChange="selectall(this, 'module_select')">
						<label for="check-module" class=" we7-margin-horizontal-none">应用权限</label>
					</div>
				</th>
			</tr>
		</thead>
		<tbody class="module_select" >
			<?php  $i=1;?>
			<?php  if(is_array($module)) { foreach($module as $k => $m) { ?>
				<?php  if(empty($m['issystem'])) { ?>
				<?php  if($i%4 == 1 || $i == 1) { ?><tr><?php  } ?>
					<td  class="text-left vertical-middle" style="overflow:inherit;width:25%">
						<div class="dropdown system-select-dropdown">
							<span class="" data-id="<?php  echo $k;?>">
								<input id="check-module-<?php  echo $k;?>" type="checkbox" value="<?php  echo $k;?>" name="module[]" we7-check-all="1" <?php  if(in_array($k, $module_permission_keys)) { ?>checked<?php  } ?>>
								<label for="check-module-<?php  echo $k;?>" title="<?php  echo $m['title'];?>"><?php  echo mb_substr($m['title'], 0, 12, 'utf-8')?></label>
							</span>
							<ul class="dropdown-menu" role="menu">
							</ul>
							<input type="hidden" name="<?php  echo $k;?>_select" value="0"/>
						</div>
					</td>
				<?php  if($i%4 == 0) { ?></tr><?php  } ?>
				<?php  $i++;?>
				<?php  } ?>
			<?php  } } ?>
			<?php  if(($i-1)%4 != 0) { ?>
				<?php  
				for ($x=0; $x<4-($i-1)%4; $x++) {
				  echo "<td></td>";
				} 
				?>
				</tr>
			<?php  } ?>
		</tbody>
	</table>
	<?php  } ?>

	<button type="submit" class="btn btn-primary span3" name="submit" value="提交" onclick="if ($('input:checkbox:checked').size() == 0) {return confirm('您未勾选任何菜单权限，意味着允许用户使用所有功能。确定吗？')}">提交</button>
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</form>
<script>
$(function(){

	var uniacid = "<?php  echo $_GPC['uniacid'];?>";
	var acid = "<?php  echo $_GPC['acid'];?>";
	//公众号OR小程序下拉框
	$('.account-and-wxapp .dropdown span').hover(function(){
		$(this).parent().addClass('open').find('.dropdown-menu').show();
		$(this).parent().find('.dropdown-menu').hover(
			function(){$(this).show();$(this).parent().addClass('open')},
			function(){$(this).hide();$(this).parent().removeClass('open');}
		);
	},function(){
		$(this).parent().removeClass('open').find('.dropdown-menu').hide();
	});
	//模块下拉框
	$('.module_select .dropdown span').hover(function(){
		var _this = $(this);
		var m = $(this).attr('data-id');
		var uid = "<?php  echo $uid;?>";
		var length = $(this).next().find('li').size();
		if(!length) {
			$.post("<?php  echo url('account/post-user/module')?>", {'m' : m, 'uid' : uid, 'uniacid' : uniacid, 'acid' : acid}, function(data) {
				console.log(data);
				if(!data.message.errno) {
					var li_nums = data.message.message.length;
					var li_checked = 0;
					var li_contents = '';
					var html = '';
					$.each(data.message.message, function(k, v){
						var check = '';
						if (v.checked) {
							check = 'checked';
							li_checked ++;
						}
						html += '<li><a href="javascript:;"><input id="check-moduledetail-'+m+'-'+k+'" we7-check-all="1"  type="checkbox" name="module_'+m+'[]" value="'+ v.permission +'" '+check+'/><label for="check-moduledetail-'+m+'-'+k+'" class="we7-padding-left we7-margin-horizontal-none checkbox-inline">'+ v.title +'</label></a></li>';
					});
					if (li_nums == li_checked) {
						li_contents = '已全选';
					} else {
						li_contents = '已选' + li_checked + '项';
					}
					var _html = '<li><label class="checkbox-inline info">' + li_contents + '</label></li>';
					html = _html + html;
				}
				_this.next().html(html);
			}, 'json');
		}

		$(this).parent().addClass('open').find('.dropdown-menu').show();
		$(this).parent().find('.dropdown-menu').hover(
			function(){$(this).show();$(this).parent().addClass('open')},
			function(){$(this).hide();$(this).parent().removeClass('open');}
		);
	},function(){
		$(this).parent().removeClass('open').find('.dropdown-menu').hide();
	});

	$('.dropdown span :checkbox').click(function(e){
		var _parent = $(this).parents('.dropdown');
		_parent.find('.dropdown-menu :checkbox').prop('checked', $(this).prop('checked'));
		if($(this).prop('checked')) {
			_parent.find('label.info').html('已全选');
			_parent.find('input[type="hidden"]').val(1);
		} else {
			_parent.find('input[type="hidden"]').val(0);
			_parent.find('label.info').html('已选0项');
		}
	});

	$('.dropdown-menu').on('click', ':checkbox', function(){
		if(!$(this).prop('checked')) {
			var i = 0;
			$.each($(this).parents('li').siblings(), function(){
				if($(this).find(':checkbox').prop('checked')) {
					i ++;
				}
			});
			$(this).parents('.dropdown').find('input[type="hidden"]').val(0);
			$(this).parents('.dropdown').find('label.info').html('已选' + i + '项');
			if(!i) {
				$(this).parents('.dropdown').find('span :checkbox').prop('checked', false);
			}
		} else {
			var flag = 0;
			var i = 1;
			$.each($(this).parents('li').siblings(), function(){
				if(!$(this).find(':checkbox').prop('checked')) {
					flag = 1;
				} else {
					i ++;
				}
			});
			if(!flag) {
				$(this).parents('.dropdown').find('label.info').html('已全选');
				$(this).parents('.dropdown').find('input[type="hidden"]').val(1);
			} else {
				$(this).parents('.dropdown').find('label.info').html('已选' + i + '项');
				$(this).parents('.dropdown').find('input[type="hidden"]').val(0);
			}
			$(this).parents('.dropdown').find('span :checkbox').prop('checked', true);
		}
	});
});
//处理全选函数
function selectall(obj, a){
	$('.'+a+' input:checkbox').each(function() {
		$(this)[0].checked = obj.checked ? true : false;
	});
}
//当已经全选时，默认全选按钮选中
$(function() {
	$('.table>tbody').each(function() {
		var a = true;
		$(this).find('input:checkbox').each(function() {
			if($(this)[0].checked != true) {
				a = false;
				return false;
			}
		});
		if(a) $('input[name='+$(this).attr('class')+']:checkbox')[0].checked = true;
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>