/**
 * 企业官网 V1 公共业务
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/9/4 15:43:13] -->
 */
layui.define(['util', 'flow', 'layer', 'jquery', 'element', 'sortable', 'selector', 'php'], function(exports) {
	var $ = layui.jquery
        ,layer = layui.layer
		,util = layui.util
        ,element = layui.element
        ,flow = layui.flow
        ,sortable = layui.sortable
        ,selector = layui.selector
        ,php = layui.php;
    
    flow.lazyimg();
    
    //渲染选择器
    selector.render();

    /** 构造图片弹出层 */
    $(".right-content img").each(function() {
    	if (0 == $(this).parent("a").length && !$(this).hasClass('img-circle') && !$(this).hasClass('no-lightGallery') && !$(this).hasClass('img-thumbnail')) {
    		var t = $(this).attr("src");
    		if (!t) {
    			t = $(this).attr("lay-src");
    		}
    		$(this).wrap("<span class='lg-item-box' data-src='" + t + "' data-exthumbimage='" + t + "'></span>");
    	}
    })

    if($(".right-content img").length >0){
        $("body").addClass("bowen-white-lightGallery");
        $(".right-content").wrapInner("<div id='lightgallery'></div>");
        layui.link("../addons/bowen_site/static/lightGallery/css/lightgallery.min.css?v=20180709");
        require(['../../addons/bowen_site/static/lightGallery/js/lightgallery.min.js'], function() {
            require([
                "../../addons/bowen_site/static/lightGallery/lib/picturefill.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-autoplay.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-fullscreen.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-hash.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-pager.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-share.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-thumbnail.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-video.min.js"
                ,"../../addons/bowen_site/static/lightGallery/modules/lg-zoom.min.js"
                ,"../../addons/bowen_site/static/lightGallery/lib/jquery.mousewheel.min.js"
            ], function(){
                $("#lightgallery").lightGallery({
            		selector: ".lg-item-box",
            		exThumbImage: "data-exthumbimage",
            		share: false
            	}); 
            });
        });
    }

    //tips
    $(".right-content").on('mouseenter', '*[lay-tips]', function(){
        var othis = $(this);

        //if(othis.parent().hasClass('layui-nav-item') && !container.hasClass(SIDE_SHRINK)) return;
        var tips = (othis.attr('lay-tips') == 'theme_thumb' && othis.attr('data-thumb'))?'<img src="'+othis.attr('data-thumb')+'" width="100%" height="100%" onerror="this.src=\'../web/resource/images/nopic.jpg\'">':othis.attr('lay-tips')
            ,offset = othis.attr('lay-offset')
            ,area = php.explode('|',othis.attr('lay-area'))
            ,direction = othis.attr('lay-direction')
            ,index = layer.tips(tips, this, {
            tips: direction || 1
            ,time: -1
            ,area: area || 'auto'
            ,success: function(layero, index){
                if(offset){
                    layero.css('margin-left', offset + 'px');
                }
            }
        });
        othis.data('index', index);
    }).on('mouseleave', '*[lay-tips]', function(){
        layer.close($(this).data('index'));
    });
    
	util.fixbar({
        css: {right: 25,bottom: 50}
        ,click: function(type){
            if(type === 'top'){
                $('.right-content').animate({ scrollTop: 0 }, 500);
            }
        }
    });
    
    /** 监听点击事件 */
    var active = {
        clip:function() {
            var data_href = this.getAttribute('data-href');
            clip(this, data_href);
        }
    };
    $('.onclick').on('click', function() {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    
    $(".onclick").each(function() {
        if($(this).data('type') == 'clip' && $(this).attr("data-href")){
            clip(this, $(this).attr("data-href"))
        }
	});
    
    function clip(e, t) {
        require(["clipboard"], function(i) {
            var o = new i(e, {
                text: function() {
                    return t
				}
			});
			o.on("success", function(e) {
				layer.msg("复制成功", {icon: 1}), e.clearSelection()
			}), o.on("error", function(e) {
                layer.msg("复制失败，请重试", {icon: 5});
			})
		})
    }
    
    $(function () {
        
        if($("ol.banner").length>0){
            $("ol.banner").sortable({handle: '.input-group-addon'});
        }
        if($("ol.advantages").length>0){
            $("ol.advantages").sortable({handle: '.input-group-addon'});
        }
        if($("ol.contents").length>0){
            $("ol.contents").sortable({handle: '.mmove'});
        }
        if($('.multi-img-details').length > 0){
            require(['jquery.ui'],function(){
                $('.multi-img-details').sortable();
            })
        }
        /** 页面滚动监听 */
        $('.right-content').scroll(function () {
            if ($('.right-content').scrollTop() >= 200) {
                $('.layui-fixbar-top').show();
            }
            else {
                $('.layui-fixbar-top').hide();
            }
            $(".edui-editor-toolbarbox").each(function() {
                var h1 = 110, h2 = 130, top = '60px';
                if(global.isiframe == 1){h1 = 50; h2 = 70; top = '0px';}
           	    if ($(this).offset().top + $(this).height() > h1) {
                    $(this).css({'position': 'static'});
                }
                if ($(this).offset().top + $(this).height() <= h1 && $(this).next().next().children().children().children().children('.edui-editor-wordcount').offset().top > h2) {
                    var new_width = $(this).width();
                    $(this).css({'width': new_width+'px', 'z-index': '1000', 'position': 'fixed', 'top': top});
                }
            })
            
        });
        
        /** 单独加载一些JS */
        /**
        var loadJS = function(url) {
            loadScript = document.createElement("script");
            loadScript.type = "text/javascript";
            loadScript.src = url;
            document.body.appendChild(loadScript);
        }
        
        loadJS("../addons/bowen_site/static/layui/mylayui/selector.js?v=201806041050");*/
        
        //监听键盘事件
        $(document).keypress(function(e){
            //回车搜索
            if($(".search-btn").length > 0 && e.which == 13){
                $(".search-btn").click();
            }
        });
        
        /** 显示目录 */
        var siteDir = $('.site-dir');
        if (siteDir[0] && $(window).width() > 991) {
            var siteDir_title = siteDir.data('title');
        	layer.ready(function() {
        		var site_dir = function(){
                    layer.open({
                        type: 1,
                        zIndex: 999,
                        content: siteDir,
                        skin: 'layui-layer-dir',
                        maxWidth: '200px',
                        maxHeight: $(window).height() - 300,
                        title: (siteDir_title?siteDir_title:'目录'),
                        offset: 'r',
                        shade: false,
                        success: function(layero, index) {
                            layer.style(index, {
                                marginLeft: -15
                            });
                        },
                        end: function(){
                            siteDir.hide();
                            var small_site_dir = layer.open({
                                type: 1,
                                zIndex: 999,
                                id: 'small_site_dir',
                                content: '' +
                                    '<style>' +
                                    '#small_site_dir.layui-layer-content {padding: 10px;}' +
                                    '#small_site_dir span {color: #fff;}' +
                                    '</style>' +
                                    '<span>快<br/>捷<br/>导<br/>航</span>',
                                title: false,
                                offset: 'r',
                                shade: false,
                                closeBtn: false,
                                success: function(layero, index) {
                                    layer.style(index, {
                                        marginLeft: -15
                                        ,backgroundColor: '#009688'
                                        ,cursor: 'pointer'
                                    });
                                    $('#small_site_dir').on('click', function() {
                                        layer.close(small_site_dir);
                                    });
                                },
                                end: function(){
                                    site_dir();
                                }
                            });
                        }
                    });
                }
                site_dir();

        	});
        }else{
            siteDir.hide();
        }
    });
    
	exports('global', {});
});