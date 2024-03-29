<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>
<style>
    .btn.btn-default-o{
        border-radius: 1rem;
        line-height: 1.1rem;
        height: 1.2rem;
        padding: 0 1rem;
        font-size: .6rem;
    }
    .towline{
        color: #000;
        font-size: 0.7rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }
    .fui-list-inner .text{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between;
        font-size: .7rem;
        color: #000;
    }
    .goods-selected .fui-list-inner{
        height: 4rem;
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        flex-direction: column;
        -webkit-flex-direction: column;
        justify-content: space-between;
        -webkit-justify-content: space-between;
    }
</style>
<div class="fui-page fui-page-current ">
	<div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">自选商品</div>
    </div>
	<div class='fui-content navbar'>
		<div class='fui-cell-group'>
			<div class='fui-cell'>
				<div class='fui-cell-info'>
					<div class="title">开启自选</div>
					<div class="subtitle">开启自选后，您的<?php  echo $this->set['texts']['shop']?>里只显示您选择的产品</div>
				</div>
				<div class='fui-cell-remark noremark'><input type='checkbox' id="openselect" class='fui-switch fui-switch-success fui-switch-small' <?php  if(!empty($shop['selectgoods'])) { ?>checked<?php  } ?>/></div>
			</div>
		</div>
		
		<div id="divselect" class='fui-cell-group' <?php  if(empty($shop['selectgoods'])) { ?>style='display:none'<?php  } ?>  >
			 <?php  if($_W['shopset']['shop']['category']['level']!=-1) { ?>
		         <div class='fui-cell'>
				<div class='fui-cell-info'>
					<div class="title">开启分类</div>
					<div class="subtitle">如果您选择的商品较多，建议您开启与总店同步分类</div>
				</div>
				<div class='fui-cell-remark noremark'><input type='checkbox' id="opencategory" class='fui-switch fui-switch-success fui-switch-small' <?php  if(!empty($shop['selectcategory'])) { ?>checked<?php  } ?> /></div>
			</div>
			 <?php  } ?>
			  <div class='fui-cell'>
				<div class='fui-cell-info'>选择商品</div>
				<div class='fui-cell-remark noremark'><a class="text-warning" href="#myshop-select-goods"><i class="icon icon-add" style="font-size: .6rem"></i>添加商品</a></div>
			</div>
			<div id='goods-container' class='fui-list-group goods-selected-group' style="margin-top: 0">
				<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
						<div class='fui-list goods-selected' data-goodsid='<?php  echo $g['id'];?>'>
					<div class='fui-list-media'>
							<img src='<?php  echo tomedia($g['thumb'])?>' class='round' style="width: 4rem;height:4rem" />
					</div>
					<div class='fui-list-inner'>
							<div class='towline'><?php  echo $g['title'];?></div>
							<div class='text'><span class="bigprice" >￥<?php  echo $g['marketprice'];?></span><div class='btn btn-default-o btn-sm btn-delete'>删除</div></div>
						</div>
					 </div>
				<?php  } } ?>
			</div>
		</div>
		
		<div class='btn btn-warning block btn-submit mtop'>保存设置</div>
	</div>
	 
</div>


<div class="fui-page fui-page page-commission-selectgoods" id="myshop-select-goods">
	
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">选择商品</div>
		<div class="fui-header-right" onclick='history.back()' >完成</div>
    </div>
    <div class="fui-content navbar">
	<div class="fui-fullHigh-group" >
      
        <div class="fui-fullHigh-item menu" id="tab">
            <nav class="on">全部商品</nav>
	   <nav data-isnew="1">新上宝贝</nav>
	   <nav data-isrecommand="1">推荐宝贝</nav>
	   <nav data-istime="1">限时秒杀</nav>
    	   <nav data-isdiscount="1" >促销宝贝</nav>
		   <?php  if($_W['shopset']['category']['level']!='-1') { ?>
		   <?php  if(is_array($category['parent'])) { foreach($category['parent'] as $c1) { ?>
		          <?php  if(!$c1['enabled']) { ?><?php  continue;?><?php  } ?>
			<nav data-cate="<?php  echo $c1['id'];?>"><?php  echo $c1['name'];?></nav>
			  <?php  if(intval($_W['shopset']['category']['level'])>=2) { ?>
				<?php  if(is_array($category['children'][$c1['id']])) { foreach($category['children'][$c1['id']] as $c2) { ?>
				        <?php  if(!$c2['enabled']) { ?><?php  continue;?><?php  } ?>
					<nav data-cate="<?php  echo $c2['id'];?>"><?php  echo $c2['name'];?></nav>
					 <?php  if(intval($_W['shopset']['category']['level'])>=3) { ?>
					 	<?php  if(is_array($category['children'][$c2['id']])) { foreach($category['children'][$c2['id']] as $c3) { ?>
						    <?php  if(!$c3['enabled']) { ?><?php  continue;?><?php  } ?>
					             <nav data-cate="<?php  echo $c3['id'];?>"><?php  echo $c3['name'];?></nav>
					        <?php  } } ?>
					 <?php  } ?>
				<?php  } } ?>
			  <?php  } ?>
		   <?php  } } ?>
		   <?php  } ?>
        </div>
        <div class="fui-fullHigh-item container ">
	  
	   <form method="post" action="<?php  echo mobileUrl('goods')?>">
                <div class="searchbar" style='margin:0;padding:0'>
                    <div class="search-input">
                        <i class="icon icon-search"></i>
                        <input type="search" id='keywords' name="keywords" placeholder="输入关键字...">
                    </div>
                </div>
            </form>
	    <p class='text-center text-cancel empty' style='display: none;'>暂时没有任何商品</p>
	    <div class='fui-list-group goods-list-group' style='margin-top:0;display: none'></div>
	    <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>
	   
        </div> 
    </div>
</div>
	<script id='tpl_commission_goods_select' type='text/html'>
		<%each list as g%>
		<div class='fui-list goods-item' 
			 data-goodsid='<%g.id%>'
			 data-title='<%g.title%>'
			 data-marketprice='<%g.marketprice%>'
			 data-thumb='<%g.thumb%>'
			 >
					<div class='fui-list-media'>
						<img data-lazy='<%g.thumb%>' class='round'/>
					</div>
					<div class='fui-list-inner'>
						<div class='subtitle'><%g.title%></div>
						<div class='text'><span class='text-danger'>￥<%g.marketprice%></span><input type='checkbox' class='fui-switch fui-switch-warning fui-switch-small' /></div>
					</div>
				  </div>
		<%/each%>
	</script>
	
	<script id='tpl_commission_goods_item' type='text/html'>
		 
		<div class='fui-list goods-selected' data-goodsid='<%g.id%>'>
			<div class='fui-list-media'>
					<img src='<%g.thumb%>' class='round'  style="width: 4rem"/>
			</div>
			<div class='fui-list-inner'>
					<div class='towline'><%g.title%></div>
					<div class='text'><span class="bigprice">￥<%g.marketprice%></span><div class='btn btn-default-o btn-sm btn-delete'>删除</div></div>
				</div>
			 </div>
		 
	</script>

	<script language='javascript'>
		require(['../addons/ewei_shopv2/plugin/commission/static/js/myshop.js'], function (modal) {
			modal.initSelect();
	});
</script>

</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>