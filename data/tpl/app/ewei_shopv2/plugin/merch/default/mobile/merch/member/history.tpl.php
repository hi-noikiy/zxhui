<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.fui-list-group-title{
		position: relative;
	}
	.fui-list-group-title:after{
		content: " ";
		position: absolute;
		left: 0;
		top: 0;
		right: .5rem;
		height: 1px;
		border-top: 1px solid #ebebeb;
		color: #ebebeb;
		-webkit-transform-origin: 0 0;
		-ms-transform-origin: 0 0;
		transform-origin: 0 0;
		-webkit-transform: scaleY(0.5);
		-ms-transform: scaleY(0.5);
		transform: scaleY(0.5);
		left: .5rem;
	}
	.pull-left i{
		margin-right: .3rem;
	}
	.pull-left{
		-webkit-box-flex: 1;
		-webkit-flex: 1;
		-ms-flex: 1;
		flex: 1;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	.fui-list-group-title{
		font-size: .65rem;
		display: -webkit-box;
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		-webkit-box-pack: justify;
		-ms-flex-pack: justify;
		-webkit-justify-content: space-between;
		justify-content: space-between;
	}
	.member-cart-page .fui-radio{
		position: static;
	}
</style>
<div class='fui-page   fui-page-current member-cart-page'>
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title">我的足迹</div> 
	<div class="fui-header-right">
		<a class="btn-edit" style="display:none">编辑</a>
	</div>
    </div>

    <div class='fui-content' >

	<div class='content-empty' style='display:none;'>
	     <i class='icon icon-like'></i><br/>您还没有浏览过任何商品，何不现在就去逛逛~<br/><a href="<?php  echo mobileUrl()?>" class='btn btn-default-o external'>去逛逛吧~</a>
	</div>
	  <div class='fui-list-group container' style="display:none;"></div>
	  <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>
    </div>
    <div class="fui-footer editmode">
	<div class="fui-list noclick">
	    <div class="fui-list-media">
		<label class="checkbox-inline editcheckall"><input type="checkbox" name="checkbox" class="fui-radio fui-radio-danger " />&nbsp;全选</label>
	    </div>
		<div class="fui-list-inner"></div>

	    <div class='fui-list-angle'>
		<div class="btn  btn-danger btn-delete  disabled">删除</div>
	    </div>
	</div>
    </div>
 
    <script id="tpl_member_history_list" type="text/html">
	 
	    <%each list as g index%>
	    <div class="fui-list-group-title text-cancel"><div class="pull-left" style="color: #000;font-size: .7rem"><i class="icon icon-dianpu1"></i><%g.merchname%></div><div class="pull-right"><%g.createtime%></div></div>
	    <div class="fui-list goods-item align-start" data-id="<%g.id%>" data-goodsid="<%g.goodsid%>">
		<div class="fui-list-media editmode">
		   <input type="checkbox" name="checkbox" class="fui-radio fui-radio-danger edit-item"/>
		</div> 

		<div class="fui-list-media image-media" style="margin-left: 0;font-size: .75rem;">
		    <a href="<?php  echo mobileUrl('goods/detail')?>&id=<%g.goodsid%>">
			<img data-lazy="<%g.thumb%>" class="round">
		    </a>
		</div>
		<div class="fui-list-inner">
		    <a href="<?php  echo mobileUrl('goods/detail')?>&id=<%g.goodsid%>">
			<div class="subtitle">
			  <%g.title%>
			</div>
		    </a>
		     <div class="text" style="margin-bottom: .3rem;font-size: .75rem;"><span class="text-danger">￥<%g.marketprice%><%if g.productprice>0%></span> <span class='oldprice'>￥<%g.productprice%></span><%/if%></div>
		   
		</div>
			<div class="historycover" style="width: 90%;position: absolute;top: 0;;right: 0;height: 100%;display: none"></div>
		</div>
	  <%/each%>
    </script>
    <script language='javascript'>require(['biz/member/history'], function (modal) {
                modal.init();
     });</script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
