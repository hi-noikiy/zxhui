<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-lg control-label ">排序</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="displayorder" class="form-control" value="<?php  echo $article['displayorder'];?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label must">文章标题</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="article_title" class="form-control" value="<?php  echo $article['article_title'];?>" data-rule-required='true' bind-in="art_title" />
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label must">分类</label>
	<div class="col-sm-9 col-xs-12">
		<select class="form-control select2" name="article_category" data-rule-required='true'>
                                    <option value="0">请选择文章分类</option>
                                    <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
                                        <option value="<?php  echo $category['id'];?>" <?php  if($article['article_category']==$category['id']) { ?> selected="selected"<?php  } ?>><?php  echo $category['category_name'];?></option>
                                    <?php  } } ?>
                    </select>
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label"></label>

	<div class="col-sm-3">
		<input type="text" name="article_mp" class="form-control" value="<?php  if(empty($article['article_mp'])) { ?><?php  echo $mp['name'];?><?php  } else { ?><?php  echo $article['article_mp'];?><?php  } ?>" placeholder="公众号" bind-in="art_mp" bind-de="<?php  echo $mp['name'];?>">
	</div>

	<div class="col-sm-3">
		<input type="text" name="article_author" class="form-control" value="<?php  echo $article['article_author'];?>" placeholder="发布作者" bind-in="art_author" bind-de="编辑小美">
	</div>

	<div class="col-sm-3">
		<?php  echo tpl_form_field_date('article_date_v', $article['article_date_v'],false)?>
	</div>

</div>
<div class="form-group">
	<label class="col-lg control-label">阅读全文</label>

	<div class="col-sm-9 col-xs-12">
		<input type="text" name="article_linkurl" class="form-control" value="<?php  echo $article['article_linkurl'];?>" placeholder="阅读全文链接，如果不填写则不显示阅读全文">
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label">虚拟阅读数</label>

	<div class="col-sm-3">

		<input type="text" name="article_readnum_v" class="form-control" value="<?php  echo $article['article_readnum_v'];?>" placeholder="虚拟阅读数" bind-in="art_read" bind-de="0" bind-num='1'>
	</div>
	<label class="col-lg control-label">虚拟点赞数</label>
	<div class="col-sm-3">
		<input type="text" name="article_likenum_v" class="form-control" value="<?php  echo $article['article_likenum_v'];?>" placeholder="虚拟点赞数" bind-in="art_like" bind-de="0" bind-num='1'>
	</div>

</div>
<div class="form-group">
	<label class="col-lg control-label">举报设置</label>

	<div class="col-sm-9 col-xs-12">
		<label class="radio-inline"><input type="radio" name="article_report" value="1"  <?php  if($article['article_report']==1) { ?>checked="true"<?php  } ?>> 模拟举报(使用有风险)</label>
		<label class="radio-inline"><input type="radio" name="article_report" value="0"  <?php  if($article['article_report']==0) { ?>checked="true"<?php  } ?>> 不显示</label>
	</div>

</div>
<div class="form-group">
	<label class="col-lg control-label">分享设置</label>

	<div class="col-sm-9 col-xs-12">
		<label class="checkbox-inline"><input type="checkbox" name="page_set_option_nocopy" value="1"  <?php  if($article['page_set_option_nocopy']=='1') { ?>checked="checked"<?php  } ?>> 禁止复制链接</label>
		<label class="checkbox-inline"><input type="checkbox" name="page_set_option_noshare_tl" value="1"  <?php  if($article['page_set_option_noshare_tl']=='1') { ?>checked="checked"<?php  } ?>> 禁止分享至朋友圈</label>
		<label class="checkbox-inline"><input type="checkbox" name="page_set_option_noshare_msg" value="1"  <?php  if($article['page_set_option_noshare_msg']=='1') { ?>checked="checked"<?php  } ?>> 禁止分享给好友</label>
	</div>

</div>

<div class="form-group">
	<label class="col-lg control-label">阅读区域</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="article_areas" class="form-control" value="<?php  echo $article['article_areas'];?>" />
		<span class="help-block">限制阅读区域，省份或城市，多个用半角逗号隔开</span>
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label">状态</label>
	<div class="col-sm-9 col-xs-12">
		<label class="radio-inline"><input type="radio" name="article_state" value="1" <?php  if(!$aid || $article['article_state']==1) { ?>checked="true"<?php  } ?>> 开启</label>
		<label class="radio-inline"><input type="radio" name="article_state" value="0" <?php  if($aid && $article['article_state']==0) { ?>checked="true"<?php  } ?>> 关闭</label>
		<span class='help-block'>关闭后手机端列表不会显示</span>
	</div>
</div>

<div class="form-group-title">平台回复设置</div>

<div class="form-group">
	<label class="col-lg control-label">回复关键词</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="article_keyword2" class="form-control" value="<?php  echo $article['article_keyword2'];?>" placeholder="页面关键字">
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label">文章描述</label>
	<div class="col-sm-9 col-xs-12">
		<textarea class="form-control" rows="5" name="resp_desc"><?php  echo $article['resp_desc'];?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label">封面图片</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_image2('resp_img',$article['resp_img'])?>
	</div>
</div>