<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.1&key=1fb308f0707e5ff11db5997d42660396&plugin=AMap.Driving"></script>
<style type="text/css">
	.info {
		border: solid 1px silver;
		width: 12.5rem;
		color: #000;
	}
	div.info-top {
		position: relative;
		background: none repeat scroll 0 0 #fff;
	}
	div.info-top div {
		display: inline-block;
		color: #000;
		font-size: .7rem;
		line-height: .775rem;
		padding: .25rem .25rem 0;
	}
	div.info-top img {
		position: absolute;
		top: .5rem;
		right: .5rem;
		width: .6rem;
		transition-duration: 0.25s;
	}
	div.info-top img:hover {
		box-shadow: 0px 0px .125rem #000;
	}
	div.info-middle {
		font-size: .3rem;
		padding: .75rem;
		line-height: .5rem;
		height: 5.2rem;
	}
	div.info-middle .info-title{
		line-height: 1rem;
		font-size: .7rem;
	}
	div.info-bottom {
		height: 0px;
		width: 100%;
		clear: both;
		text-align: center;
	}
	div.info-bottom img {
		position: relative;
		z-index: 104;
	}
	span {
		margin-left: .125rem;
		font-size: .275rem;
	}
	.info-middle img {
		float: left;
		margin-right: .15rem;
	}
	.store-map-page .info-window .address{
		max-height: 1.7rem;
	}
	.store-map-page .info-window .navi {
		position: absolute;
		right: .9rem;
		bottom: .9rem;
		font-size: .7rem;
	}
</style>
<div class='fui-page  fui-page-current store-map-page' >

    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title">门店地图</div> 
	<div class="fui-header-right">&nbsp;</div>
    </div>
    <div class='fui-content' >
	<div id='js-map' class='map-container'></div>
	<div class='fui-footer'  style='visibility: hidden;'>
	    <div class="fui-list">
		<div class="fui-list-media">
		    <img src="<?php  echo tomedia($store['logo'])?>" />
		</div>
		<div class='fui-list-inner'>
		    <div class='title'><?php  echo $store['storename'];?></div>
		    <?php  if(!empty($store['saletime'])) { ?>
		    <div class='text'>营业时间: <?php  echo $store['saletime'];?></div>
		    <?php  } ?>
		    <?php  if(!empty($store['tel'])) { ?>
		    <div class='text'>联系电话: <?php  echo $store['tel'];?></div>
		    <?php  } ?>
		</div>
		<?php  if(!empty($store['tel'])) { ?>
		<div class="fui-list-angle">
		    <a href="tel:<?php  echo $store['tel'];?>" class='external '><i class=' icon icon-phone2' style='color:green'></i></a>
		</div>
		<?php  } ?>
	    </div>
	</div>
    </div>
    <script language='javascript'>
            require(['biz/store/map'], function (modal) {
                modal.init({store: <?php  echo json_encode($store)?>, isios: "<?php echo is_h5app()&&is_ios()?1:0?>"});
            });
	</script>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>